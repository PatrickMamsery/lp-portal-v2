<?php

namespace App\Filament\Pages\Tenancy;

use Filament\Forms;
use App\Models\School;
use Filament\Forms\Form;
use Illuminate\Support\Str;
use Filament\Pages\Tenancy\RegisterTenant;
use Filament\Forms\Components\Actions\Action;

class RegisterSchool extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Register school';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->live(onBlur: true)
                            ->unique()
                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {

                                $set('slug', Str::slug($state));
                            }),

                        Forms\Components\TextInput::make('slug')
                            ->disabled()
                            ->dehydrated()
                            ->required()
                            ->unique(School::class, 'slug', ignoreRecord: true),

                        Forms\Components\TextInput::make('region'),

                        Forms\Components\TextInput::make('district'),

                        Forms\Components\TextInput::make('ward'),

                        Forms\Components\Select::make('level_id')
                            ->relationship('level', 'name')
                            ->required()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('description')
                                    ->columnSpanFull(),
                            ])
                            ->createOptionAction(function (Action $action) {
                                return $action
                                    ->modalHeading('Create Education Level')
                                    ->modalSubmitActionLabel('Create level');
                            })
                    ])->columns(2)
            ]);
    }

    protected function handleRegistration(array $data): School
    {
        $school = School::create($data);

        $school->admins()->attach(auth()->user());

        return $school;
    }
}
