<?php



namespace App\Providers;

use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
        });
    }

    protected function configureRateLimiting()
    {
        // Define a rate limit for API routes: 2 requests per minute
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(2)->by(optional($request->user())->id ?: $request->ip());
        });

        // Define a custom rate limit for specific student actions
        RateLimiter::for('student-actions', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip()); // 5 requests per minute
        });
    }
}
