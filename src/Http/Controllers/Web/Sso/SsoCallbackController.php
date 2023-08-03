<?php

namespace BondarDe\Lox\Http\Controllers\Web\Sso;

use App\Models\User;
use BondarDe\Lox\Exceptions\SocialLoginErrorException;
use BondarDe\Lox\Repositories\UserRepository;
use BondarDe\Lox\Services\AppleToken;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class SsoCallbackController extends SsoController
{
    public function __invoke(
        string         $provider,
        Request        $request,
        AppleToken     $appleToken,
        UserRepository $userRepository,
    )
    {
        $this->validateSsoProvider($provider, $request);

        if ($provider === 'apple') {
            config()->set('services.apple.client_secret', $appleToken->generate());
        }

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
        $name = trim(match ($provider) {
            'apple' => $user?->name?->firstName . ' ' . $user?->name?->lastName,
            default => $user?->name,
        }) ?: (ucfirst($provider) . ' User ' . $id);

        if (!$email) {
            // generate unique email if none received from login provider
            $email = $provider . '-login-' . $id . '@example.com';
        }

        $user = $userRepository->findOrCreateUserForSsoProvider($provider, $id, $email, $name);

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
