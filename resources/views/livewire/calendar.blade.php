<div>
    <div class="content">
        <div class="flex justify-center">
            <div class="w-full max-w-7xl">
                <div class="dark:bg-white shadow-md rounded-lg">
                    <div class="bg-gray-800 dark:text-white px-4 py-2 rounded-t-lg">
                        Calendar
                    </div>

                    <div class="p-4">
                        @if (session('status'))
                            <div class="bg-green-500 dark:text-white p-2 rounded mb-4" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-black dark:bg-white border border-gray-200">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="py-2 px-4 border-b border-r border-gray-200" width="125">Time</th>
                                        @foreach ($weekDays as $day)
                                            <th class="py-2 px-4 border-b border-r border-gray-200">{{ $day }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($calendarData as $time => $days)
                                        <tr>
                                            <td class="py-2 px-4 border-b border-r border-gray-200">{{ $time }}</td>
                                            @foreach ($days as $value)
                                                @if (is_array($value))
                                                    <td rowspan="{{ $value['rowspan'] }}" class="py-2 px-4 border-b border-r border-gray-200 text-center align-middle bg-gray-100">
                                                        {{ $value['class_name'] }}<br>
                                                        Teacher: {{ $value['teacher_name'] }}
                                                    </td>
                                                @elseif ($value === 1)
                                                    <td class="py-2 px-4 border-b border-r border-gray-200"></td>
                                                @endif
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
