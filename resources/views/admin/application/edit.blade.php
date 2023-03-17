@extends('admin.layouts.app')
@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        {{'Редактировать заявку'}}
                    </h3>
                </div>

            </div>
        </div>
        <form action="{{route('applications.update', ['application' => $application->id])}}" method="post" class="m-form" enctype="multipart/form-data">

            @method('PUT')
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
                                <input class="form-control m-input" name="name_firm" type="text" value="{{$application->name_firm}}"  >
                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            <label for="comment" class="col-2 col-form-label">
                                Комментарий
                            </label>
                            <div class="col-10">
                                <textarea rows="10" class="form-control m-input" name="comment" type="text" id="comment"
                                          maxlength="200">{{$application->comment}}</textarea>
                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            <label for="text_application" class="col-2 col-form-label">
                                Текст заявки
                            </label>
                            <div class="col-10">
                                <textarea rows="10" class="form-control m-input" name="text_application" type="text"
                                          id="text_application" maxlength="200">{{$application->text_application}}</textarea>
                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            <div class="col-md-6">
                                <label for="date" class="col-2 col-form-label">
                                    Дата
                                </label>
                                <div class="col-10">
                                    <input class="form-control m-input" name="date" type="date" value="{{$application->date}}" id="date"
                                           max="9999-12-31T23:59">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="chance_date" class="col-6 col-form-label">
                                    Предполагаемая дата
                                </label>
                                <div class="col-10">
                                    <input class="form-control m-input" name="chance_date" type="text" id="chance_date"
                                           value="{{$application->chance_date}}" max="9999-12-31T23:59">
                                </div>

                            </div>

                        </div>

                        <div class="form-group m-form__group row">
                            <label for="type_client" class="col-2 col-form-label">
                                Тип клиента
                            </label>
                            <div class="col-10">
                                <select class="form-control m-select2" id="type_client" name="type_client" >
                                    <option></option>
                                    @foreach($typeClients as $client)
                                        <option @if($application->type_client  == $client) selected @endif value="{{$client}}">{{$client}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            <label for="status" class="col-2 col-form-label">
                                Статус заявки
                            </label>
                            <div class="col-10">
                                <select class="form-control m-select2" id="status" name="status" >
                                    <option></option>
                                    @foreach($statuses as $status)
                                        <option @if($application->status  == $status) selected @endif value="{{$status}}">{{$status}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            <label for="probability" class="col-2 col-form-label">
                                Вероятность
                            </label>
                            <div class="col-10">
                                <select class="form-control m-select2" id="probability" name="probability" >
                                    <option></option>
                                    @foreach($probabilities as $propability)
                                        <option @if($application->probability  == $propability) selected @endif value="{{$propability}}">{{$propability}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            <label for="from" class="col-2 col-form-label">
                                От кого
                            </label>
                            <div class="col-10">
                                <select class="form-control m-select2" id="from" name="from" >
                                    <option></option>
                                    @foreach($froms as $form)
                                        <option @if($application->from  == $form) selected @endif value="{{$form}}">{{$form}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            <label for="active" class="col-2 col-form-label">
                                Актуальна
                            </label>
                            <div class="col-10">
                                <select class="form-control m-select2" id="active" name="active" >
                                    <option></option>
                                    @foreach($yesNo as $key => $choice)
                                        <option @if($application->active  == $key) selected @endif value="{{$key}}">{{$choice}}</option>
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
                                    <select class="form-control m-select2" id="archive" name="archive" >
                                        <option></option>
                                        @foreach($yesNo as $key => $choice)
                                            <option @if($application->archive  == $key) selected @endif value="{{$key}}">{{$choice}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label for="user_id" class="col-2 col-form-label">
                                    Менеджер
                                </label>
                                <div class="col-10">
                                    <select class="form-control m-select2" id="user_id" name="user_id" >
                                        <option></option>
                                        @foreach($users as $user)
                                            <option @if($application->user_id  == $user->id) selected @endif value="{{$user->id}}">{{$user->name}}</option>
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

    <div class="m-portlet m-portlet--mobile">

        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        {{'Конвертация'}}
                    </h3>
                </div>

            </div>
        </div>
        <div class="m-portlet__body">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active show" data-toggle="tab" href="#tab_general1">
                        Заказчик
                    </a>

                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab_general2">
                        Мероприятие
                    </a>

                </li>
            </ul>


            <div class="tab-content">
                <div class="tab-pane active show" id="tab_general1" role="tabpanel">
                    <form action="{{route('agent_add')}}" method="post" class="m-form" data-add-contact>
                        @csrf
                        @method('POST')
                        <input type="hidden" name="user_id" value="{{\Illuminate\Support\Facades\Auth::user()->id}}">
                        <div class="form-group m-form__group row" 0="">
                            <label for="name" class="col-2 col-form-label">
                                Название компании
                            </label>
                            <div class="col-10">
                                <input class="form-control m-input" name="name" type="text" value="" id="name" required
                                       maxlength="60">
                            </div>
                        </div>
                        <div class="form-group m-form__group row" 0="">
                            <label for="e_address" class="col-2 col-form-label">
                                Интернет адрес компании
                            </label>
                            <div class="col-10">
                                <input required class="form-control m-input" name="e_address" type="text" value="" id="e_address"
                                       maxlength="200">
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-12">
                                Контактное лицо
                            </div>

                        </div>
                        <div class="form-group m-form__group row" 0="">
                            <label for="contact_person_name" class="col-2 col-form-label">
                                Имя Фамилия
                            </label>
                            <div class="col-10">
                                <input class="form-control m-input" name="contact_person_name" required type="text" value=""
                                       id="contact_person_name" maxlength="200">
                            </div>
                        </div>
                        <div class="form-group m-form__group row" 0="">
                            <label for="contact_person_position" class="col-2 col-form-label">
                                Должность
                            </label>
                            <div class="col-10">
                                <input class="form-control m-input" name="contact_person_position" required type="text" value=""
                                       id="contact_person_position" maxlength="200">
                            </div>
                        </div>
                        <div class="form-group m-form__group row" 0="">
                            <label for="contact_person_phone" class="col-2 col-form-label">
                                Телефон
                            </label>
                            <div class="col-10">
                                <input class="form-control m-input" name="contact_person_phone" required type="text" value=""
                                       id="contact_person_phone" maxlength="200">
                            </div>
                        </div>
                        <div class="form-group m-form__group row" 0="">
                            <label for="contact_person_phone_work" class="col-2 col-form-label">
                                Телефон рабочий
                            </label>
                            <div class="col-10">
                                <input class="form-control m-input" name="contact_person_phone_work" required type="text"
                                       value="" id="contact_person_phone_work" maxlength="200">
                            </div>
                        </div>
                        <div class="form-group m-form__group row" 0="">
                            <label for="contact_person_email" class="col-2 col-form-label">
                                E-mail
                            </label>
                            <div class="col-10">
                                <input class="form-control m-input" name="contact_person_email" required type="text" value=""
                                       id="contact_person_email" maxlength="200">
                            </div>
                        </div>
                        <div class="m-portlet__foot m-portlet__foot--fit">
                            <div class="m-form__actions m-form__actions">
                                <div class="row">
                                    <div class="col-lg-12 ml-lg-rigth" style="text-align: end;">
                                        <button type="submit"  class="btn btn-brand">
                                            Сохранить
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane " id="tab_general2" role="tabpanel">
                    <form action="{{route('event_add')}}" method="post" class="m-form" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="app" value="{{$application->id}}">
                        <div class="form-group m-form__group row">
                            <label for="date" class="col-2 col-form-label">
                                Дата
                            </label>
                            <div class="col-10">
                                <input class="form-control m-input" name="date" type="date" value="" id="date"
                                       max="9999-12-31T23:59">
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label for="sport" class="col-2 col-form-label">
                                Спортивная часть
                            </label>
                            <div class="col-10">
                            <textarea rows="10" class="form-control m-input" name="sport" type="text" id="sport"
                                      maxlength="200"></textarea>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label for="additional_info" class="col-2 col-form-label">
                                Дополнительная информация по мероприятию
                            </label>
                            <div class="col-10">
                            <textarea rows="10" class="form-control m-input" name="additional_info" type="text"
                                      id="additional_info" maxlength="200"></textarea>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label for="customer_id" class="col-2 col-form-label">
                                Контактное лицо
                            </label>
                            <div class="col-10" id="customersSet">
                                <select class="form-control m-select2" id="customer_id" name="customer_id">
                                    <option></option>
                                    @foreach($employers as $empl)
                                        <option value="{{$empl->id}}">{{$empl->contact_person_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label for="platform_id" class="col-2 col-form-label">
                                Площадка
                            </label>
                            <div class="col-10">
                                <select class="form-control m-select2" id="platform_id" name="platform_id">
                                    <option></option>
                                    @foreach($placement as $pl)
                                        <option value="{{$pl->id}}">{{$pl->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label for="attachment_to_agreement" class="col-2 col-form-label">
                                Приложение к договору
                            </label>
                            <div class="col-10 ">
                                <div class="custom-file">
                                    <input class="custom-file-input" name="attachment_to_agreement" type="file" value=""
                                           id="attachment_to_agreement">
                                    <label class="custom-file-label" for="attachment_to_agreement">Выберите файл</label>
                                </div>

                            </div>
                        </div>

                        <div class="m-portlet__foot m-portlet__foot--fit">
                            <div class="m-form__actions m-form__actions">
                                <div class="row">
                                    <div class="col-lg-12 ml-lg-rigth" style="text-align: end;">
                                        <button type="submit"  class="btn btn-brand">
                                            Сохранить
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>

@endsection

