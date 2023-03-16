@extends('admin.layouts.app')
@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        {{$item->name??'Добавление заявки'}}
                    </h3>
                </div>

            </div>
        </div>
        <form action="{{route('applications.store')}}" method="post" class="m-form" enctype="multipart/form-data">

            @csrf
            <x-admin.session-status :status="session('status')"/>
            <x-admin.validation-errors :errors="$errors"/>
            <div class="m-portlet__body">
                <div class="tab-content">
                    <div class="tab-pane active show" id="tab_general" role="tabpanel">
                        <div class="form-group m-form__group row">
                            <label for="name_firm" class="col-2 col-form-label">
                                Клиент
                            </label>
                            <div class="col-10">
                                <input class="form-control m-input" name="name_firm" type="text" value=""  required>
                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            <label for="comment" class="col-2 col-form-label">
                                Комментарий
                            </label>
                            <div class="col-10">
                                <textarea rows="10" class="form-control m-input" name="comment" type="text" id="comment" required
                                          maxlength="200"></textarea>
                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            <label for="text_application" class="col-2 col-form-label">
                                Текст заявки
                            </label>
                            <div class="col-10">
                                <textarea rows="10" class="form-control m-input" name="text_application" type="text" required
                                          id="text_application" maxlength="200"></textarea>
                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            <div class="col-md-6">
                                <label for="date" class="col-2 col-form-label">
                                    Дата
                                </label>
                                <div class="col-10">
                                    <input class="form-control m-input" name="date" type="date" value="" id="date" required
                                           max="9999-12-31T23:59">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="chance_date" class="col-6 col-form-label">
                                    Предполагаемая дата
                                </label>
                                <div class="col-10">
                                    <input class="form-control m-input" name="chance_date" type="text"  required
                                           value="" >
                                </div>

                            </div>

                        </div>

                        <div class="form-group m-form__group row">
                            <label for="type_client" class="col-2 col-form-label">
                                Тип клиента
                            </label>
                            <div class="col-10">
                                <select class="form-control m-select2" id="type_client" name="type_client" required>
                                    <option></option>
                                    @foreach($typeClients as $client)
                                        <option value="{{$client}}">{{$client}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            <label for="status" class="col-2 col-form-label">
                                Статус заявки
                            </label>
                            <div class="col-10">
                                <select class="form-control m-select2" id="status" name="status" required>
                                    <option></option>
                                    @foreach($statuses as $status)
                                        <option value="{{$status}}">{{$status}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            <label for="probability" class="col-2 col-form-label">
                                Вероятность
                            </label>
                            <div class="col-10">
                                <select class="form-control m-select2" id="probability" name="probability" required>
                                    <option></option>
                                    @foreach($probabilities as $propability)
                                        <option value="{{$propability}}">{{$propability}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            <label for="from" class="col-2 col-form-label">
                                От кого
                            </label>
                            <div class="col-10">
                                <select class="form-control m-select2" id="from" name="from" required>
                                    <option></option>
                                    @foreach($froms as $form)
                                        <option value="{{$form}}">{{$form}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            <label for="active" class="col-2 col-form-label">
                                Актуальна
                            </label>
                            <div class="col-10">
                                <select class="form-control m-select2" id="active" name="active" required>
                                    <option></option>
                                    @foreach($yesNo as $key => $choice)
                                        <option value="{{$key}}">{{$choice}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        @if(auth()->user()->is_admin)
                            <div class="form-group m-form__group row">
                                <label for="archive" class="col-2 col-form-label">
                                    Архив
                                </label>
                                <div class="col-10">
                                    <select class="form-control m-select2" id="archive" name="archive" required>
                                        <option></option>
                                        @foreach($yesNo as $key => $choice)
                                            <option value="{{$key}}">{{$choice}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label for="user_id" class="col-2 col-form-label">
                                    Менеджер
                                </label>
                                <div class="col-10">
                                    <select class="form-control m-select2" id="user_id" name="user_id" required>
                                        <option></option>
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions m-form__actions">
                    <div class="row">
                        <div class="col-lg-9 ml-lg-rigth" style="text-align: end;">
                            <button type="submit" class="btn btn-brand">
                                Сохранить
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>

@endsection

