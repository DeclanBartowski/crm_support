@extends('admin.layouts.app')
@section('content')
    <div class="m-portlet m-portlet--mobile">

        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        {{'Календарь'}}
                    </h3>
                </div>
            </div>

        </div>
        <div class="m-portlet__body">
            <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.1/index.global.min.js'></script>
            <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/locales-all.js'></script>

            <div id="calendar"></div>
            <script>
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    eventColor: 'green',
                    locale: 'ru',
                    events: {{ Js::from($events) }}
                });
                calendar.render();
            </script>
        </div>
    </div>

    <div class="m-portlet m-portlet--mobile">

        <div class="m-portlet__body">
            <!--begin: Datatable -->
            <table class="table table-striped- table-bordered table-hover table-checkable" id="data_list">
                <thead>
                <tr>
                    @foreach($columns as $column)
                        <th>
                            {{$column['name']??''}}
                        </th>
                    @endforeach

                </tr>
                </thead>
            </table>
        </div>
    </div>


    <script>
        let columns = {!! @json_encode($columns) !!},
            order = {!! @json_encode($order??[[1,'desc']]) !!}
    </script>


@endsection

