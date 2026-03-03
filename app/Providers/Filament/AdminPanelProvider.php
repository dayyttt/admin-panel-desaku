<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\Login;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(Login::class)
            ->brandName('SGC Desa Lesane')
            ->colors([
                'primary' => Color::Green,
                'danger' => Color::Red,
                'info' => Color::Blue,
                'success' => Color::Emerald,
                'warning' => Color::Amber,
            ])
            ->sidebarCollapsibleOnDesktop()
            ->navigationGroups([
                'Info Desa' => \Filament\Navigation\NavigationGroup::make()->label('Info Desa')->icon('heroicon-o-building-office'),
                'Kependudukan' => \Filament\Navigation\NavigationGroup::make()->label('Kependudukan')->icon('heroicon-o-users'),
                'Persuratan' => \Filament\Navigation\NavigationGroup::make()->label('Persuratan')->icon('heroicon-o-document-duplicate'),
                'Keuangan' => \Filament\Navigation\NavigationGroup::make()->label('Keuangan')->icon('heroicon-o-banknotes'),
                'Bantuan Sosial' => \Filament\Navigation\NavigationGroup::make()->label('Bantuan Sosial')->icon('heroicon-o-gift'),
                'Pembangunan' => \Filament\Navigation\NavigationGroup::make()->label('Pembangunan')->icon('heroicon-o-wrench-screwdriver'),
                'Aset & Inventaris' => \Filament\Navigation\NavigationGroup::make()->label('Aset & Inventaris')->icon('heroicon-o-cube'),
                'Sekretariat' => \Filament\Navigation\NavigationGroup::make()->label('Sekretariat')->icon('heroicon-o-document-text'),
                'Web Publik' => \Filament\Navigation\NavigationGroup::make()->label('Web Publik')->icon('heroicon-o-globe-alt'),
                'Pengaturan' => \Filament\Navigation\NavigationGroup::make()->label('Pengaturan')->icon('heroicon-o-cog-6-tooth')->collapsed(),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->renderHook(
                'panels::body.end',
                fn (): string => view('components.tour-script')->render() . view('components.sidebar-active-fix')->render() . view('components.sidebar-search')->render()
            )
            ->renderHook(
                'panels::head.end',
                fn (): string => '<link rel="stylesheet" href="' . asset('css/sidebar-custom.css') . '">'
            );
    }
}
