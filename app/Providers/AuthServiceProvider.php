<?php

namespace App\Providers;

use App\Enums\PermissionEnum;
use App\Enums\TeamPermissionEnum;
use App\Models\Chapter;
use App\Models\Coupon;
use App\Models\Manga;
use App\Models\Team;
use App\Models\User;
use App\Policies\ChapterPolicy;
use App\Policies\CouponPolicy;
use App\Policies\MangaPolicy;
use App\Policies\TagPolicy;
use App\Policies\TeamPolicy;
use App\Policies\UserPolicy;
use Carbon\Carbon;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Laravel\Passport\Passport;
use IAleroy\Tags\Tag;

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
        Tag::class => TagPolicy::class,
        User::class => UserPolicy::class,
        Coupon::class => CouponPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::define('attach_teamable', function (User $user) {
            return $user->hasPermissionTo(PermissionEnum::MANAGE_TEAMABLE->value);
        });
        Gate::define('detach_teamable', function (User $user) {
            return $user->hasPermissionTo(PermissionEnum::MANAGE_TEAMABLE->value);
        });
        Gate::define('updateTeamMember', function (User $user, Team $team) {
            return $user->hasTeamPermission($team, TeamPermissionEnum::MANAGE_MANGA->value);
        });
        Gate::define('removeTeamMember', function (User $user, Team $team) {
            return $user->hasTeamPermission($team, TeamPermissionEnum::MANAGE_USER->value);
        });
        Gate::define('teamInvitation', function (User $user, Team $team) {
            return $user->hasTeamPermission($team, TeamPermissionEnum::MANAGE_INVITATION->value);
        });

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
