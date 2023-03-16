<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;
use function Symfony\Component\String\s;

class Application extends Model
{
    use HasFactory;


    public static $typeClientField = [
      'Фирма',
      'Агенство',
    ];

    public static $statusField  = [
        'Новая заявка',
        'Согласовываем предложение',
        'Всё получили решают',
    ];

    public static $probabilityField  = [
        'высокая',
        'средняя',
        'низкая',
    ];

    public static $fromField  = [
        'WM',
        'Ellite',
    ];

    public static $yesNoField  = [
        1 =>'Да',
        0 =>'Нет',
    ];


    protected $fillable = [
        'comment',
        'text_application',
        'name_firm',
        'date',
        'chance_date',
        'type_client',
        'status',
        'probability',
        'from',
        'active',
        'archive',
        'user_id',
    ];

    public static $fields =
        [];

    public static $listFields =
        [];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }



}
