<?php

namespace App\Filament\Resources\LearningAidResource\Pages;

use App\Filament\Resources\LearningAidResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLearningAids extends ListRecords
{
    protected static string $resource = LearningAidResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
