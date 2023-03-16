<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;
use function Symfony\Component\String\s;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'sport',
       // 'sport_time',
        'additional_info',
        'customer_id',
        'platform_id',
        'user_id',
        'attachment_to_agreement',
//        'is_canceled',
//        'cancel_reason',
//        'cancel_reason_official',
//        'cancel_stage',
//        'cancel_reason_list',
        'is_agreement',
        'is_payed',
    ];
    public static $fields =
        [
            'date' => [
                'label' => 'Дата',
                'type' => 'date',
                'input_type' => 'date'
            ],
            'sport' => [
                'label' => 'Спортивная часть',
                'type' => 'textarea'
            ],
//            'sport_time' => [
//                'label' => 'Время начала спорт. части',
//                'type' => 'date',
//                'input_type' => 'time'
//            ],
            'additional_info' => [
                'label' => 'Дополнительная информация по мероприятию',
                'type' => 'textarea'
            ],
            'customer_id' => [
                'label' => 'Контактное лицо',
                'type' => 'list',
                'model' => 'App\Models\Customer',
                'name_field' => 'contact_person_name'
            ],
            'platform_id' => [
                'label' => 'Площадка',
                'type' => 'list',
                'model' => 'App\Models\Platform',
            ],
            'attachment_to_agreement' => [
                'label' => 'Приложение к договору',
                'type' => 'file'
            ],
//            'is_canceled' => [
//                'label' => 'Мероприятие отменилось',
//                'type' => 'boolean'
//            ],
//            'cancel_reason_title' => [
//                'label' => 'Почему мероприятие отменилось',
//                'type' => 'title',
//                'show_if' => 'is_canceled'
//            ],
//            'cancel_reason' => [
//                'label' => 'Своими словами',
//                'type' => 'textarea',
//                'show_if' => 'is_canceled'
//            ],
//            'cancel_reason_official' => [
//                'label' => 'Официальная версия от заказчиков',
//                'type' => 'textarea',
//                'show_if' => 'is_canceled'
//            ],
//            'cancel_stage' => [
//                'label' => 'На каком этапе',
//                'type' => 'list',
//                'values' => [
//                    [
//                        'id' => 'При первичном уточнении деталей',
//                        'name' => 'При первичном уточнении деталей'
//                    ],
//                    [
//                        'id' => 'При согласовании коммерческого предложения',
//                        'name' => 'При согласовании коммерческого предложения'
//                    ],
//                    [
//                        'id' => 'При согласовании договора',
//                        'name' => 'При согласовании договора'
//                    ],
//                    [
//                        'id' => 'Не поступила оплата при подписанном договоре',
//                        'name' => 'Не поступила оплата при подписанном договоре'
//                    ],
//                ],
//                'show_if' => 'is_canceled'
//            ],
//            'cancel_reason_list' => [
//                'label' => 'По какой причине',
//                'type' => 'list',
//                'values' => [
//                    [
//                        'id' => 'Выбрали другого поставщика услуг',
//                        'name' => 'Выбрали другого поставщика услуг'
//                    ],
//                    [
//                        'id' => 'Отменили мероприятие совсем',
//                        'name' => 'Отменили мероприятие совсем'
//                    ],
//                    [
//                        'id' => 'Хотят свои нереальные условия в договоре',
//                        'name' => 'Хотят свои нереальные условия в договоре'
//                    ],
//                    [
//                        'id' => 'Хотят свои нереальные условия по оплате',
//                        'name' => 'Хотят свои нереальные условия по оплате'
//                    ],
//                    [
//                        'id' => 'Другое',
//                        'name' => 'Другое'
//                    ],
//                ],
//                'show_if' => 'is_canceled'
//            ],

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
            'name' => 'ID',
            'link' => 'Y'
        ],
        [
            'data' => 'date',
            'name' => 'Дата',
            'link' => 'Y'
        ],
        [
            'data' => 'sport',
            'name' => 'Спортивная часть',
            'link' => 'Y'
        ],
//        [
//            'data' => 'sport_time',
//            'name' => 'Время начала спортивной части ',
//        ],
        [
            'data' => 'customer_column',
            'name' => 'Название фирмы',
            'custom_fields'=>'Y'
        ],
        [
            'data' => 'platform_column',
            'name' => 'Название площадки',
            'custom_fields'=>'Y'
        ],
        [
            'data' => 'agreement_column',
            'name' => 'Договор',
            'custom_fields'=>'Y',
            'orderable' => false,
            'searchable' => false

        ],
        [
            'data' => 'payed_column',
            'name' => 'Оплата',
            'custom_fields'=>'Y',
            'orderable' => false,
            'searchable' => false
        ],
        [
            'data' => 'condition_column',
            'name' => 'Состояние',
            'custom_fields'=>'Y',
            'orderable' => false,
            'searchable' => false
        ],
        [
            'data' => 'attachment_to_agreement_column',
            'name' => 'Приложение к договору',
            'custom_fields'=>'Y',
            'orderable' => false,
            'searchable' => false
        ],
        [
            'data' => 'archive_column',
            'name' => 'Закрывающие',
            'custom_fields'=>'Y',
            'orderable' => false,
            'searchable' => false
        ],
        [
            'data' => 'user_column',
            'name' => 'Сотрудник',
            'custom_fields'=>'Y'
        ]
    ];
    protected $appends = [
        'customer_column',
        'platform_column',
        'agreement_column',
        'payed_column',
        'condition_column',
        'attachment_to_agreement_column',
        'archive_column',
        'user_column',
        'date_order',
    ];
    public function getCustomerColumnAttribute(){
        $value = '-';
        if($this->relationLoaded('customer') && $customer = $this->getRelation('customer')){
                $value = sprintf('<a href="%s">%s</a>',route('customers.edit',$customer),$customer->name);
        }
        return $value;
    }
    public function getSportTimeAttribute($value){

        if($value){
            $value = date('h:i',strtotime($value));
        }
        return $value;
    }
    public function getSportStringAttribute($value){

        $value = $this->sport;
        if($value) {
            $value =  Str::limit($value, 40);
        }

        return $value;
    }

    public function getSportTimeStringAttribute($value){

        $value = $this->date;
        if($value) {
            $value =  date('d.m.Y', strtotime($value));
        }

        return $value;
    }
    public function getDateOrderAttribute(){
        if($this->date){
            $value =  strtotime($this->date) < time() ? -1 : 1;
        }else{
            $value = 0;
        }

        return $value;
    }
    public function getPlatformColumnAttribute(){
        $value = '-';
        if($this->relationLoaded('platform') && $platform = $this->getRelation('platform')){
            $value = sprintf('<a href="%s">%s</a>',route('platforms.edit',$platform),$platform->name);
        }
        return $value;
    }
    public function getAgreementColumnAttribute(){
        $checked = '';
        if($this->is_agreement == 1){
            $checked = 'checked';
        }
        return sprintf('<div class="center_column"><input data-id="%s" type="checkbox" name="is_agreement" value="1" %s></div>',$this->id,$checked);
    }
    public function getPayedColumnAttribute(){
        $checked = '';
        if($this->is_payed == 1){
            $checked = 'checked';
        }
        return sprintf('<div class="center_column"><input data-id="%s" type="checkbox" name="is_payed" value="1" %s></div>',$this->id,$checked);
    }
    public function getConditionColumnAttribute(){
        $value = '<span class="m-badge m-badge--danger m-badge--wide"></span>';
        if($this->is_agreement == 1 && $this->is_payed == 1){
            $value = '<span class="m-badge m-badge--success m-badge--wide"></span>';
        }

        return sprintf('<div class="center_column">%s</div>',$value);
    }
    public function getAttachmentToAgreementColumnAttribute(){
        $value = '-';
        if($this->attachment_to_agreement){
            $value = sprintf('<a href="%1$s" target="_blank">%1$s</a>',asset($this->attachment_to_agreement));
        }
        return $value;
    }
    public function getArchiveColumnAttribute(){
        $checked = '';
        if($this->is_archive == 1){
            $checked = 'checked';
        }
        return sprintf('<div class="center_column"><input data-id="%s" type="checkbox" name="is_archive" value="1" %s></div>',$this->id,$checked);
    }
    public function getUserColumnAttribute(){
        $value = '-';
        if($this->relationLoaded('user') && $user = $this->getRelation('user')){
            $value = $user->name;
        }
        return $value;
    }
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id');
    }
    public function platform(){
        return $this->belongsTo(Platform::class,'platform_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }


    protected static function booted()
    {
        static::created(function ($event) {
            if ($event->is_canceled == 1 && $event->is_archive != 1) {
                $event->is_archive = 1;
                $event->save();
            }
        });
        static::updating(function ($event) {
            $oldEvent = Event::find($event->id);
            if ($event->is_canceled == 1 && $oldEvent->is_canceled == 0 && $oldEvent->is_archive != 1) {
                $event->is_archive = 1;
            }
        });
    }
}
