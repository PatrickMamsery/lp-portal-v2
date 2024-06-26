<?php

namespace App\Filament\Resources\LearningAidResource\Pages;

use App\Filament\Resources\LearningAidResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLearningAid extends EditRecord
{
    protected static string $resource = LearningAidResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
