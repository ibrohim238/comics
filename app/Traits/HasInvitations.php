<?php

namespace App\Traits;

use App\Interfaces\Invited;
use App\Models\Invitation;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasInvitations
{
    public static function bootHasInvitations()
    {
        static::deleting(function (Invited $model) {
            if (method_exists($model, 'isForceDeleting') && ! $model->isForceDeleting()) {
                return;
            }

            $model->invitations()->delete();
        });
    }

    public function invitations(): MorphMany
    {
        return $this->morphMany(Invitation::class, 'invited');
    }
}
