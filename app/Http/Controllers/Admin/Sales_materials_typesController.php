<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SalesMaterialTypesRequest;
use App\Models\Admin;
use App\Models\Sales_materials_types;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class Sales_materials_typesController extends Controller
{
    public function index(){
        $data = Sales_materials_types::select()->orderBy('id','DESC')->paginate(PAGINATION_COUNT);
        if(!empty($data)){

            foreach($data as $info){
                $info['added_by_admin'] = Admin::where('id', $info['added_by'])->value('name');

                if($info['updated_by'] > 0 and $info['updated_by'] != null){
                    $info['updated_by_admin'] = Admin::where('id', $info['updated_by'])->value('name');
                }
            }
        }
        return view('admin.sales_materials_types.index',compact('data'));
    }

    function create() {
        return view('admin.sales_materials_types.create');
    }
    function store(SalesMaterialTypesRequest $request) {
        try {

            $check_if_exists = Sales_materials_types::where(['name'=> $request->name,'com_code' =>auth()->user()->com_code])->first();
            if($check_if_exists != null){
                return redirect()->route('admin.sales_materials_types.index')->with(['error' => 'عفوا اسم الفئة موجود مسبقا']);
            }
            $data['name'] = $request->name;
            $data['active'] = $request->active;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['date'] = date('Y-m-d');
            $data['added_by'] = auth()->id();
            $data['com_code'] = auth()->user()->com_code;
            Sales_materials_types::create($data);
            return redirect()->route('admin.sales_materials_types.index')->with(['success' => 'تم تسجيل الفئة بنجاح']);


        } catch (\Exception $ex) {
            return back()->with(['error' => 'حدث خطأ ما '.$ex->getMessage()])->withInput();

        }
    }

    public function edit($id){
        $data = Sales_materials_types::findOrFail($id);
        return view('admin.sales_materials_types.edit',compact('data'));
    }


    function update($id, SalesMaterialTypesRequest $request) {
        try {
            $com_code = auth()->user()->com_code;
            $data = Sales_materials_types::findOrFail($id);
            if(empty($data)){
                return back()->with(['error' => 'عفوا غير قادر على الوصول للبيانات المطلوبة ']);
            }

            $check_if_exists = Sales_materials_types::where(['name'=> $request->name,
            'com_code' =>auth()->user()->com_code])->where('id' ,'!=',$id)->first();


            if($check_if_exists != null){
                return back()->with(['error' => 'اسم الفئة موجود مسبقا'])->withInput();
            }
            $dataToUpdate['name'] = $request->name;
            $dataToUpdate['active'] = $request->active;
            $dataToUpdate['updated_by'] = auth()->id();
            $dataToUpdate['updated_at']= date('Y-m-d H:i:s');
            Sales_materials_types::where(['id' => $id,'com_code' => $com_code])->update($dataToUpdate);
            return redirect()->route('admin.sales_materials_types.index')->with(['success' => 'تم تعديل الفئة بنجاح']);

        } catch (\Exception $ex) {
            return back()->with(['error' => 'حدث خطأ ما '.$ex->getMessage()])->withInput();
        }
    }

    public function delete($id){
        Sales_materials_types::findOrFail($id)->delete();
        return redirect()->route('admin.sales_materials_types.index')->with('success','تم حذف الفئة بنجاح');
    }
}
