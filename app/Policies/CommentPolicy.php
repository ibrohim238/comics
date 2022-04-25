<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;


    public function viewAny(?User $user): bool
    {
        return true;
    }


    public function view(?User $user): bool
    {
        return true;
    }


    public function create(User $user): bool
    {
        return true;
    }


    public function update(User $user, Comment $comment): bool
    {
        return $comment->user()->is($user);
    }

    public function delete(User $user, Comment $comment): bool
    {
        return $comment->user()->is($user) || $user->hasPermissionTo(PermissionEnum::MANAGE_COMMENT->value);
    }

    public function restore(User $user, Comment $comment): bool
    {
        return $comment->user()->is($user) || $user->hasPermissionTo(PermissionEnum::MANAGE_COMMENT->value);
    }

    public function forceDelete(User $user): bool
    {
        //
    }
}
