<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //        Debugbar::disable();

        DB::prohibitDestructiveCommands(app()->isProduction());
        Model::shouldBeStrict(! app()->isProduction());
        //        Model::unguard();

        Date::use(CarbonImmutable::class);

        Relation::enforceMorphMap([
            // 'user' => User::class,
        ]);
        Paginator::useBootstrapFive();
        Model::preventLazyLoading(false);

        Blade::directive('image', function ($path) {
            return "<?php echo asset('storage/' . $path); ?>";
        });
    }
}
