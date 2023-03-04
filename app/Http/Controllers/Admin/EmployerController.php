<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\User;
use App\Services\Admin\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployerController extends Controller
{
    private $adminService,
        $prefix = 'employers';

    public function __construct()
    {
        $this->adminService = new AdminService(new User(), '', $this->prefix);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        if ($request->input('getList') == 'Y') {
            return $this->adminService->getList(['is_admin' => 0]);
        } else {
            return view('admin.templates.index', [
                'model' => 'App\Models\User',
                'columns' => User::$listFields,
                'addLink' => route(sprintf('%s.create', $this->prefix)),
                'title' => 'Сотрудники',
                'addText' => 'Добавить сотрудника'
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
     * @param UserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request)
    {
        $arData = $request->validated();
        $arData['password'] = Hash::make($arData['password']);
        $this->adminService->addElement($arData);
        return redirect()->route(sprintf('%s.index', $this->prefix))->with('status', 'Элемент добавлен');
    }


    /**
     * @param User $employer
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(User $employer)
    {
        $detail = $this->adminService->getDetail($employer->id);
        return view('admin.templates.detail', [
            'method' => 'PATCH',
            'item' => $detail['item'],
            'tabs' => $detail['tabs'],
            'action' => route(sprintf('%s.update', $this->prefix), $employer),
            'delete' => route(sprintf('%s.destroy', $this->prefix), $employer->id),
            'back' => route(sprintf('%s.index', $this->prefix))
        ]);
    }

    /**
     * @param UserRequest $request
     * @param User $employer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, User $employer)
    {
        $arData = $request->validated();
        $arData['password'] = Hash::make($arData['password']);
        $this->adminService->updateElement($employer->id, $arData);
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
