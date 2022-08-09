<?php

namespace App\Providers;

use App\Models\Chapter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {

//        Route::bind('chapter', function (string $chapter) {
//            $teamId = request()->route('team');
//            $mangaSlug = request()->route('manga');
//
//            [$volume, $number] = explode('-', $chapter);
//            return Chapter::query()
//                ->whereHas('manga', fn (Builder $builder) => $builder->where('slug', $mangaSlug))
//                ->where('team_id', $teamId)
//                ->where('number', $number)
//                ->where('volume', $volume)
//                ->firstOrFail();
//        });

        Route::pattern('id', '[0-9]+');

//        Route::bind('identifyModel', function (string $identifyModel) {
//            [$type, $id] = explode(':', $identifyModel);
//
//            $model = Relation::getMorphedModel($type);
//
//            /* @var Model $model*/
//            return $model::findOrFail($id);
//        });

        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
