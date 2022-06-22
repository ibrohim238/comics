<?php

namespace App\Providers;

use App\Models\Manga;
use App\Versions\V1\Repository\MangaRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            MangaRepository::class,
            fn () => new MangaRepository(new Manga())
        );
    }

    public function boot()
    {
        //
    }
}
