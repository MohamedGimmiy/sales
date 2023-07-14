<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\treasuresRequest;
use App\Models\Admin;
use App\Models\treasures;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TreasuresController extends Controller
{
    public function index(){
        $data = treasures::select()->orderBy('id','DESC')->paginate(PAGINATION_COUNT);
        if(!empty($data)){

            foreach($data as $info){
                $info['added_by_admin'] = Admin::where('id', $info['added_by'])->value('name');

                if($info['updated_by'] > 0 and $info['updated_by'] != null){
                    $info['updated_by_admin'] = Admin::where('id', $info['updated_by'])->value('name');
                }
            }
        }
        return view('admin.treasures.index',compact('data'));
    }

    public function create(){
        return view('admin.treasures.create');
    }
    function store(treasuresRequest $request) {
        try {

            $request->validate([
                'name' => 'unique:treasures,name'
            ]);

            $check_if_master = treasures::where(['is_master'=> 1,'com_code' =>auth()->user()->com_code])->first();
            if($check_if_master != null){
                return redirect()->route('admin.treasures.create')->with(['error' => 'عفوا يوجد خزنة رئيسية ولا يمكن تسجيلها مرة اخرى']);

            }
            $data['name'] = $request->name;
            $data['is_master'] = $request->is_master;
            $data['last_isal_exchange'] = $request->last_isal_exchange;
            $data['last_isal_collect'] = $request->last_isal_collect;
            $data['active'] = $request->active;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['date'] = date('Y-m-d');
            $data['added_by'] = auth()->id();
            $data['com_code'] = auth()->user()->com_code;
            treasures::create($data);
            return redirect()->route('admin.treasures.index')->with(['success' => 'تم تسجيل الخزنة بنجاح']);


        } catch (\Exception $ex) {
            return back()->with(['error' => 'حدث خطأ ما '.$ex->getMessage()])->withInput();

        }
    }

    public function edit($id){
        $data = treasures::findOrFail($id);
        return view('admin.treasures.edit',compact('data'));
    }

    function update($id, treasuresRequest $request) {
        try {
            $com_code = auth()->user()->com_code;
            $data = treasures::findOrFail($id);
            if(empty($data)){
                return back()->with(['error' => 'عفوا غير قادر على الوصول للبيانات المطلوبة ']);
            }

            $request->validate([
                'name' => [Rule::unique('treasures')->ignore($id)]
            ],[
                'name.unique' => 'اسم الخزنة موجود بالفعل'
            ]);

            if($request->is_master == 1){
                $check_if_master = treasures::where(['is_master'=> 1,'com_code' =>auth()->user()->com_code])->where('id','!=',$id)->first();
                if($check_if_master != null){
                    return back()->with(['error' => 'الخزنة الرئيسية موجودة بالفعل '])->withInput();

                }
            }

            $dataToUpdate['name'] = $request->name;
            $dataToUpdate['active'] = $request->active;
            $dataToUpdate['is_master']  = $request->is_master;
            $dataToUpdate['last_isal_exchange'] = $request->last_isal_exchange;
            $dataToUpdate['last_isal_collect'] = $request->last_isal_collect;
            $dataToUpdate['updated_by'] = auth()->id();
            $dataToUpdate['updated_at']= date('Y-m-d H:i:s');
            treasures::where(['id' => $id,'com_code' => $com_code])->update($dataToUpdate);
            return redirect()->route('admin.treasures.index')->with(['success' => 'تم تعديل الخزنة بنجاح']);

        } catch (\Exception $ex) {
            return back()->with(['error' => 'حدث خطأ ما '.$ex->getMessage()])->withInput();
        }
    }
}
