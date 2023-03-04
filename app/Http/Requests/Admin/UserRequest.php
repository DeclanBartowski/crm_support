<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
{



    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if(Route::current()->getAction('as') == 'admin.employers.update'){
            if($this->request->get('password')){
                return [
                    'name'=>['required','min:2','max:50','regex:/[A-z]|[А-я]/'],
                    'password'=>['required',Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised()]
                ];
            }else{
                return [
                    'name'=>['required','min:2','max:50','regex:/[A-z]|[А-я]/'],
                ];
            }

        }else{
            return [
                'name'=>['required','min:2','max:50','regex:/[A-z]|[А-я]/'],
                'password'=>['required',Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised()]
            ];
        }


    }
}
