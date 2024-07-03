<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class CalendarPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static string $view = 'filament.pages.calendar-page';

    protected static ?string $title = 'Timetable';

    protected static ?string $navigationLabel = 'Timetable';

    protected static ?string $slug = 'timetable';

    // public static function shouldRegisterNavigation(): bool
    // {
    //     return false;
    // }
}
