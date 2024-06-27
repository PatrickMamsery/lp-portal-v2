<?php

namespace App\Livewire;

use Livewire\Component;
use App\Enums\DaysOfTheWeek;
use App\Services\CalendarService;

class Calendar extends Component
{
    public $weekDays;
    public $calendarData;

    public function mount(CalendarService $calendarService)
    {
        $this->weekDays = $this->getWeekDays();
        $this->calendarData = $calendarService->generateCalendarData($this->weekDays);
    }

    protected function getWeekDays()
    {
        return collect(DaysOfTheWeek::cases())->mapWithKeys(function ($day) {
            return [$day->value => $day->getLabel()];
        })->toArray();
    }

    public function render()
    {
        return view('livewire.calendar');
    }
}
