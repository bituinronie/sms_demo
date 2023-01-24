<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
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
    public const HOME = '/home';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
     //protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::namespace($this->namespace)
                ->prefix('api/accounting')
                ->group(base_path('routes/custom/accounting.php'));

            Route::namespace($this->namespace)
                ->prefix('api/admission')
                ->group(base_path('routes/custom/admission.php'));

            Route::namespace($this->namespace)
                ->prefix('api/basiceducation')
                ->group(base_path('routes/custom/basiceducation.php'));

            Route::namespace($this->namespace)
                ->prefix('api/college')
                ->group(base_path('routes/custom/college.php'));

            Route::namespace($this->namespace)
                ->prefix('api/department')
                ->group(base_path('routes/custom/department.php'));

            Route::namespace($this->namespace)
                ->prefix('api/human-resource')
                ->group(base_path('routes/custom/humanresource.php'));

            Route::namespace($this->namespace)
                ->prefix('api/facility')
                ->group(base_path('routes/custom/facility.php'));

            Route::namespace($this->namespace)
                ->prefix('api/foreign')
                ->group(base_path('routes/custom/foreign.php'));

            Route::namespace($this->namespace)
                ->prefix('api/registrar')
                ->group(base_path('routes/custom/registrar.php'));

            Route::namespace($this->namespace)
                ->prefix('api/scholarship')
                ->group(base_path('routes/custom/scholarship.php'));

            Route::namespace($this->namespace)
                ->prefix('api/student')
                ->group(base_path('routes/custom/student.php'));

            Route::namespace($this->namespace)
                ->prefix('api/system')
                ->group(base_path('routes/custom/system.php'));

            Route::namespace($this->namespace)
                ->prefix('api/user')
                ->group(base_path('routes/custom/user.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
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
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
