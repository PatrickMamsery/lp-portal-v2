<?php

namespace App\Filament\Teacher\Pages;

use Filament\Pages\Page;
use Livewire\Attributes\Url;

class LessonPlan extends Page
{
    #[Url]
    public ?string $record = "";
    public ?string $tenant = "";

    public function mount(): void
    {
        // dd($this->tenant, $this->record);
    }

    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';

    protected static string $view = 'filament.teacher.pages.lesson-plan';
}
