<?php

namespace App\Filament\Teacher\Widgets;

use Carbon\Carbon;
use App\Models\User;
use App\Models\School;
use App\Models\LessonPlan;
use App\Traits\OverviewTrait;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    use InteractsWithPageFilters, OverviewTrait;

    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $startDate = $this->getStartDate();
        $endDate = $this->getEndDate();

        $lessonPlans = $this->getModelCount(LessonPlan::class, $startDate, $endDate);
        $users = $this->getModelCount(User::class, $startDate, $endDate);
        $schools = $this->getModelCount(School::class, $startDate, $endDate);
        // $schedules = $this->getModelCount(Schedule::class, $startDate, $endDate);

        return [
            $this->createStat('Lesson Plans', $lessonPlans, LessonPlan::class),
            $this->createStat('Users', $users, User::class),
            // $this->createStat('Schools', $schools, School::class),
            // $this->createStat('Schedules', $schedules, Schedule::class),
        ];
    }

    protected function createStat(string $label, int $value, string $modelClass): Stat
    {
        $descriptionData = $this->getSummaryData($modelClass);
        $diffPercentage = $descriptionData['diff'];
        $diffIcon = $diffPercentage > 0 ? 'heroicon-o-arrow-trending-up' : 'heroicon-o-arrow-trending-down';
        $diffText = $diffPercentage . '% ' . ($diffPercentage > 0 ? 'increase' : 'decrease') . ' from last month';

        return Stat::make($label, $value)
            ->description($diffText)
            ->descriptionIcon($diffIcon)
            ->chart($this->getChartData($modelClass)['data'])
            ->color($diffPercentage > 0 ? 'success' : 'danger');
    }

    protected function getStartDate(): ?Carbon
    {
        return !is_null($this->filters['startDate'] ?? null) ?
            Carbon::parse($this->filters['startDate']) :
            null;
    }

    protected function getEndDate(): Carbon
    {
        return !is_null($this->filters['endDate'] ?? null) ?
            Carbon::parse($this->filters['endDate']) :
            now();
    }
}
