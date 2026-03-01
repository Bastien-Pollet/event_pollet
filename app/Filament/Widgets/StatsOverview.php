<?php
namespace App\Filament\Widgets;

use App\Models\Event;
use App\Models\Registration;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Événements', Event::count()),
            Stat::make('Inscriptions', Registration::count()),
            Stat::make('À venir', Event::query()->where('starts_at','>=', now())->count()),
        ];
    }
}
