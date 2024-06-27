<?php

namespace App\Services;

use App\Models\Lesson;

class CalendarService
{
    public function generateCalendarData($weekDays)
    {
        $calendarData = [];
        $timeRange = (new TimeService)->generateTimeRange(config('app.calendar.start_time'), config('app.calendar.end_time'));
        $lessons   = Lesson::with('stream', 'teacher');
            // ->calendarByRoleOrClassId()
            // ->get();

            // dd($lessons);

        foreach ($timeRange as $time)
        {
            $timeText = $time['start'] . ' - ' . $time['end'];
            $calendarData[$timeText] = [];

            // dd($weekDays);

            foreach ($weekDays as $index => $day)
            {
                $lesson = (clone $lessons)->where('day_of_week', $index)->where('start_time', $time['start'])->first();

                if ($lesson)
                {
                    array_push($calendarData[$timeText], [
                        'class_name'   => $lesson->stream->name,
                        'teacher_name' => $lesson->teacher->name,
                        'rowspan'      => $lesson->difference/30 ?? ''
                    ]);
                }
                else if (!(clone $lessons)->where('day_of_week', $index)->where('start_time', '<', $time['start'])->where('end_time', '>=', $time['end'])->count())
                {
                    array_push($calendarData[$timeText], 1);
                }
                else
                {
                    array_push($calendarData[$timeText], 0);
                }
            }
        }

        return $calendarData;
    }
}
