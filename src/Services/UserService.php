<?php

namespace BondarDe\Lox\Services;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;

class UserService
{
    public function findById(int $id): ?User
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return User::query()
            ->find($id);
    }

    public function findByEmail(string $email): ?User
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return User::query()
            ->where(User::FIELD_EMAIL, $email)
            ->first();
    }

    public function delete(User $user)
    {
        $user = $user->fresh();
        $user->deleteProfilePhoto();
        $user->tokens->each->delete();

        $user->delete();
    }

    public function deleteOtherSessionRecords(User $user, string $currentSessionId): void
    {
        if (config('session.driver') !== 'database') {
            return;
        }

        DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
            ->where('user_id', $user->getAuthIdentifier())
            ->where('id', '!=', $currentSessionId)
            ->delete();
    }

    public function getSessions(User $user): Collection
    {
        if (config('session.driver') !== 'database') {
            return collect();
        }

        $sessions = DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
            ->where('user_id', $user->getAuthIdentifier())
            ->orderBy('last_activity', 'desc')
            ->get();

        return collect($sessions)->map(function ($session) {
            $attributes = [
                'agent' => self::makeAgent($session),
                'ip_address' => $session->ip_address,
                'is_current_device' => $session->id === request()->session()->getId(),
                'last_active' => Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
            ];

            return (object)$attributes;
        });
    }

    private function makeAgent($session)
    {
        return tap(new Agent, function ($agent) use ($session) {
            $agent->setUserAgent($session->user_agent);
        });
    }

    public function update(
        User   $user,
        array  $attributes,
        ?array $roleIds = null,
        ?array $permissionIds = null
    ): void
    {
        $user->update($attributes);

        if (!is_null($roleIds)) {
            $user->roles()->sync($roleIds);
        }
        if (!is_null($permissionIds)) {
            $user->permissions()->sync($permissionIds);
        }
    }
}
