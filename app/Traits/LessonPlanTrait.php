<?php

namespace App\Traits;

use Illuminate\Support\Facades\App;

trait LessonPlanTrait
{
    public function generatePdf($lessonStages)
    {
        $rows = [];
        foreach ($lessonStages as $stage) {
            $row_string = '<tr class="border-b border-gray-200 hover:bg-gray-100">
                <td class="py-3 px-6 text-left whitespace-nowrap">' . $stage['name'] . '</td>
                <td class="py-3 px-6 text-left">' . $stage['time'] . '</td>
                <td class="py-3 px-6 text-left">' . $stage['teaching_activities'] . '</td>
                <td class="py-3 px-6 text-left">' . $stage['learning_activities'] . '</td>
                <td class="py-3 px-6 text-left">' . $stage['assessment'] . '</td>
            </tr>';
            array_push($rows, $row_string);
        }

        $list = implode('', $rows);
        $title = 'Lesson Stages Preview';

        $html_view = '
        <style>
        table {
            border-collapse: collapse;
            width: 100%;
            background-color: #ffffff;
        }

        th, td {
            border: 1px solid #999;
            padding: 0.75rem;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
            text-transform: uppercase;
            font-size: 0.875rem;
        }

        tbody tr:hover {
            background-color: #f5f5f5;
        }
        </style>
        <div class="table-responsive">
        <h3>' . $title . '  <span style="float:right">' . date('D, M d, Y') . '</span></h3>
            <table>
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Stage</th>
                        <th class="py-3 px-6 text-left">Time</th>
                        <th class="py-3 px-6 text-left">Teaching Activities</th>
                        <th class="py-3 px-6 text-left">Learning Activities</th>
                        <th class="py-3 px-6 text-left">Assessment</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    ' . $list . '
                </tbody>
            </table>
        </div>';

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($html_view);

        return $pdf;
    }

    public function downloadLessonPlanV2($lessonStages)
    {
        $pdfContent = $this->generatePdf($lessonStages);
        // dd($pdfContent);

        return response()->streamDownload(function () use ($pdfContent) {
            echo $pdfContent->stream();
        }, 'lesson_stages.pdf');
    }

    public function downloadLessonPlan($lessonStages)
    {
        // dd(collect($lessonStages));
        try {
            return response()->streamDownload(function () use ($lessonStages) {
                $rows = [];
                foreach ($lessonStages as $stage) {
                    $row_string = '<tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left whitespace-nowrap">' . $stage['name'] . '</td>
                    <td class="py-3 px-6 text-left">' . $stage['time'] . '</td>
                    <td class="py-3 px-6 text-left">' . $stage['teaching_activities'] . '</td>
                    <td class="py-3 px-6 text-left">' . $stage['learning_activities'] . '</td>
                    <td class="py-3 px-6 text-left">' . $stage['assessment'] . '</td>
                </tr>';

                    array_push($rows, $row_string);
                }

                $list = implode('', $rows);
                $title = 'Lesson Stages Preview';

                $html_view = '
                    <style>
                    table {
                        border-collapse: collapse;
                        width: 100%;
                        background-color: #ffffff;
                    }

                    th, td {
                        border: 1px solid #999;
                        padding: 0.75rem;
                        text-align: left;
                    }

                    th {
                        background-color: #f2f2f2;
                        color: #333;
                        text-transform: uppercase;
                        font-size: 0.875rem;
                    }

                    tbody tr:hover {
                        background-color: #f5f5f5;
                    }
                    </style>
                    <div class="table-responsive">
                    <h3>' . $title . '  <span style="float:right">' . date('D, M d, Y') . '</span></h3>
                        <table>
                            <thead>
                                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">Stage</th>
                                    <th class="py-3 px-6 text-left">Time</th>
                                    <th class="py-3 px-6 text-left">Teaching Activities</th>
                                    <th class="py-3 px-6 text-left">Learning Activities</th>
                                    <th class="py-3 px-6 text-left">Assessment</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                ' . $list . '
                            </tbody>
                        </table>
                    </div>';

                $pdf = App::make('dompdf.wrapper');
                $pdf->loadHTML($html_view);
                echo $pdf->stream();
            }, 'lesson_stages.pdf');
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
    }
}
