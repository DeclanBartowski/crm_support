<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rules\Password;

class PlatformRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => '',
            'address' => '',
            'gps' => '',
            'description' => '',
            'director.name' => '',
            'director.phone' => '',
            'director.email' => '',
            'managers.*'=>''
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Название',
            'address' => 'Адрес',
            'gps' => 'gps координаты',
            'description' => 'Описание возможностей',
            'managers.0.name' => 'Имя менеджера',
            'managers.0.phone' => 'Телефон менеджера',
            'managers.0.email' => 'Email менеджера',
            'director.name' => 'Имя директора площадки',
            'director.phone' => 'Телефон директора площадки',
            'director.email' => 'Email директора площадки',
        ];
    }
}
