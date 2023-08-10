<?php

namespace BondarDe\Lox\Models\Columns;

use BondarDe\Lox\Livewire\ModelList\Columns\ColumnConfigurations;
use BondarDe\Lox\Livewire\ModelList\Data\ColumnConfiguration;
use BondarDe\Lox\Models\User;

class UserColumns extends ColumnConfigurations
{
    public static function all(): array
    {
        return [
            User::FIELD_NAME => new ColumnConfiguration(
                label: __('Name'),
                render: function (User $user, ?string $q): string {
                    $link = route('admin.users.show', $user);

                    return '
                    <a
                        class="link"
                        href="' . $link . '"
                    >'
                        . self::highlightSearchQuery($user->{User::FIELD_NAME}, $q)
                        . '</a>';
                },
            ),
            User::FIELD_EMAIL => new ColumnConfiguration(
                label: __('E-Mail Address'),
                render: function (User $user, ?string $q): string {
                    return self::highlightSearchQuery($user->{User::FIELD_EMAIL}, $q);
                },
            ),
            'roles' => new ColumnConfiguration(
                label: __('Roles'),
                render: function (User $user): string {
                    return view('lox::admin.users._assigned_roles', ['roles' => $user->roles, 'emptyText' => '—']);
                },
            ),
            'permissions' => new ColumnConfiguration(
                label: __('Permissions'),
                render: function (User $user): string {
                    return view('lox::admin.users._assigned_permissions', ['permissions' => $user->permissions, 'emptyText' => '—']);
                },
            ),
        ];
    }
}
