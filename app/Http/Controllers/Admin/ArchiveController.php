<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EventRequest;
use App\Models\Event;
use App\Services\Admin\AdminService;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    private $adminService,
        $prefix = 'archive';
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
            return $this->adminService->getList(['is_archive'=>1],['field'=>'date','order'=>'desc'],['customer','platform','user'],true);
        } else {
            return view('admin.templates.index', [
                'model'=>'App\Models\Event',
                'columns' => Event::$listFields,
                //'addLink' => route(sprintf('%s.create', $this->prefix)),
                'title' => 'Архивные мероприятия',
                //'addText'=>'Добавить мероприятие'
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
     * @param Event $archive
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Event $archive)
    {
        $detail = $this->adminService->getDetail($archive->id);
        $detail['item']->name = 'Редактирование мероприятия';
        return view('admin.templates.detail', [
            'method' => 'PATCH',
            'item' => $detail['item'],
            'tabs' => $detail['tabs'],
            'action' => route(sprintf('%s.update', $this->prefix), $archive),
            'delete' => route(sprintf('%s.destroy', $this->prefix), $archive->id),
            'back' => route(sprintf('%s.index', $this->prefix))
        ]);
    }

    /**
     * @param EventRequest $request
     * @param Event $archive
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(EventRequest $request, Event $archive)
    {
        $this->adminService->updateElement($archive->id, $request->validated());
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
}
