<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

use App\Models\Barcode;


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
        View::composer('*', function ($view) {
            $totalBarcodes = Barcode::count();
            $activeBarcodes = Barcode::where('is_active', true)->count();
            $inactiveBarcodes = Barcode::where('is_active', false)->count();

            // تمرير البيانات لجميع الصفحات
            $view->with([
                'totalBarcodes' => $totalBarcodes,
                'activeBarcodes' => $activeBarcodes,
                'inactiveBarcodes' => $inactiveBarcodes,
            ]);
        });
    }
}
