<?php

return [
    'success' => 'Теперь можно смотреть другие зарплаты!',
    'error' => 'Упс, ждем еще анкет от других пользователей. Пока мало анкет, чтобы отобразить информацию. Мы только недавно запустились, немного терпения😊 А если вы поделитесь о нашем сервисе со своими знакомыми в логистике, мы будем вам очень благодарны!',
    'filter_error' => 'Попробуй сократить фильтр, может тогда появятся зарплаты',
    'edit_text'=>':date вы вносили свою зарплату с параметрами, что на форме ниже. Если внесёте новую, то она заменит собой старую и будет использоваться для расчётов.',
    'price' => ':price руб.',
    'median' => 'Медиана :price руб.',
    'percentile' => ':numb перцентиль',
    'graph_value' => ':value% от общего числа зарплат',
    'form_quantity' => ':count анкеты|:count анкет|:count анкет',
    'form_quantity_bottom' => '<span>:count</span>Внесенная зарплата|<span>:count</span>Внесенные зарплаты|<span>:count</span>Внесенных зарплат',
    'add_href' => 'Добавляй свою, это просто!',
    'add_btn' => 'Добавить зарплату',
    'edit_btn' => 'Скорректировать зарплату',
    'median_wage' => ':rub руб. в месяц (:usd$/:eur€)',
    'see_wages' => 'Смотреть зп по фильтрам',
    'add_wage_text' => 'Заполни свою зарплату и смотри зарплаты по любым должностям. Кнопка «Добавить зарплату» выше.',
    'see_any_wages'=>'Смотри зарплаты по любым должностям.',
    'thx'=>'Спасибо за твой вклад!',
    'to_auth' => 'Авторизоваться',
    'need_auth' => 'Чтобы детально смотреть статистику по зарплатам, нужно авторизоваться и оставить свою.',
    'filter_title'=>'Смотреть зарплату по фильтрам',
    'founded_title'=>'Зарплаты в логистике:',
    'founded'=>'Найдена :count зарплата|Найдено :count зарплаты|Найдено :count зарплат',
    'not_enough'=>'Это мало! Расскажи о нас знакомым логистам',
    'filter_hint'=>'Подсказка:',
    'percentiles_hints'=>[
        5 =>'Зарплата 5 перцентиля — это значит, что 5% зарплат меньше суммы указанной на графике, а 95% больше.',
        25=>'Зарплата 25 перцентиля — это значит, что 25% зарплат меньше суммы указанной на графике, а 75% больше. ',
        50=>'Медиана — та зарплата, ниже которой получает одна 50% специалистов, и больше другая 50% специалистов. Можно считать эту зарплату более точной средней зарплатой, чем классическая «просто средняя» зарплата. К примеру, есть группа из 10 человек. У них зарплаты распределяются так: 500, 700, 800, 1000, 1500, 3500, 5000, 5500, 6000, 7000. Средняя при этом будет 3150, а медианная 2500.',
        75=>'Зарплата 75 перцентиля — это значит, что 75% зарплат меньше суммы указанной на графике, а 25% больше. ',
        95=>'Зарплата 95 перцентиля — это значит, что 5% зарплат больше суммы указанной на графике, а 95% меньше. ',
    ]
];
