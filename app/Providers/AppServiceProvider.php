<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

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
        $this->configureDefaults();
        $this->bootInventory();
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );

        Schema::defaultStringLength(191);
    }

    /**
     * Boot inventory-specific shared data and config.
     */
    protected function bootInventory(): void
    {
        // Set locale from cookie
        if (isset($_COOKIE['language'])) {
            app()->setLocale($_COOKIE['language']);
        } else {
            app()->setLocale('en');
        }

        if (!$this->app->runningInConsole() || Schema::hasTable('general_settings')) {
            try {
                $general_setting = DB::table('general_settings')->latest()->first();
                if ($general_setting) {
                    $currency = \App\Models\Currency::find($general_setting->currency);
                    View::share('general_setting', $general_setting);
                    View::share('currency', $currency);
                    config([
                        'staff_access' => $general_setting->staff_access,
                        'date_format' => $general_setting->date_format,
                        'currency' => $currency?->code,
                        'currency_position' => $general_setting->currency_position,
                    ]);
                }

                if (Schema::hasTable('products')) {
                    $alert_product = DB::table('products')
                        ->where('is_active', true)
                        ->whereColumn('alert_quantity', '>', 'qty')
                        ->count();
                    View::share('alert_product', $alert_product);
                }
            } catch (\Exception $e) {
                // Ignore errors during migration or if tables don't exist
            }
        }
    }
}
