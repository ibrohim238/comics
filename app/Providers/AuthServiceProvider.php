<?php

namespace App\Providers;

use App\Enums\PermissionEnum;
use App\Enums\TeamPermissionEnum;
use App\Models\Chapter;
use App\Models\ChapterTeam;
use App\Models\Coupon;
use App\Models\Filter;
use App\Models\Manga;
use App\Models\Team;
use App\Models\TeamUser;
use App\Models\User;
use App\Policies\ChapterPolicy;
use App\Policies\ChapterTeamPolicy;
use App\Policies\CouponPolicy;
use App\Policies\FilterPolicy;
use App\Policies\MangaPolicy;
use App\Policies\TeamPolicy;
use App\Policies\TeamUserPolicy;
use App\Policies\UserPolicy;
use Carbon\Carbon;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
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
        User::class => UserPolicy::class,
        Coupon::class => CouponPolicy::class,
        ChapterTeam::class => ChapterTeamPolicy::class,
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
            return $user->hasTeamPermission($team, TeamPermissionEnum::MANAGE_USER);
        });
        Gate::define('removeTeamMember', function (User $user, Team $team) {
            return $user->hasTeamPermission($team, TeamPermissionEnum::MANAGE_USER);
        });
        Gate::define('teamInvitation', function (User $user, Team $team) {
            return $user->hasTeamPermission($team, TeamPermissionEnum::MANAGE_INVITATION);
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
