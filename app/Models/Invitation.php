<?php

namespace App\Models;

use App\Enums\InvitationStatusEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Invitation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'data',
        'ends_at',
        'status',
    ];

    protected $casts = [
        'data' => 'json',
        'ends_at' => 'datetime',
        'status' => InvitationStatusEnum::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function invited(): MorphTo
    {
        return $this->morphTo();
    }

    public function accept()
    {
        if ($this->checked()) {
            $this->user->addToTeam($this->team, $this->data->role);

            $this->update(['status' => InvitationStatusEnum::ACCEPTED_STATUS]);
        }
    }

    public function reject()
    {
        if ($this->checked())
            $this->update(['status' => InvitationStatusEnum::REJECTED_STATUS]);

    }

    public function checked(): bool
    {
        return $this->ends_at >= Carbon::now() && empty($this->status);
    }
}
