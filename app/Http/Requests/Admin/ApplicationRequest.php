<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rules\Password;

class ApplicationRequest extends FormRequest
{



    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'comment' => '',
            'text_application' => '',
            'name_firm' => '',
            'date' => '',
            'chance_date' => '',
            'type_client' => '',
            'status' => '',
            'probability' => '',
            'from' => '',
            'active' => '',
            'archive' => '',
            'user_id' => '',
        ];
    }

}
