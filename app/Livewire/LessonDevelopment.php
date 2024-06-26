<?php

namespace App\Livewire;

use App\Models\Stage;
use Livewire\Component;
use App\Models\LessonPlan;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms;
use Filament\Facades\Filament;
use function Filament\authorize;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Auth\Access\AuthorizationException;
use Filament\Pages\Concerns\InteractsWithFormActions;

class LessonDevelopment extends Component implements HasTable, HasForms
{
    use InteractsWithTable, InteractsWithForms, InteractsWithFormActions;

    public ?LessonPlan $record = null;

    public function mount(): void
    {
        $this->record = LessonPlan::query()
            ->firstOrNew([
                'school_id' => Filament::getTenant()->id,
            ]);

        abort_unless(static::canView($this->record), 404);
    }

    public function render()
    {
        return view('livewire.lesson-development');
    }

    public function table(Table $table): Table
    {
        // Query the stages associated with the lesson plan
        $query = Stage::where('lesson_plan_id', $this->record->id);

        return $table
            ->query($query)
            ->columns([
                TextColumn::make('name')
                    ->wrap(),
                TextColumn::make('time')
                    ->wrap(),
                TextColumn::make('teaching_activities')
                    ->wrap(),
                TextColumn::make('learning_activities')
                    ->wrap(),
                TextColumn::make('assessment')
                    ->wrap(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->slideOver()
                    ->form([
                        Forms\Components\Hidden::make('lesson_plan_id')
                            ->default($this->record->id),
                        Forms\Components\TextInput::make('name')
                            ->label('Name')
                            ->required(),
                        Forms\Components\TextInput::make('time')
                            ->label('Time')
                            ->numeric()
                            ->suffix('minutes')
                            ->required(),
                        Forms\Components\Textarea::make('teaching_activities')
                            ->label('Teaching Activities')
                            ->required(),
                        Forms\Components\Textarea::make('learning_activities')
                            ->label('Learning Activities')
                            ->required(),
                        Forms\Components\Textarea::make('assessment')
                            ->label('Assessment')
                            ->required(),
                    ]),
            ]);
    }

    public static function canView(Model $record): bool
    {
        try {
            return authorize('update', $record)->allowed();
        } catch (AuthorizationException $exception) {
            return $exception->toResponse()->allowed();
        }
    }
}
