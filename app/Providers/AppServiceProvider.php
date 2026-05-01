<?php

namespace App\Providers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (Schema::hasTable('users') && \App\Models\User::count() === 0) {
            try {
                Artisan::call('db:seed --force');
            } catch (\Throwable $e) {
                logger()->error('Auto-seed failed: ' . $e->getMessage());
            }
        }

        Blade::directive('role', function ($expression) {
            return "<?php if(auth()->check() && in_array(auth()->user()->role, [{$expression}])): ?>";
        });
        Blade::directive('endrole', function () {
            return '<?php endif; ?>';
        });
    }
}
