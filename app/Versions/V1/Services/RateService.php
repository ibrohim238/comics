<?php

namespace App\Versions\V1\Services;

use App\Enums\RateTypeEnum;
use App\Exceptions\RatingsException;
use App\Interfaces\Rateable;
use App\Models\User;
use App\Versions\V1\Dto\RateDto;
use App\Versions\V1\Repositories\RateRepository;
use Illuminate\Support\Facades\Lang;

class RateService
{
    private RateRepository $repository;

    public function __construct(
        private Rateable     $rateable,
        private User         $user,
        private RateTypeEnum $type,
    ) {
        $this->repository = app(RateRepository::class, [
            'rateable' => $this->rateable,
            'user' => $this->user,
            'type' => $this->type
        ]);
    }

    public function rate(RateDto $dto = null)
    {
        $this->repository
            ->rate($dto?->toArray());

        return Lang::get('rateable.create');
    }

    public function unRate(): void
    {
        if ($this->repository->exists()) {
            throw RatingsException::notFound();
        }

        $this->repository->unRate();
    }
}
