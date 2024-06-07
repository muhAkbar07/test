<?php  

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;
use Illuminate\Foundation\Vite;
use Filament\Navigation\UserMenuItem;
use App\Filament\Pages\MyProfile;

class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Registrasi service atau binding yang diperlukan
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        Filament::serving(function () {
            // Using Vite
            Filament::registerViteTheme('resources/css/filament.css');
            
            Filament::registerUserMenuItems([
                UserMenuItem::make()
                    ->label('Settings')
                    ->url(MyProfile::getUrl())
                    ->icon('heroicon-s-cog'),
                
            ]);
        });
    }
}