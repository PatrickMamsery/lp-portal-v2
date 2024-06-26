<?php

namespace App\Livewire;

use Filament\Forms;
use Filament\Tables;
use Livewire\Component;
use App\Models\LessonPlan;
use Filament\Tables\Table;
use Filament\Facades\Filament;
use function Filament\authorize;
use App\Models\LessonPlanEvaluation;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Auth\Access\AuthorizationException;
use Filament\Pages\Concerns\InteractsWithFormActions;

class LessonEvaluation extends Component implements HasTable, HasForms
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
        return view('livewire.lesson-evaluation');
    }

    public function table(Table $table): Table
    {
        $query = LessonPlanEvaluation::where('lesson_plan_id', $this->record->id);

        return $table
            ->query($query)
            ->columns([
                Tables\Columns\Layout\Split::make([
                    Tables\Columns\Layout\Stack::make([
                        TextColumn::make('type')
                            ->weight('bold'),
                        TextColumn::make('evaluation'),
                    ])
                ])
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->slideOver()
                    ->form([
                        Forms\Components\Hidden::make('lesson_plan_id')
                            ->default($this->record->id),
                        Forms\Components\Select::make('type')
                            ->options([
                                'student' => 'Student',
                                'teacher' => 'Teacher',
                            ])
                            ->required(),
                        Forms\Components\Textarea::make('evaluation')
                            ->required(),
                    ])
                    ->createAnother(false),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->slideOver()
                    ->form([
                        Forms\Components\Hidden::make('lesson_plan_id')
                            ->default($this->record->id),
                        Forms\Components\Select::make('type')
                            ->options([
                                'student' => 'Student',
                                'teacher' => 'Teacher',
                            ])
                            ->required(),
                        Forms\Components\Textarea::make('evaluation')
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
