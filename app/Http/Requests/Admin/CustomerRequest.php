<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rules\Password;

class CustomerRequest extends FormRequest
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
            'name' => '',
            'e_address' => '',
            'contact_person_name' => '',
            'contact_person_position' => '',
            'contact_person_phone' => '',
            'contact_person_phone_work' => '',
            'contact_person_email' => '',
            'user_id' => '',
        ];
    }
    public function attributes()
    {
        return [
            'name'=>'Название компании',
            'e_address'=>'Интернет адрес компании',
            'contact_person_name'=>'Имя Фамилия',
            'contact_person_position'=>'Должность',
            'contact_person_phone'=>'Телефон',
            'contact_person_phone_work'=>'Телефон рабочий',
            'contact_person_email'=>'E-mail',

        ];
    }
}
