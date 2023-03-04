<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CustomerRequest;
use App\Models\Customer;
use App\Services\Admin\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    private $adminService,
        $prefix = 'customers';
    public function __construct()
    {
        $this->adminService = new AdminService(new Customer(),'',$this->prefix);
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
                return $this->adminService->getList();
            }else{
                return $this->adminService->getList(['user_id'=>$user->id]);
            }

        } else {
            return view('admin.templates.index', [
                'model'=>'App\Models\Customer',
                'columns' => Customer::$listFields,
                'addLink' => route(sprintf('%s.create', $this->prefix)),
                'title' => 'Заказчики',
                'addText'=>'Добавить заказчика'
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
     * @param CustomerRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CustomerRequest $request)
    {
        $this->adminService->addElement($request->validated());
        return redirect()->route(sprintf('%s.index', $this->prefix))->with('status', 'Элемент добавлен');
    }


    /**
     * @param Customer $customer
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Customer $customer)
    {
        $detail = $this->adminService->getDetail($customer->id);
        return view('admin.templates.detail', [
            'method' => 'PATCH',
            'item' => $detail['item'],
            'tabs' => $detail['tabs'],
            'action' => route(sprintf('%s.update', $this->prefix), $customer),
            'delete' => route(sprintf('%s.destroy', $this->prefix), $customer->id),
            'back' => route(sprintf('%s.index', $this->prefix))
        ]);
    }

    /**
     * @param CustomerRequest $request
     * @param Customer $customer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CustomerRequest $request, Customer $customer)
    {
        $this->adminService->updateElement($customer->id, $request->validated());
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
