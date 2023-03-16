<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\ApplicationRequest;
use App\Http\Requests\Admin\EventRequest;
use App\Models\Application;
use App\Models\Customer;
use App\Models\Event;
use App\Models\Platform;
use App\Models\User;
use App\Services\Admin\AdminService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{

    public $columns =  [
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
            'name' => 'На дату',
        ],
        [
            'data' => 'name_firm',
            'name' => 'Название фирмы',
        ],
        [
            'data' => 'type_client',
            'name' => 'Тип клиента ',
        ],
        [
            'data' => 'status',
            'name' => 'Статус заявки',
        ],
        [
            'data' => 'probability',
            'name' => 'Вероятность ',
        ],
        [
            'data' => 'from',
            'name' => 'От кого',
        ],
    ];

    private $admin = false;
    public function __construct()
    {
    }

    private function result($fullApplication)
    {

        $result = datatables()->of($fullApplication)->addColumn('check', function ($item) {
            return sprintf('<div class="center_column"><input type="checkbox" class="item-checker" name="items[]" value="%s" /></div>',$item->id);
        })->editColumn('date', function ($v){
            return date('d.m.Y', strtotime($v->date));
        })->editColumn('id', function ($v){
            return sprintf('<a href="/applications/%s/edit">%s</a>',  $v->id, $v->id);
        })->editColumn('user_id', function ($v){
            return (!empty($v->user_id)) ? $v->user->name : '';
        });

        return $result->rawColumns(['action','check', 'id'])->toJson();

    }



    public function archive(Request $request)
    {

        if(!Auth::user()->is_admin)  abort(403);
        $fullApplication = Application::query();
        $fullApplication->with(['user']);
        $fullApplication->where('archive', true);


        if ($request->input('getList') == 'Y') {
            $fullApplication = $fullApplication->get();
            return $this->result($fullApplication);
        }


        $columns =  $this->columns;

        if(Auth::user()->is_admin) {
            $columns[]  =   [
                'data' => 'user_id',
                'name' => 'Менеджер',
            ];
        }

        return view('admin.application.archive',
            [
                'columns' => $columns,
                'model'=>'App\Models\Application',
            ]);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $fullApplication = Application::query();
        $fullApplication->with(['user']);
        $fullApplication->where('archive', false);

        if(!Auth::user()->is_admin) $fullApplication->where('user_id', Auth::user()->id);


        if ($request->input('getList') == 'Y') {
            $fullApplication->where('active',  true);
            $fullApplication = $fullApplication->get();
            return $this->result($fullApplication);
        }


        if ($request->input('getList2') == 'Y') {
            $fullApplication->where('active',  false);
            $fullApplication = $fullApplication->get();
            return $this->result($fullApplication);
        }
        $columns =  $this->columns;

        if(Auth::user()->is_admin) {
            $columns[]  =   [
                'data' => 'user_id',
                'name' => 'Менеджер',
            ];
        }

        return view('admin.application.index',
            [
                'columns' => $columns,
                'model'=>'App\Models\Application',
            ]);
    }


    public function create()
    {
        if(!Auth::user()->is_admin)  abort(403);

        return view('admin.application.detail', [
            'users' => User::where('is_admin', false)->get(),
            'typeClients' => Application::$typeClientField,
            'statuses' => Application::$statusField,
            'probabilities' => Application::$probabilityField,
            'froms' => Application::$fromField,
            'yesNo' => Application::$yesNoField,
        ]);
    }

    /**
     * @param EventRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ApplicationRequest $request)
    {
        if(!Auth::user()->is_admin)  abort(403);

        $app = new Application();
        $app->fill($request->validated());
        $app->save();
        return redirect()->route('applications.index')->with('status', 'Заявка добавлена');

    }


    /**
     * @param Event $Event
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Application $application)
    {
        $defaultTemplate = 'admin.application.edit';
        if(!Auth::user()->is_admin) $defaultTemplate = 'admin.application.manager';
        return view($defaultTemplate, [
            'users' => User::where('is_admin', false)->get(),
            'application' => $application,
            'typeClients' => Application::$typeClientField,
            'statuses' => Application::$statusField,
            'probabilities' => Application::$probabilityField,
            'froms' => Application::$fromField,
            'yesNo' => Application::$yesNoField,
            'placement' =>  Platform::all(),
            'employers' =>  Customer::all(),
        ]);

    }


    public function update(ApplicationRequest $request, Application $application)
    {
        $application->fill($request->validated());
        $application->save();
        return redirect()->route('applications.edit', [
            'application' => $application->id
        ])->with('status', 'Заявка обновлена');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     */
    public function destroy(int $id)
    {

    }

    public function active(Request $request)
    {
        Application::whereIn('id', $request->get('ids'))->update([
            'active' => true
        ]);
    }

    public function deActive(Request $request)
    {

        if(!empty($request->get('ids')))
        {
            Application::whereIn('id', $request->get('ids'))->update([
                'active' => false
            ]);
        }
    }

    public function archiveAction(Request $request)
    {
        if(!Auth::user()->is_admin)  abort(403);
        Application::whereIn('id', $request->get('ids'))->update([
            'archive' => true
        ]);
    }

    public function agentAdd(Request $request)
    {
        $html = '  <select class="form-control m-select2" id="customer_id" name="customer_id"><option></option>';
        $customer = new  Customer();
        $customer->fill($request->all());
        $customer->save();

        $customers = Customer::all();
        foreach ($customers as $customer)
        {
            $html.= sprintf('<option value="%s">%s</option>',
                $customer->id, $customer->contact_person_name);
        }

        $html.='</select>';
        return $html;
    }


    public function eventAdd(Request $request)
    {

        $file = '';
        if(!empty($request->file('attachment_to_agreement')))
        {

            $path = sprintf('images/%s_%s', time(), $request->file('attachment_to_agreement')->getClientOriginalName());
            if (Storage::disk('public')->put($path, $request->file('attachment_to_agreement')->getContent())) {
                $file = Storage::url($path);
            }
        }

        $arr = $request->all();
        $arr['attachment_to_agreement'] = $file;

        $eventModel = new Event();
        $eventModel->fill($arr);
        $eventModel->save();

        if($eventModel->id >  0)
        {
            if(!empty($request->get('app')))
            {
                Application::where('id', $request->get('app'))->delete();
            }

        }

        return redirect()->route('events.index')->with('status', 'Мероприятие добавлено');


    }

    public function restore(Request $request)
    {
        if(!Auth::user()->is_admin)  abort(403);
        Application::whereIn('id', $request->get('ids'))->update([
            'archive' => false
        ]);
    }

   public function remove(Request $request)
    {
        if(!Auth::user()->is_admin)  abort(403);
        Application::whereIn('id', $request->get('ids'))->delete();
    }

    public function updateElement(Request $request)
    {

    }
}
