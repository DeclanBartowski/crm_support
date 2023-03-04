<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rules\Password;

class EventRequest extends FormRequest
{

    protected function prepareForValidation()
    {
        $this->merge([
            'user_id' => Auth::id(),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date' => '',
            'sport' => '',
            'sport_time' => '',
            'additional_info' => '',
            'user_id' => '',
            'customer_id' => '',
            'platform_id' => '',
            'attachment_to_agreement' => '',
            'attachment_to_agreement_old' => '',
            'is_canceled' => '',
            'cancel_reason' => ['required_with:is_canceled'],
            'cancel_reason_official' => ['required_with:is_canceled'],
            'cancel_stage' => ['required_with:is_canceled'],
            'cancel_reason_list' => ['required_with:is_canceled'],

        ];
    }

    public function attributes()
    {
        return [
            'date' => 'Дата',
            'sport' => 'Спортивная часть',
            'sport_time' => 'Время начала спорт. части',
            'additional_info' => 'Дополнительная информация по мероприятию',
            'user_id' => 'Сотрудник',
            'customer_id' => 'Контактное лицо',
            'platform_id' => 'Площадка',
            'attachment_to_agreement' => 'Приложение к договору',
            'is_canceled' => 'Мероприятие отменилось',
            'cancel_reason' => 'Своими словами',
            'cancel_reason_official' => 'Официальная версия от заказчиков',
            'cancel_stage' => 'На каком этапе',
            'cancel_reason_list' => 'По какой причине',

        ];
    }
}
