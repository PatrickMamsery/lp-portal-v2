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
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Auth\Access\AuthorizationException;
use Filament\Pages\Concerns\InteractsWithFormActions;

class ListPlan extends Component implements HasTable, HasForms
{
    use InteractsWithTable, InteractsWithForms, InteractsWithFormActions, LessonPlanTrait;

    public ?LessonPlan $record = null;

    protected $listeners = ['download'];

    public $lessonStages = [
        [
            'stage' => 'INTRODUCTION',
            'time' => '10min',
            'teachingActivities' => 'Through Oral question to give meaning of warning sign',
            'learningActivities' => 'Responding on the meaning of warning sign',
            'assessment' => 'Listening on their explanation about warning sign'
        ],
        [
            'stage' => 'DEVELOPING NEW KNOWLEDGE',
            'time' => '20min',
            'teachingActivities' => 'Think pair and share to explain different warning signs found in different containers',
            'learningActivities' => 'In pair to give and listen different warning signs found in different chemical containers',
            'assessment' => 'Check if they pay attention'
        ],
        [
            'stage' => 'REINFORCEMENT',
            'time' => '20min',
            'teachingActivities' => 'Describe the measures on how to handle chemicals with different warning signs',
            'learningActivities' => 'Take note on the measures to be taken when dealing with different chemicals',
            'assessment' => 'Check if they take note'
        ],
        [
            'stage' => 'REFLECTION',
            'time' => '15min',
            'teachingActivities' => 'Clearing all challenges and summarize it',
            'learningActivities' => 'Take summary and give out their challenges',
            'assessment' => 'Through their challenges'
        ],
        [
            'stage' => 'CONCLUSION',
            'time' => '15min',
            'teachingActivities' => 'Guiding student to attempt the exercise',
            'learningActivities' => 'Write and perform an exercise given',
            'assessment' => 'Marking the exercise'
        ]
    ];

    protected $lessonStagesTemplate = [
        ['name' => 'INTRODUCTION'],
        ['name' => 'DEVELOPING NEW KNOWLEDGE'],
        ['name' => 'REINFORCEMENT'],
        ['name' => 'REFLECTION'],
        ['name' => 'CONCLUSION'],
    ];

    public function render()
    {
        return view('livewire.list-plan');
    }

    protected function getFormSchema($context = 'create'): array
    {
        return [
            Forms\Components\Wizard::make([
                Forms\Components\Wizard\Step::make('General')
                    ->schema([
                        Forms\Components\DatePicker::make('date')
                            ->default(now()),

                        Forms\Components\Select::make('school_id')
                            ->disabled()
                            ->relationship('school', 'name')
                            ->default(Filament::getTenant()->id),

                        Forms\Components\Select::make('teacher_id')
                            ->disabled()
                            ->relationship('teacher', 'name')
                            ->default(auth()->user()->id),

                        Forms\Components\Select::make('subject_id')
                            ->relationship('subject', 'name')
                            ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->name} - {$record->grade->name}")
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Select::make('grade_id')
                                    ->required()
                                    ->relationship('grade', 'name')
                                    ->preload()
                                    ->searchable(),
                                !Filament::getTenant() ?
                                    Forms\Components\Select::make('school_id')
                                    ->required()
                                    ->relationship('school', 'name')
                                    ->preload()
                                    ->searchable() :
                                    Forms\Components\Hidden::make('school_id')
                                    ->default(Filament::getTenant()->id),
                                Forms\Components\Textarea::make('description')
                                    ->columnSpanFull(),
                            ])
                            ->createOptionAction(function (Action $action) {
                                return $action
                                    ->modalHeading('Create Subject')
                                    ->modalSubmitActionLabel('Create Subject');
                            }),

                        Forms\Components\Select::make('grade_id')
                            ->relationship('grade', 'name'),

                        Forms\Components\Select::make('stream_id')
                            ->relationship('stream', 'name')
                            ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->grade->name} - {$record->name}"),

                        Forms\Components\TimePicker::make('start_time')
                            ->label('Class Start Time')
                            ->seconds(false)
                            ->minutesStep(30)
                            ->default(now()),

                        Forms\Components\TimePicker::make('end_time')
                            ->label('Class End Time')
                            ->seconds(false)
                            ->minutesStep(30)
                            ->default(now()->addHour()),
                    ])->columns(3),

                Forms\Components\Wizard\Step::make('Topic, Subtopic & Competence')
                    ->schema([
                        Forms\Components\Select::make('topic_id')
                            ->relationship('topic', 'name')
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\Select::make('subject_id')
                                    ->required()
                                    ->relationship('subject', 'name')
                                    ->preload()
                                    ->searchable(),

                                Forms\Components\Textarea::make('main_objective')
                                    ->nullable(),

                                Forms\Components\Hidden::make('school_id')
                                    ->default(Filament::getTenant()->id),
                            ])
                            ->createOptionAction(function (Action $action) {
                                return $action
                                    ->modalHeading('Create Topic')
                                    ->modalSubmitActionLabel('Create Topic');
                            }),

                        Forms\Components\Select::make('subtopic_id')
                            ->relationship('subtopic', 'name')
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\Select::make('topic_id')
                                    ->required()
                                    ->relationship('topic', 'name')
                                    ->preload()
                                    ->searchable(),

                                Forms\Components\Hidden::make('school_id')
                                    ->default(Filament::getTenant()->id),
                            ])
                            ->createOptionAction(function (Action $action) {
                                return $action
                                    ->modalHeading('Create Subtopic')
                                    ->modalSubmitActionLabel('Create Subtopic');
                            }),

                        Forms\Components\Select::make('competence_id')
                            ->relationship('competence', 'content')
                            ->createOptionForm([
                                Forms\Components\TextInput::make('content')
                                    ->required(),

                                Forms\Components\Select::make('subject_id')
                                    ->required()
                                    ->relationship('subject', 'name')
                                    ->preload()
                                    ->searchable(),

                                Forms\Components\Select::make('topic_id')
                                    ->required()
                                    ->relationship('topic', 'name')
                                    ->preload()
                                    ->searchable(),

                                Forms\Components\Hidden::make('school_id')
                                    ->default(Filament::getTenant()->id),
                            ])
                            ->createOptionAction(function (Action $action) {
                                return $action
                                    ->modalHeading('Create Competence')
                                    ->modalSubmitActionLabel('Create Competence');
                            }),
                    ])->columns(3),
            ]),
        ];
    }

    public function table(Table $table): Table
    {
        // Query the lesson plans associated with the school
        $query = LessonPlan::with('school', 'grade', 'stream', 'subject', 'stages', 'evaluations')
            ->where('school_id', Filament::getTenant()->id)
            ->where('teacher_id', auth()->id());

        return $table
            ->query($query)
            ->headerActions([
                // Tables\Actions\Action::make('create')
                //     ->label('Create')
                //     ->url(route('filament.teacher.pages.lesson-plan', Filament::getTenant())),

                Tables\Actions\CreateAction::make('create')
                    ->model(LessonPlan::class)
                    ->slideOver()
                    ->createAnother(false)
                    ->form($this->getFormSchema('create'))
                    ->after(function (Model $record) {
                        // Create lesson stages for the lesson plan with the lesson plan id
                        foreach ($this->lessonStagesTemplate as $stageTemplate) {
                            $record->stages()->create($stageTemplate);
                        }
                    })
                    // ->using(function (array $data, string $model): Model {
                    //     // Create lesson plan
                    //     $lessonPlan = $model::create($data);

                    //     // Create lesson stages for the lesson plan with the lesson plan id
                    //     foreach ($this->lessonStagesTemplate as $stageTemplate) {
                    //         $lessonPlan->stages()->create($stageTemplate);
                    //     }

                    //     return $lessonPlan;
                    // }),
            ])
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
                // Tables\Actions\Action::make('edit')
                //     ->label('Edit Lesson Plan')
                //     ->icon('heroicon-o-pencil'),
                    // ->url(fn (LessonPlan $record): string => route('filament.teacher.pages.lesson-plan.edit', ['tenant' => Filament::getTenant()->slug, 'record' => $record->id])),
                // ->action(function (LessonPlan $record) {
                //     return route('filament.teacher.pages.lesson-plan.edit', [
                //         'tenant' => Filament::getTenant()->slug,
                //         'record' => $record,
                //     ]);
                // }),
                Tables\Actions\ViewAction::make()
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->form($this->getFormSchema('view')),

                Tables\Actions\Action::make('download')
                    ->label('Download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function (Model $record) {
                        // $this->downloadLessonPlan($record->stages);
                        // $this->dispatch('download', $record->stages);
                        $this->dispatch('download', $this->lessonStages);
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

    // public static function getPages(): array
    // {
    //     return [
    //         // ...
    //         'manage' => \App\Filament\Teacher\Pages\LessonPlan::route('/{record}/manage'),
    //     ];
    // }

    public static function canView(Model $record): bool
    {
        try {
            return authorize('update', $record)->allowed();
        } catch (AuthorizationException $exception) {
            return $exception->toResponse()->allowed();
        }
    }
}
