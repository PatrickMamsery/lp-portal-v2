<?php

namespace App\Livewire;

use Filament\Forms;
use Livewire\Component;
use Filament\Forms\Form;
use App\Models\LessonPlan;
use App\Models\School;
use Filament\Facades\Filament;
use function Filament\authorize;
use Livewire\Attributes\Url;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Filament\Forms\Concerns\InteractsWithForms;
use Illuminate\Auth\Access\AuthorizationException;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Forms\Components\Component as FilamentComponent;

class PreliminarySection extends Component implements HasForms
{
    use InteractsWithForms, InteractsWithFormActions;

    #[Url]
    public ?LessonPlan $record = null;
    public ?Model $tenant = null;

    public ?string $tenantId = "";
    public ?string $recordId = "";

    public function mount(): void
    {
        $this->record = LessonPlan::query()
            ->firstOrNew([
                'id' => $this->recordId,
            ]);

        // Add Tenant
        $this->tenant = School::query()
            ->firstOrNew([
                'id' => $this->tenantId,
            ]);

        abort_unless(static::canView($this->record), 404);

        $this->fillForm();
    }

    public function fillForm(): void
    {
        $data = $this->record->attributesToArray();

        // $this->form->fill($data);
        $this->dispatch('updatePreliminarySection', $data);
    }

    protected function getSavedNotification(): Notification
    {
        return Notification::make()
            ->success()
            ->title(__('filament-panels::resources/pages/edit-record.notifications.saved.title'));
    }

    public function form(Form $form): Form
    {
        return $form
            ->live()
            ->schema([
                $this->getGeneralSection(),
                $this->getLessonDetailsSection(),
            ])
            ->model($this->record)
            ->statePath('data')
            ->operation('edit');
    }

    protected function getGeneralSection(): FilamentComponent
    {
        return Section::make('General')
            ->schema([
                Forms\Components\DatePicker::make('date')
                    // ->required()
                    ->default(now()),

                Forms\Components\Select::make('school_id')
                    // ->required()
                    ->disabled()
                    ->relationship(
                        'school',
                        'name',
                    )
                    ->default($this->tenant?->id),

                Forms\Components\Select::make('teacher_id')
                    // ->required()
                    ->disabled()
                    ->relationship('teacher', 'name')
                    ->default(auth()->user()->id),

                Forms\Components\Select::make('subject_id')
                    // ->required()
                    ->relationship('subject', 'name'),

                Forms\Components\Select::make('grade_id')
                    // ->required()
                    ->relationship('grade', 'name'),

                Forms\Components\Select::make('stream_id')
                    // ->required()
                    ->relationship('stream', 'name'),

                Forms\Components\TimePicker::make('start_time')
                    // ->required()
                    ->label('Class Start Time')
                    ->default(now()),

                Forms\Components\TimePicker::make('end_time')
                    // ->required()
                    ->label('Class End Time')
                    ->default(now()->addHour()),
            ])->columns(3);
    }

    protected function getLessonDetailsSection(): FilamentComponent
    {
        return Section::make('Lesson Details')
            ->schema([
                Forms\Components\Select::make('topic_id')
                    // ->required()
                    ->relationship('topic', 'name'),
                Forms\Components\Select::make('subtopic_id')
                    // ->required()
                    ->relationship('subtopic', 'name'),
                Forms\Components\Select::make('competence_id')
                    // ->required()
                    ->relationship('competence', 'content'),
            ])->columns(3);
    }

    public function render()
    {
        return view('livewire.preliminary-section');
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
