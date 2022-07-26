<?php

namespace App\Versions\V1\Repositories;

use App\Enums\RateTypeEnum;
use App\Interfaces\Rateable;
use App\Models\User;
use App\Versions\V1\Reporters\RateReporter;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class RateRepository
{
    public function __construct(
        private Rateable $rateable,
        private User $user,
        private RateTypeEnum $type,
    ) {
    }

    public function rate(?array $data): static
    {
        if (is_null($data)) {
            $this->rateable
                ->rates()
                ->create($this->prepareData());

            return $this;
        }

        $this->rateable->rates()
            ->updateOrCreate(
                $this->prepareData(), $data
            );

        return $this;
    }

    public function unRate(): static
    {
        $this->getRatesWithType()
            ->delete();

        return $this;
    }

    public function prepareData(): array
    {
        return [
            'user_id' => $this->user->id,
            'type' => $this->type->value,
        ];
    }

    public function exists(): bool
    {
        return $this->getRatesWithType()
            ->exists();
    }

    public function getRatesWithType(): MorphMany
    {
        return app(RateReporter::class)
            ->userId($this->user->id)
            ->type($this->type->value)
            ->rateable($this->rateable)
            ->relation();
    }
}