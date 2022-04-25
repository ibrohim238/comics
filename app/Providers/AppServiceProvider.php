<?php

namespace App\Providers;

use App\Models\Chapter;
use App\Models\Manga;
use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        ResetPassword::createUrlUsing(function ($notifiable, string $token) {
            return config('app.url').'/reset-password?token='.$token.'&email='.urlencode($notifiable->email);
        });

        Relation::enforceMorphMap([
            'user' => User::class,
            'manga' => Manga::class,
            'chapter' => Chapter::class,
            'team' => Team::class
        ]);
    }
}
