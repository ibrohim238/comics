<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CouponPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(PermissionEnum::MANAGE_COUPON->value);
    }

    public function view(User $user): bool
    {
        return $user->hasPermissionTo(PermissionEnum::MANAGE_COUPON->value);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo(PermissionEnum::MANAGE_COUPON->value);
    }

    public function update(User $user): bool
    {
        return $user->hasPermissionTo(PermissionEnum::MANAGE_COUPON->value);
    }

    public function delete(User $user): bool
    {
        return $user->hasPermissionTo(PermissionEnum::MANAGE_COUPON->value);
    }

    public function restore(User $user): bool
    {
        return $user->hasPermissionTo(PermissionEnum::MANAGE_COUPON->value);
    }

    public function forceDelete(User $user): bool
    {
        return $user->hasPermissionTo(PermissionEnum::MANAGE_COUPON->value);
    }
}
