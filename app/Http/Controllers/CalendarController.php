<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\EventRequest;
use App\Models\Application;
use App\Models\Event;
use App\Services\Admin\AdminService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CalendarController extends Controller
{

    public $columns = [

        [
            'data' => 'date',
            'name' => 'На дату',
        ],
        [
            'data' => 'name_firm',
            'name' => 'название компании',
        ],
        [
            'data' => 'probability',
            'name' => 'вероятность',
        ],
        [
            'data' => 'sport_name',
            'name' => 'спортивная часть',
        ],
        [
            'data' => 'manager',
            'name' => 'менеджер',
        ],


    ];

    private function result($fullApplication)
    {

        $result = datatables()->of($fullApplication)->editColumn('date', function ($v) {
            return sprintf('<a href="%s">%s</a>', $v['url'], (empty($v['date'])) ? '' : date('d.m.Y', strtotime($v['date'])));
        });

        return $result->rawColumns(['date'])->toJson();

    }

    public function index(Request $request)
    {

        $events = [];
        $applications = Application::with(['user'])->where('archive', false)->get();
        $eventsModel = Event::with(['customer', 'user'])->where('is_archive', false)->get();

        if ($request->input('getList') == 'Y') {

            $result = [];


            foreach ($applications as $application) {
                $result[] = [
                    'url' => route('applications.edit', ['application' => $application->id]),
                    'date' => $application->date,
                    'name_firm' => $application->name_firm,
                    'probability' => $application->probability,
                    'status' => $application->status,
                    'sport_name' => '',
                    'manager' => (!empty($application->user_id))? $application->user->name : '',
                ];
            }


            foreach ($eventsModel as $event) {
                $result[] = [
                    'url' => route('events.edit', ['event' => $event->id]),
                    'date' => $event->date,
                    'name_firm' => (!empty($event->customer))? $event->customer->name : '',
                    'probability' => '',
                    'sport_name' => $event->sport,
                    'manager' => (!empty($event->user_id))? $event->user->name : '',
                ];
            }

            return $this->result($result);
        }


        foreach ($applications as $application) {

            $events[] = [
                'title' => $application->name_firm,
                'start' => date('Y-m-d', strtotime($application->date)),
                'color' => '#fcf003',
            ];
        }


        foreach ($eventsModel as $event) {
            $events[] = [
                'title' => (!empty($event->customer))? $event->customer->name : '',
                'start' => date('Y-m-d', strtotime($event->date)),
                'color' => ($event->is_payed) ? '#23c70a' : '#e48a30',
            ];
        }


        return view('admin.calendar.index',
            [
                'events' => $events,
                'columns' => $this->columns
            ]);
    }


}
