<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\ViewComposers\CategoryComposer;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Kirim $categories ke view yang membutuhkan
        view()->composer(
            ['shop', 'product-detail'], // nama view file (tanpa .blade.php)
            CategoryComposer::class
        );
    }

    public function register(): void
    {
        //
    }
}
