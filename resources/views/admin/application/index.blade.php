@extends('admin.layouts.app')
@section('content')
    <div class="m-portlet m-portlet--mobile">
        <x-admin.session-status :status="session('status')"/>
        <x-admin.validation-errors :errors="$errors"/>
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        {{'Список заявок'}}
                    </h3>
                </div>
            </div>

            <div class="m-portlet__head-tools">
                @if(auth()->user()->is_admin)
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <a href="{{route('applications.create')}}" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
								<span>
                                    <i class="la la-plus-circle"></i>
                                    <span>Добавить заявку</span>
								</span>
                            </a>
                        </li>
                    </ul>
                @endif
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
                    <button data-url="{{route('application_deactive')}}" type="button" class="btn btn-primary ">
                        Деактивировать
                    </button>
                    @if(auth()->user()->is_admin)
                        <button data-url="{{route('archive_action')}}" type="button" class="btn btn btn-primary ">
                            Архив
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="m-portlet m-portlet--mobile">

        <div class="m-portlet__body">
            <!--begin: Datatable -->
            <table class="table table-striped- table-bordered table-hover table-checkable" id="data_list_2">
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
                        <button data-url="{{route('application_active')}}" type="button" class="btn btn-primary ">
                            Активировать
                        </button>
                        @if(auth()->user()->is_admin)
                            <button data-url="{{route('archive_action')}}" type="button" class="btn btn btn-primary ">
                                Архив
                            </button>
                        @endif
                    </div>
                </div>
            </div>
    </div>

    <script>
        let columns = {!! @json_encode($columns) !!},
            order = {!! @json_encode($order??[[1,'desc']]) !!}
    </script>
@endsection

