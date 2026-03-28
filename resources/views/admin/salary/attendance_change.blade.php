@extends('admin.layout.main-layout')
@section('title', config('app.name') . ' || Attendance Change')

@section('content')

    <style>
        .big-checkbox {
            transform: scale(1.4);
            cursor: pointer;
        }
    </style>

    <div class="content">
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    Attendance Change - {{ $user->name }} ({{ $month }} {{ $year }})
                </h5>
                <a href="{{ route('admin.salary.attendance.preview', ['year' => $year, 'month' => $month]) }}"
                    class="btn btn-secondary btn-sm">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
                <button id="markPresent" class="btn btn-success btn-sm">Mark Present</button>
            </div>

            <div class="card-body">
                <form id="attendanceForm">
                    @csrf
                    <input type="hidden" name="id" value="{{ $user->id }}">
                    <input type="hidden" name="year" value="{{ $year }}">
                    <input type="hidden" name="month" value="{{ $month }}">
                    {{-- Calendar --}}
                    <div class="row gap-2">
                        @php
                            $firstDay = \Carbon\Carbon::create($year, date('m', strtotime($month)), 1);
                            $lastDay = $firstDay->copy()->endOfMonth();
                            $dayOfWeek = $firstDay->dayOfWeek;
                            $dayCounter = 1;
                        @endphp

                        {{-- Empty cells --}}
                        @for ($i = 0; $i < $dayOfWeek; $i++)
                            <div class="col-1"></div>
                        @endfor

                        @while ($dayCounter <= $lastDay->day)
                            @php
                                $dateStr = $firstDay->copy()->format('Y-m-d');
                                $today = \Carbon\Carbon::today();
                                $dayName = $firstDay->format('D');

                                $status = '-';
                                $borderClass = 'border-secondary';

                                foreach ($events ?? [] as $event) {
                                    if ($event['start'] == $dateStr) {
                                        $status = $event['title'] ?: '-';
                                        switch ($status) {
                                            case 'P':
                                                $borderClass = 'border-success';
                                                break;
                                            case 'A':
                                                $borderClass = 'border-danger';
                                                break;
                                            case 'AP':
                                                $borderClass = 'border-warning';
                                                break;
                                            case 'L':
                                                $borderClass = 'border-info';
                                                break;
                                        }
                                    }
                                }

                                $isFuture = \Carbon\Carbon::parse($dateStr)->gte($today);
                                $isSunday = $dayName === 'Sun';

                                $badgeClass = 'bg-secondary';
                                switch ($status) {
                                    case 'P':
                                        $badgeClass = 'bg-success';
                                        break;
                                    case 'A':
                                        $badgeClass = 'bg-danger';
                                        break;
                                    case 'AP':
                                        $badgeClass = 'bg-warning text-dark';
                                        break;
                                    case 'L':
                                        $badgeClass = 'bg-info';
                                        break;
                                }
                            @endphp

                            <div class="col-1 bg-gray border border-secondary rounded p-2" style="height:100px;">
                                <h6 class="text-center text-muted">{{ $dayName }}</h6>
                                <h4 class="fw-bold text-center">{{ $dayCounter }}</h4>
                                <div class="d-flex justify-content-between align-items-center mt-1">
                                    @if (!$isSunday)
                                        <span class="badge {{ $badgeClass }}">{{ $status }}</span>

                                        <input class="form-check-input big-checkbox" type="checkbox" name="dates[]"
                                            value="{{ $dateStr }}" {{ $isFuture ? 'disabled' : '' }}
                                            {{ $status != 'L' && !$isFuture ? 'checked' : '' }}>
                                    @endif
                                </div>

                            </div>

                            @php
                                $dayCounter++;
                                $firstDay->addDay();
                            @endphp
                        @endwhile
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('markPresent').addEventListener('click', function(e) {
            e.preventDefault();

            let checked = document.querySelectorAll('input[name="dates[]"]:checked:not(:disabled)');

            if (checked.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Select at least one date'
                });
                return;
            }

            let formData = new FormData(document.getElementById('attendanceForm'));

            fetch("{{ route('admin.salary.attendance.update') }}", {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    Swal.fire({
                        icon: 'success',
                        title: data.message || 'Updated successfully'
                    }).then(() => location.reload());
                })
                .catch(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Something went wrong'
                    });
                });
        });
    </script>

@endsection
