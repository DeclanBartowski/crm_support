<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'address',
        'gps',
        'description',
        'managers',
        'director'
    ];
    protected $casts = [
      'managers'=>'array',
      'director'=>'array',
    ];
    protected $appends = [
        'manager_name',
        'manager_phone'
    ];
    public static $fields =
        [

            'name' => [
                'label' => 'Название',
                'type' => 'text'
            ],
            'address' => [
                'label' => 'Адрес',
                'type' => 'text'
            ],
            'gps' => [
                'label' => 'gps координаты',
                'type' => 'text'
            ],
            'description' => [
                'label' => 'Описание возможностей',
                'type' => 'textarea'
            ],
            'managers' => [
                'label' => 'Менеджеры',
                'type' => 'json',
                'multiple'=>'Y',
                'max_count'=>4,
                'fields'=>[
                    'name' => [
                        'label' => 'Имя',
                        'type' => 'text'
                    ],
                    'phone' => [
                        'label' => 'Телефон',
                        'type' => 'text'
                    ],
                    'email' => [
                        'label' => 'Email',
                        'type' => 'text'
                    ],

                ]
            ],
            'director' => [
                'label' => 'Директор площадки',
                'type' => 'json',
                'fields'=>[
                    'name' => [
                        'label' => 'Имя',
                        'type' => 'text'
                    ],
                    'phone' => [
                        'label' => 'Телефон',
                        'type' => 'text'
                    ],
                    'email' => [
                        'label' => 'Email',
                        'type' => 'text'
                    ],

                ]
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
            'name' => 'Название',
            'link'=>'Y'
        ],
        [
            'data' => 'manager_name',
            'name' => 'Менеджер',
        ],
        [
            'data' => 'manager_phone',
            'name' => 'Телефон менеджера',
        ]
    ];
    public function getManagerNameAttribute(){
        $value = '';
        if($this->managers && is_array($this->managers)){
            $manager = $this->managers[0];
            $value = $manager['name'];
        }
        return $value;
    }
    public function getManagerPhoneAttribute(){
        $value = '';
        if($this->managers && is_array($this->managers)){
            $manager = $this->managers[0];
            $value = $manager['phone'];
        }
        return $value;
    }
}
