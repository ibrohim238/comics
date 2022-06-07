<?php

namespace App\Versions\V1\Reporters;

use App\Enums\RatesTypeEnum;
use App\Interfaces\Rateable;
use App\Models\Rate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class RateReporter
{
    private ?int $userId = null;
    private ?string $type = null;
    private ?Rateable $rateable = null;

    public function userId(int $userId): static
    {
        $this->userId = $userId;

        return $this;
    }

    public function type(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function rateable(Rateable $rateable): static
    {
        $this->rateable = $rateable;

        return $this;
    }

    public static function fromRateable(Rateable $rateable): static
    {
        return (new static())->rateable($rateable);
    }

    public function builder(): Builder
    {
        return Rate::query()
            ->when($this->type, function (Builder $query, string $type) {
                $query->where('type', $type);
            })
            ->when($this->userId, function (Builder $query, int $userId) {
                $query->where('user_id', $userId);
            })
            ->when($this->rateable, function (Builder $query, Rateable $rateable) {
                $query->whereMorphedTo('rateable', $rateable);
            });
    }

    public function relation(): MorphMany
    {
        if (! $this->rateable) {
            throw new \LogicException('error');
        }

        return $this->rateable->rates()
            ->when($this->type, function (Builder $query, string $type) {
                $query->where('type', $type);
            })
            ->when($this->userId, function (Builder $query, int $userId) {
                $query->where('user_id', $userId);
            });
    }

    public function avg()
    {
        if ($this->type == RatesTypeEnum::LIKE_TYPE->value) {
            throw new \LogicException('U can`t count avg `like` type ratings');
        }

        return $this->builder()
            ->avg('value');
    }

    public function count(): int
    {
        return $this->builder()->count();
    }

    public function likesCount(): int
    {
        return $this->builder()
            ->where('type', RatesTypeEnum::LIKE_TYPE->value)
            ->where('value', true)
            ->count();
    }

    public function dislikesCount(): int
    {
        return $this->builder()
            ->where('type', RatesTypeEnum::LIKE_TYPE->value)
            ->where('value', false)->count();
    }
}
