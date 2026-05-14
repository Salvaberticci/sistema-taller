<?php

namespace App\Providers;

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
        try {
            $rate = \App\Services\CurrencyService::getBcvRate();
            \Illuminate\Support\Facades\View::share('bcvRate', $rate);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\View::share('bcvRate', 36.50);
        }

        // Blade directive for dual currency: @money($amount)
        \Illuminate\Support\Facades\Blade::directive('money', function ($expression) {
            return "<?php 
                \$usd = (float) $expression;
                \$rate = \$bcvRate ?? 36.50;
                \$ves = \$usd * \$rate;
                echo '<span class=\"flex flex-col\">';
                echo '<span class=\"font-black text-white\">$' . number_format(\$usd, 2) . '</span>';
                echo '<span class=\"text-[10px] text-slate-500 font-bold uppercase tracking-tighter\">Bs. ' . number_format(\$ves, 2) . '</span>';
                echo '</span>';
            ?>";
        });
    }
}
