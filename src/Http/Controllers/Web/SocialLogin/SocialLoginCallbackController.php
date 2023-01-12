<?php

namespace BondarDe\LaravelToolbox\Http\Controllers\Web\SocialLogin;

use App\Models\User;
use BondarDe\LaravelToolbox\Exceptions\SocialLoginErrorException;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class SocialLoginCallbackController
{
    public function redirectToProvider(string $provider)
    {
        return Socialite::driver($provider)
            ->redirect();
    }

    public function __invoke(
        string  $provider,
        Request $request,
    )
    {
        if ($request->has('error')) {
            $error = $request->get('error');
            self::logLoginError($error, $request);

            return self::toRedirect($provider);
        }

        try {
            $user = self::toUser($provider);
        } catch (Exception $e) {
            self::logLoginError('Fetching user failed', $request, $e);

            return self::toRedirect($provider);
        }

        $id = $user->id;
        $email = $user->email;
        $name = $user->name;

        if (!$email) {
            // generate unique email if none received from login provider
            $email = $provider . '-login-' . $id . '@example.com';
        }

        $user = User::findOrCreateUserForSocialProvider($provider, $id, $email, $name);

        Auth::login($user, true);

        $message = __('You successfully signed in with :provider!', ['provider' => ucfirst($provider)]);

        return to_route('home')
            ->with('success-message', $message);
    }

    private static function logLoginError(string $message, Request $request, Throwable $previous = null)
    {
        $socialLoginErrorException = new SocialLoginErrorException($message, 0, $previous);

        app('sentry')->captureException($socialLoginErrorException);
    }

    private static function toUser(string $provider)
    {
        $driver = match ($provider) {
            'twitter' => Socialite::with('Twitter'),
            default => Socialite::driver($provider)->stateless(),
        };

        return $driver->user();
    }

    private static function toRedirect(string $provider)
    {
        $message = __('Login with :provider failed.', ['provider' => ucfirst($provider)]);

        return redirect(route('login'))
            ->with('error-message', $message);
    }
}
