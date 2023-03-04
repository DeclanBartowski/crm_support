<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'e_address',
        'contact_person_name',
        'contact_person_position',
        'contact_person_phone',
        'contact_person_phone_work',
        'contact_person_email',
        'user_id',
    ];

    public static $fields =
        [

            'name' => [
                'label' => 'Название компании',
                'type' => 'text'
            ],
            'e_address' => [
                'label' => 'Интернет адрес компании',
                'type' => 'text'
            ],
            'contact_person' => [
                'label' => 'Контактное лицо',
                'type' => 'title'
            ],
            'contact_person_name' => [
                'label' => 'Имя Фамилия',
                'type' => 'text'
            ],
            'contact_person_position' => [
                'label' => 'Должность',
                'type' => 'text'
            ],
            'contact_person_phone' => [
                'label' => 'Телефон',
                'type' => 'text'
            ],
            'contact_person_phone_work' => [
                'label' => 'Телефон рабочий',
                'type' => 'text'
            ],
            'contact_person_email' => [
                'label' => 'E-mail',
                'type' => 'text'
            ],

        ];
    public static $listFields = [
        [
            'data' => 'check',
            'name' => '',
            'orderable' => false,
            'searchable' => false
        ],
        [
            'data' => 'id',
            'name' => 'ID'
        ],
        [
            'data' => 'name',
            'name' => 'Название компании',
            'link'=>'Y'
        ],
        [
            'data' => 'contact_person_name',
            'name' => 'Имя Фамилия',
        ],
        [
            'data' => 'contact_person_phone',
            'name' => 'Телефон',
        ],
        [
            'data' => 'contact_person_email',
            'name' => 'E-mail',
        ]
    ];
}
