<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inv_itemcard_categoriesRequest;
use App\Models\Admin;
use App\Models\Inv_itemcardCategories;
use Illuminate\Http\Request;

class Inv_itemcard_categoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Inv_itemcardCategories::select()->orderBy('id','DESC')->paginate(PAGINATION_COUNT);
        if(!empty($data)){

            foreach($data as $info){
                $info['added_by_admin'] = Admin::where('id', $info['added_by'])->value('name');

                if($info['updated_by'] > 0 and $info['updated_by'] != null){
                    $info['updated_by_admin'] = Admin::where('id', $info['updated_by'])->value('name');
                }
            }
        }
        return view('admin.inv_itemcard_categories.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.inv_itemcard_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Inv_itemcard_categoriesRequest $request)
    {
        try {

            $check_if_exists = Inv_itemcardCategories::where(['name'=> $request->name,'com_code' =>auth()->user()->com_code])->first();
            if($check_if_exists != null){
                return redirect()->route('inv_itemcard_categories.create')->with(['error' => 'عفوا اسم الفئة موجود مسبقا']);
            }
            $data['name'] = $request->name;
            $data['active'] = $request->active;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['date'] = date('Y-m-d');
            $data['added_by'] = auth()->id();
            $data['com_code'] = auth()->user()->com_code;
            Inv_itemcardCategories::create($data);
            return redirect()->route('inv_itemcard_categories.index')->with(['success' => 'تم تسجيل الفئة بنجاح']);


        } catch (\Exception $ex) {
            return back()->with(['error' => 'حدث خطأ ما '.$ex->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $data = Inv_itemcardCategories::findOrFail($id);
        return view('admin.inv_itemcard_categories.edit',compact('data'));
    }


    function update($id, Inv_itemcard_categoriesRequest $request) {
        try {
            $com_code = auth()->user()->com_code;
            $data = Inv_itemcardCategories::findOrFail($id);
            if(empty($data)){
                return back()->with(['error' => 'عفوا غير قادر على الوصول للبيانات المطلوبة ']);
            }

            $check_if_exists = Inv_itemcardCategories::where(['name'=> $request->name,
            'com_code' =>auth()->user()->com_code])->where('id' ,'!=',$id)->first();


            if($check_if_exists != null){
                return back()->with(['error' => 'اسم الفئة موجود مسبقا'])->withInput();
            }
            $dataToUpdate['name'] = $request->name;
            $dataToUpdate['active'] = $request->active;
            $dataToUpdate['updated_by'] = auth()->id();
            $dataToUpdate['updated_at']= date('Y-m-d H:i:s');
            Inv_itemcardCategories::where(['id' => $id,'com_code' => $com_code])->update($dataToUpdate);
            return redirect()->route('admin.sales_materials_types.index')->with(['success' => 'تم تعديل الفئة بنجاح']);

        } catch (\Exception $ex) {
            return back()->with(['error' => 'حدث خطأ ما '.$ex->getMessage()])->withInput();
        }
    }

    public function delete($id){
        Inv_itemcardCategories::findOrFail($id)->delete();
        return redirect()->route('admin.sales_materials_types.index')->with('success','تم حذف الفئة بنجاح');
    }
}
