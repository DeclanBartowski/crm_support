<?php


namespace App\View\Components\Admin;


use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Route;

class AdminMenu extends Component
{
    public $arMenu;

    /**
     * AdminMenu constructor.
     */
    public function __construct()
    {
        $prefix = Route::current()->compiled->getStaticPrefix();
        $expPrefix = array_diff(explode('/', $prefix), array(''));;

        if (Auth::check()) {
            $user = Auth::user();
            if ($user->isAdmin()) {
                $arTabs = [
                    'applications' =>
                        [
                            'name' => 'Заявки',
                            'icon' => 'flaticon-event-calendar-symbol',
                            'items' =>
                                [
                                    'applications.index' => [
                                        'name' => 'Список заявок'
                                    ],
                                    'applications.create' => [
                                        'name' => 'Создать заявку'
                                    ],


                                ]
                        ],
                    'events' =>
                        [
                            'name' => 'Мероприятия',
                            'icon' => 'flaticon-event-calendar-symbol',
                            'items' =>
                                [
                                    'events.index' => [
                                        'name' => 'Список мероприятий'
                                    ],
                                    'events.create' => [
                                        'name' => 'Добавить мероприятие'
                                    ],

                                ]
                        ],

                    'customers' =>
                        [
                            'name' => 'Заказчики',
                            'icon' => 'flaticon-suitcase',
                            'items' =>
                                [
                                    'customers.index' => [
                                        'name' => 'Список заказчиков'
                                    ],
                                    'customers.create' => [
                                        'name' => 'Добавить заказчика'
                                    ],

                                ]
                        ],
                    'archive' =>
                        [
                            'name' => 'Архив',
                            'icon' => 'flaticon-tool',
                            'items' =>
                                [
                                    'archive.index' => [
                                        'name' => 'Список мероприятий'
                                    ],
                                    'archive_applications' => [
                                        'name' => 'Архив заявок'
                                    ],
                                ]
                        ],
                    'employers' =>
                        [
                            'name' => 'Сотрудники',
                            'icon' => 'flaticon-users',
                            'items' =>
                                [
                                    'employers.index' => [
                                        'name' => 'Список сотрудников'
                                    ],
                                    'employers.create' => [
                                        'name' => 'Добавить сотрудник'
                                    ],

                                ]
                        ],
                    'platforms' =>
                        [
                            'name' => 'Площадки',
                            'icon' => 'flaticon-layers',
                            'items' =>
                                [
                                    'platforms.index' => [
                                        'name' => 'Список площадок'
                                    ],
                                    'platforms.create' => [
                                        'name' => 'Добавить площадку'
                                    ],

                                ]
                        ],

                ];
            } else {
                $arTabs = [
                    'events' =>
                        [
                            'name' => 'Мероприятия',
                            'icon' => 'flaticon-event-calendar-symbol',
                            'items' =>
                                [
                                    'events.index' => [
                                        'name' => 'Список мероприятий'
                                    ],
                                    'events.create' => [
                                        'name' => 'Добавить мероприятие'
                                    ],

                                ]
                        ],
                    'customers' =>
                        [
                            'name' => 'Заказчики',
                            'icon' => 'flaticon-suitcase',
                            'items' =>
                                [
                                    'customers.index' => [
                                        'name' => 'Список заказчиков'
                                    ],
                                    'customers.create' => [
                                        'name' => 'Добавить заказчика'
                                    ],

                                ]
                        ],
                    'platforms' =>
                        [
                            'name' => 'Площадки',
                            'icon' => 'flaticon-layers',
                            'items' =>
                                [
                                    'platforms.index' => [
                                        'name' => 'Список площадок'
                                    ],
                                    'platforms.create' => [
                                        'name' => 'Добавить площадку'
                                    ],

                                ]
                        ],
                ];
            }
        } else {
            $arTabs = [
                'login' =>
                    [
                        'name' => 'Авторизация',
                        'icon' => 'flaticon-settings-1',
                        'items' =>
                            [
                                'login' => [
                                    'name' => 'Вход',
                                ],
                            ]
                    ],
            ];
        }


        foreach ($arTabs as &$arTab) {
            foreach ($arTab['items'] as $key => &$arItem) {
                if (Route::has($key)) {
                    if (isset($arItem['item']) && $arItem['item']) {
                        $arItem['url'] = route($key, $arItem['item']);
                    } else {
                        $arItem['url'] = route($key);
                    }

                    if (strpos($arItem['url'], $prefix) && count($expPrefix) > 1 || Route::is($key)) {
                        $arItem['current'] = 'Y';
                        $arTab['current'] = 'Y';
                    }
                } else {
                    unset($arTab['items'][$key]);
                }
            }
            unset($arItem);
        }
        unset($arTab);
        $this->arMenu = $arTabs;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.admin.menu');
    }
}
