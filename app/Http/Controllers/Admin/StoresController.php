<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoresRequest;
use App\Models\Admin;
use App\Models\Store;
use Illuminate\Http\Request;

class StoresController extends Controller
{
    public function index(){
        $data = Store::select()->orderBy('id','DESC')->paginate(PAGINATION_COUNT);
        if(!empty($data)){

            foreach($data as $info){
                $info['added_by_admin'] = Admin::where('id', $info['added_by'])->value('name');

                if($info['updated_by'] > 0 and $info['updated_by'] != null){
                    $info['updated_by_admin'] = Admin::where('id', $info['updated_by'])->value('name');
                }
            }
        }
        return view('admin.stores.index',compact('data'));
    }


    function create() {
        return view('admin.stores.create');
    }
    function store(StoresRequest $request) {
        try {

            $check_if_exists = Store::where(['name'=> $request->name,'com_code' =>auth()->user()->com_code])->first();
            if($check_if_exists != null){
                return redirect()->route('admin.sales_materials_types.index')->with(['error' => 'عفوا اسم المخزن موجود مسبقا']);
            }
            $data['name'] = $request->name;
            $data['phone'] = $request->phone;
            $data['address'] = $request->address;
            $data['active'] = $request->active;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['date'] = date('Y-m-d');
            $data['added_by'] = auth()->id();
            $data['com_code'] = auth()->user()->com_code;
            store::create($data);
            return redirect()->route('admin.stores.index')->with(['success' => 'تم تسجيل المخزن بنجاح']);


        } catch (\Exception $ex) {
            return back()->with(['error' => 'حدث خطأ ما '.$ex->getMessage()])->withInput();

        }
    }

    public function edit($id){
        $data = store::findOrFail($id);
        return view('admin.stores.edit',compact('data'));
    }


    function update($id, StoresRequest $request) {
        try {
            $com_code = auth()->user()->com_code;
            $data = store::findOrFail($id);
            if(empty($data)){
                return back()->with(['error' => 'عفوا غير قادر على الوصول للبيانات المطلوبة ']);
            }

            $check_if_exists = store::where(['name'=> $request->name,
            'com_code' =>auth()->user()->com_code])->where('id' ,'!=',$id)->first();


            if($check_if_exists != null){
                return back()->with(['error' => 'اسم الفئة موجود مسبقا'])->withInput();
            }
            $dataToUpdate['name'] = $request->name;
            $dataToUpdate['phone'] = $request->phone;
            $dataToUpdate['address'] = $request->address;
            $dataToUpdate['active'] = $request->active;
            $dataToUpdate['updated_by'] = auth()->id();
            $dataToUpdate['updated_at']= date('Y-m-d H:i:s');
            store::where(['id' => $id,'com_code' => $com_code])->update($dataToUpdate);
            return redirect()->route('admin.stores.index')->with(['success' => 'تم تعديل المخزن بنجاح']);

        } catch (\Exception $ex) {
            return back()->with(['error' => 'حدث خطأ ما '.$ex->getMessage()])->withInput();
        }
    }

    public function delete($id){
        store::findOrFail($id)->delete();
        return redirect()->route('admin.stores.index')->with('success','تم حذف المخزن بنجاح');
    }
}
