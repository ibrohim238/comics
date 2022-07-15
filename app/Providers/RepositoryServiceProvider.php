<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
//        $this->app->when(MangaRepository::class)
//            ->needs('$builder')
//            ->give((new Manga())->newQuery());

//        $this->app->when([MangaController::class])
//            ->needs(MangaRepository::class)
//            ->give(app(MangaRepository::class, ['builder' => new Manga()]));
    }

    public function boot()
    {
    //        $this->app->when(MangaRepository::class)
    //            ->needs('$manga')
    //            ->give((new Manga()));
    //
    }
}
