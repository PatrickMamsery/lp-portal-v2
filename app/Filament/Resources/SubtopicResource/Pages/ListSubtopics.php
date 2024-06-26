<?php

namespace App\Filament\Resources\SubtopicResource\Pages;

use App\Filament\Resources\SubtopicResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSubtopics extends ListRecords
{
    protected static string $resource = SubtopicResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
