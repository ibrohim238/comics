<?php

namespace App\Providers;

use App\Models\Chapter;
use App\Models\Filter;
use App\Models\Manga;
use App\Models\Team;
use App\Policies\ChapterPolicy;
use App\Policies\FilterPolicy;
use App\Policies\MangaPolicy;
use App\Policies\TeamPolicy;
use Carbon\Carbon;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Manga::class => MangaPolicy::class,
        Chapter::class => ChapterPolicy::class,
        Team::class => TeamPolicy::class,
        Filter::class => FilterPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        VerifyEmail::createUrlUsing(function ($notifiable) {
            return remove_api_segment(URL::temporarySignedRoute(
                'verification.verify',
                Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
                [
                    'id' => $notifiable->getKey(),
                    'hash' => sha1($notifiable->getEmailForVerification()),
                ]
            ));
        });
    }
}
