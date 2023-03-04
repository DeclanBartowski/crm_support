@extends('admin.layouts.app')
@section('content')
    <div class="m-portlet m-portlet--mobile">
        <x-admin.session-status :status="session('status')"/>
        <x-admin.validation-errors :errors="$errors"/>
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        {{$title??''}}
                    </h3>
                </div>
            </div>
            @if(isset($addLink,$addText) && $addLink && $addText)
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <a href="{{$addLink}}" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
												<span>
													<i class="la la-plus-circle"></i>
													<span>
														{{$addText??'Добавить элемент'}}
													</span>
												</span>
                        </a>
                    </li>
                </ul>
            </div>
            @endif
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
        @if(isset($model) && $model)
        <div class="m-portlet__foot" >
            <div class="row align-items-center">
                <div class="col-lg-6 m--valign-middle">
                </div>
                <div class="col-lg-6 m--align-right">
                    <button data-delete-model="{{$model}}" type="button" class="btn btn-danger">
                        Удалить
                    </button>
                </div>
            </div>
        </div>
        @endif
    </div>
    <script>
        let columns = {!! @json_encode($columns) !!},
            order = {!! @json_encode($order??[[1,'desc']]) !!}
    </script>
@endsection

