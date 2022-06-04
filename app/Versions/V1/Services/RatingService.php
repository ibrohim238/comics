<?php

namespace App\Versions\V1\Services;

use App\Exceptions\RatingsException;
use App\Interfaces\Rateable;
use App\Models\User;
use App\Versions\V1\Dto\RateDto;
use App\Versions\V1\Reporters\RateReporter;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Lang;

class RatingService
{
    public function __construct(
        private Rateable     $rateable,
        private User         $user,
        private RateReporter $reporter,
    ) {
    }

    public function rate(RateDto $dto)
    {
        if ($this->exists($dto->type)) {
            $this->getRatesWithType($dto->type)
                ->update(
                    $dto
                        ->except('type')
                        ->toArray()
                );
            return Lang::get('rateable.update', ['type' => $dto->type]);
        }

        $this->getRatesWithType($dto->type)
            ->create($this->prepareData($dto));

        return Lang::get('rateable.create', ['type' => $dto->type]);
    }

    public function unRate(string $type): bool|int
    {
        if (!$this->exists($type)) {
            throw RatingsException::notFound($type);
        }

        return $this->getRatesWithType($type)
            ->delete();
    }

    public function exists(string $type): bool
    {
        return $this->getRatesWithType($type)
            ->exists();
    }

    public function getRatesWithType(string $type): MorphMany
    {
        return $this->reporter
            ->userId($this->user->id)
            ->type($type)
            ->rateable($this->rateable)
            ->relation();
    }

    private function prepareData(RateDto $dto): int|array
    {
        return array_merge($dto->toArray(), ['user_id' => $this->user->id]);
    }
}
