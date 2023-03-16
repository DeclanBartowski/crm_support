@extends('admin.layouts.app')
@section('content')
    <div class="m-portlet m-portlet--mobile">
        <x-admin.session-status :status="session('status')"/>
        <x-admin.validation-errors :errors="$errors"/>
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        {{'Архив заявок'}}
                    </h3>
                </div>
            </div>

        </div>
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
        <div class="m-portlet__foot">
            <div class="row align-items-center">
                <div class="col-lg-6 m--valign-middle">

                </div>
                <div class="col-lg-6 m--align-right">
                    <button data-url="{{route('archive_restore')}}" type="button" class="btn btn-primary ">
                        Вернуть
                    </button>
                    <button data-url="{{route('archive_remove')}}" type="button" class="btn btn btn-primary ">
                        Удалить
                    </button>
                </div>
            </div>
        </div>
    </div>


    <script>
        let columns = {!! @json_encode($columns) !!},
            order = {!! @json_encode($order??[[1,'desc']]) !!}
    </script>
@endsection

