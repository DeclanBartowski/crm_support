<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\EventRequest;
use App\Models\Event;
use App\Services\Admin\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    private $adminService,
        $prefix = 'events';
    public function __construct()
    {
        $this->adminService = new AdminService(new Event(),'',$this->prefix);
    }
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        if ($request->input('getList') == 'Y') {
            $user = Auth::user();
            if($user->isAdmin()){
                return $this->adminService->getList(['is_archive'=>0],['field'=>'date','order'=>'desc'],['customer','platform','user'],true);
            }else{
                return $this->adminService->getList(['is_archive'=>0,'user_id'=>$user->id],['field'=>'date','order'=>'desc'],['customer','platform','user'],true);
            }

        } else {
            return view('admin.templates.index', [
                'model'=>'App\Models\Event',
                'columns' => Event::$listFields,
                'order'=>[[2,'desc']],
                'addLink' => route(sprintf('%s.create', $this->prefix)),
                'title' => 'Мероприятия',
                'addText'=>'Добавить мероприятие'
            ]);
        }
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $arTabs = $this->adminService->getCreate();
        return view('admin.templates.detail', [
            'tabs' => $arTabs,
            'action' => route(sprintf('%s.store', $this->prefix))
        ]);
    }

    /**
     * @param EventRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(EventRequest $request)
    {
        $this->adminService->addElement($request->validated());
        return redirect()->route(sprintf('%s.index', $this->prefix))->with('status', 'Элемент добавлен');
    }


    /**
     * @param Event $Event
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Event $Event)
    {
        $user = Auth::user();
        if($Event->is_archive == 1 && !$user->isAdmin()){
            abort('404');
        }
        $detail = $this->adminService->getDetail($Event->id);
        $detail['item']->name = 'Редактирование мероприятия';
        return view('admin.templates.detail', [
            'method' => 'PATCH',
            'item' => $detail['item'],
            'tabs' => $detail['tabs'],
            'action' => route(sprintf('%s.update', $this->prefix), $Event),
            'delete' => route(sprintf('%s.destroy', $this->prefix), $Event->id),
            'back' => route(sprintf('%s.index', $this->prefix))
        ]);
    }

    /**
     * @param EventRequest $request
     * @param Event $Event
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(EventRequest $request, Event $Event)
    {
        $user = Auth::user();
        if($Event->is_archive == 1 && !$user->isAdmin()){
            return redirect()->route(sprintf('%s.index', $this->prefix))->withErrors('Невозможно изменить мероприятие в архиве');
        }
        $this->adminService->updateElement($Event->id, $request->validated());
        return redirect()->route(sprintf('%s.index', $this->prefix))->with('status', 'Элемент изменен');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     */
    public function destroy(int $id)
    {
        $this->adminService->delete($id);
    }
    public function updateElement(Request $request){
        $event = Event::find($request->input('id'));
        if($event){
            $event->{$request->input('name')} = $request->input('value');
            $event->save();
        }
    }
}
