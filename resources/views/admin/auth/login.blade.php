@extends('admin.layouts.app')
@section('content')
    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
											<span class="m-portlet__head-icon m--hide">
												<i class="la la-gear"></i>
											</span>
                    <h3 class="m-portlet__head-text">
                        {{__('auth/login.title')}}
                    </h3>
                </div>
            </div>
        </div>
        <!--begin::Form-->
        <form class="m-form m-form--fit m-form--label-align-right" action="{{route('user-login')}}" method="post">
            @csrf
            <x-admin.session-status :status="session('status')"/>
            <x-admin.validation-errors :errors="$errors"/>
            <div class="m-portlet__body">
                <div class="form-group m-form__group">
                    <label for="exampleInputEmail1">
                        {{__('auth/login.login')}}
                    </label>
                    <input name="login" type="text" class="form-control m-input m-input--square" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                <div class="form-group m-form__group">
                    <label for="exampleInputPassword1">
                        {{__('auth/login.password')}}
                    </label>

                    <input name="password" type="password" class="form-control m-input m-input--square" id="exampleInputPassword1">
                </div>
            </div>
            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions">
                    <button class="btn btn-metal">
                        {{__('auth/login.submit')}}
                    </button>
                </div>
            </div>
        </form>
        <!--end::Form-->
    </div>


@endsection
