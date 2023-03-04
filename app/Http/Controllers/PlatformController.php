<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\PlatformRequest;
use App\Models\Platform;
use App\Services\Admin\AdminService;
use Illuminate\Http\Request;

class PlatformController extends Controller
{
    private $adminService,
        $prefix = 'platforms';
    public function __construct()
    {
        $this->adminService = new AdminService(new Platform(),'',$this->prefix);
    }
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        if ($request->input('getList') == 'Y') {
            return $this->adminService->getList();
        } else {
            return view('admin.templates.index', [
                'model'=>'App\Models\Platform',
                'columns' => Platform::$listFields,
                'addLink' => route(sprintf('%s.create', $this->prefix)),
                'title' => 'Площадки',
                'addText'=>'Добавить площадку'
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
     * @param PlatformRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PlatformRequest $request)
    {
        $this->adminService->addElement($request->validated());
        return redirect()->route(sprintf('%s.index', $this->prefix))->with('status', 'Элемент добавлен');
    }


    /**
     * @param Platform $platform
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Platform $platform)
    {
        $detail = $this->adminService->getDetail($platform->id);
        return view('admin.templates.detail', [
            'method' => 'PATCH',
            'item' => $detail['item'],
            'tabs' => $detail['tabs'],
            'action' => route(sprintf('%s.update', $this->prefix), $platform),
            'delete' => route(sprintf('%s.destroy', $this->prefix), $platform->id),
            'back' => route(sprintf('%s.index', $this->prefix))
        ]);
    }

    /**
     * @param PlatformRequest $request
     * @param Platform $platform
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PlatformRequest $request, Platform $platform)
    {
        $this->adminService->updateElement($platform->id, $request->validated());
        return back()->with('status', 'Элемент изменен');
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
