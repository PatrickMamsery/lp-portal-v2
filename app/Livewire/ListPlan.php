<?php

namespace App\Livewire;

use Filament\Forms;
use Filament\Tables;
use Livewire\Component;
use App\Models\LessonPlan;
use Filament\Tables\Table;
use Filament\Facades\Filament;
use App\Traits\LessonPlanTrait;
use function Filament\authorize;
use Illuminate\Support\Collection;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Auth\Access\AuthorizationException;
use Filament\Pages\Concerns\InteractsWithFormActions;

class ListPlan extends Component implements HasTable, HasForms
{
    use InteractsWithTable, InteractsWithForms, InteractsWithFormActions, LessonPlanTrait;

    public ?LessonPlan $record = null;

    protected $listeners = ['download'];

    public function render()
    {
        return view('livewire.list-plan');
    }

    public function table(Table $table): Table
    {
        // Query the lesson plans associated with the school
        $query = LessonPlan::with('school', 'grade', 'stream', 'subject', 'stages', 'evaluations')
                        ->where('school_id', Filament::getTenant()->id)
                        ->where('teacher_id', auth()->id());

        return $table
            ->query($query)
            ->columns([
                Tables\Columns\Layout\Split::make([
                    Tables\Columns\Layout\Stack::make([
                        TextColumn::make('grade.name')
                            ->label('Grade'),
                        TextColumn::make('stream.name')
                            ->label('Stream'),
                        TextColumn::make('subject.name')
                            ->label('Subject'),
                    ]),
                    Tables\Columns\Layout\Stack::make([
                        TextColumn::make('topic.name')
                            ->label('Topic'),
                        TextColumn::make('subtopic.name')
                            ->label('Subtopic'),
                        TextColumn::make('competence.name')
                            ->label('Competence'),
                    ]),
                ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Edit')
                    ->icon('heroicon-o-pencil'),

                Tables\Actions\Action::make('download')
                    ->label('Download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function (Model $record) {
                        // $this->downloadLessonPlan($record->stages);
                        $this->dispatch('download', $record->stages);
                    }),
            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ]);
    }

    public function download($data)
    {
        $this->downloadLessonPlan($data);
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
