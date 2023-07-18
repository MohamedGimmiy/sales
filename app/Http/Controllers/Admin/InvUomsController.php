<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\invUomRequest;
use App\Models\Admin;
use App\Models\Inv_uom;
use Illuminate\Http\Request;

class InvUomsController extends Controller
{
    public function index(){
        $data = Inv_uom::select()->orderBy('id','DESC')->paginate(PAGINATION_COUNT);
        if(!empty($data)){

            foreach($data as $info){
                $info['added_by_admin'] = Admin::where('id', $info['added_by'])->value('name');

                if($info['updated_by'] > 0 and $info['updated_by'] != null){
                    $info['updated_by_admin'] = Admin::where('id', $info['updated_by'])->value('name');
                }
            }
        }
        return view('admin.inv_uoms.index',compact('data'));
    }

    public function create(){
        return view('admin.inv_uoms.create');
    }

    function store(invUomRequest $request) {
        try {

            $check_if_exists = Inv_uom::where(['name'=> $request->name,'com_code' =>auth()->user()->com_code])->first();
            if($check_if_exists != null){
                return redirect()->route('admin.uoms.index')->with(['error' => 'عفوا اسم الوحدة موجود مسبقا']);
            }
            $data['name'] = $request->name;
            $data['is_master'] = $request->is_master;
            $data['active'] = $request->active;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['date'] = date('Y-m-d');
            $data['added_by'] = auth()->id();
            $data['com_code'] = auth()->user()->com_code;
            Inv_uom::create($data);
            return redirect()->route('admin.uoms.index')->with(['success' => 'تم تسجيل الوحدة بنجاح']);


        } catch (\Exception $ex) {
            return back()->with(['error' => 'حدث خطأ ما '.$ex->getMessage()])->withInput();

        }
    }
    public function edit($id){
        $data = Inv_uom::findOrFail($id);
        return view('admin.inv_uoms.edit',compact('data'));
    }

    function update($id, invUomRequest $request) {
        try {
            $com_code = auth()->user()->com_code;
            $data = Inv_uom::findOrFail($id);
            if(empty($data)){
                return back()->with(['error' => 'عفوا غير قادر على الوصول للبيانات المطلوبة ']);
            }

            $check_if_exists = Inv_uom::where(['name'=> $request->name,
            'com_code' =>auth()->user()->com_code])->where('id' ,'!=',$id)->first();


            if($check_if_exists != null){
                return back()->with(['error' => 'اسم الوحدة موجود مسبقا'])->withInput();
            }
            $dataToUpdate['name'] = $request->name;
            $dataToUpdate['is_master'] = $request->is_master;
            $dataToUpdate['active'] = $request->active;
            $dataToUpdate['updated_by'] = auth()->id();
            $dataToUpdate['updated_at']= date('Y-m-d H:i:s');
            Inv_uom::where(['id' => $id,'com_code' => $com_code])->update($dataToUpdate);
            return redirect()->route('admin.uoms.index')->with(['success' => 'تم تعديل الوحدة بنجاح']);

        } catch (\Exception $ex) {
            return back()->with(['error' => 'حدث خطأ ما '.$ex->getMessage()])->withInput();
        }
    }

    public function delete($id){
        Inv_uom::findOrFail($id)->delete();
        return redirect()->route('admin.stores.index')->with('success','تم حذف المخزن بنجاح');
    }

    public function ajax_search(Request $request){
        if($request->ajax()){
            $search_by_text = $request->searchByText;
            $is_master_search = $request->is_master_search;

            if($is_master_search == 'all'){
                $field1 = 'id';
                $operator1 = '>';
                $value = 0;
            } else{
                $field1 = 'is_master';
                $operator1 = '=';
                $value = $is_master_search;
            } 

            $data = Inv_uom::where('name','LIKE',"%{$search_by_text}%")->where($field1,$operator1,$value)->orderBy('id','DESC')->paginate(PAGINATION_COUNT);
            if(!empty($data)){

                foreach($data as $info){
                    $info['added_by_admin'] = Admin::where('id', $info['added_by'])->value('name');

                    if($info['updated_by'] > 0 and $info['updated_by'] != null){
                        $info['updated_by_admin'] = Admin::where('id', $info['updated_by'])->value('name');
                    }
                }
            }
            return view('admin.inv_uoms.ajax_search',compact('data'));
        }
    }
}
