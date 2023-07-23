<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ItemcardRequest;
use App\Models\Admin;
use App\Models\Inv_itemCard;
use App\Models\Inv_itemcardCategories;
use App\Models\Inv_uom;
use Illuminate\Http\Request;

class InvItemCardController extends Controller
{
    public function index(){
        $com_code = auth()->user()->com_code;
        $data = Inv_itemCard::select()->orderBy('id','DESC')->paginate(PAGINATION_COUNT);
        $data = get_cols_where_p(new Inv_itemCard(),array('*'),array("com_code"=>$com_code),'id','DESC',PAGINATION_COUNT);
        if(!empty($data)){

            foreach($data as $info){
                $info['added_by_admin'] = get_field_value(new Admin(),'name',array('id'=>$info['added_by']));
                $info['inv_itemcard_categories_name'] = get_field_value(new Inv_itemcardCategories(),'name',array('id'=>$info['inv_itemcard_categories_id']));
                $info['parent_item_name'] = get_field_value(new Inv_itemCard(),'name',array('id'=>$info['parent_inv_itemcard_id']));
                $info['uom_name'] = get_field_value(new Inv_uom(),'name',array('id'=>$info['uom_id']));
                $info['retail_uom_name'] = get_field_value(new Inv_uom(),'name',array('id'=>$info['retail_uom_id']));



                if($info['updated_by'] > 0 and $info['updated_by'] != null){
                    $info['updated_by_admin'] = get_field_value(new Admin(),'name',array('id'=>$info['updated_by']));
                }
                }
        }
        return view('admin.inv_itemCard.index',compact('data'));
    }

    public function create()
    {
        $com_code = auth()->user()->com_code;
        $inv_itemcard_categories = get_cols_where(new Inv_itemcardCategories(),array('id','name')
        ,array('com_code' => $com_code,'active'=>1),'id','DESC');

        $inv_uoms_parent = get_cols_where(new Inv_uom(),array('id','name')
        ,array('com_code' => $com_code,'active'=>1,'is_master' => 1),'id','DESC');

        $inv_uoms_child = get_cols_where(new Inv_uom(),array('id','name')
        ,array('com_code' => $com_code,'active'=>1,'is_master' => 0),'id','DESC');

        $item_card_data = get_cols_where(new Inv_itemCard(),array('id','name')
        ,array('com_code' => $com_code,'active'=>1),'id','DESC');

        return view('admin.inv_itemCard.create',
        compact('inv_itemcard_categories',
        'inv_uoms_parent',
        'inv_uoms_child',
        'item_card_data'));
    }

    public function store(ItemcardRequest $request){


        try{


        $com_code = auth()->user()->com_code;


        $row = get_cols_where_row_orderby(new Inv_itemCard(),array('item_code'),array('com_code'=>$com_code),'id','DESC');
        if(!empty($row)){
            $data_insert['item_code'] = $row['item_code'] + 1;
        } else {
            $data_insert['item_code'] = 1;
        }


        // check if barcode exists
        if($request->has('barcode') && $request->barcode != ''){
            $check_if_exists_barcode = Inv_itemCard::where(['barcode'=> $request->barcode,'com_code' =>$com_code])->first();
            if(!empty($check_if_exists_barcode)){
                return back()->with(['error' => 'باركود الصنف موجود مسبقا'])->withInput();
            } else {
                $data_insert['barcode'] = $request->barcode;
            }
        } else {
            $data_insert['barcode'] = 'item'. $data_insert['item_code'];

        }

        // check if name exists
        if($request->has('name') && $request->barcode != ''){
            $check_if_exists_name = Inv_itemCard::where(['name'=> $request->barcode,'com_code' =>auth()->user()->com_code])->first();
            if(!empty($check_if_exists_name)){
                return back()->with(['error' => 'اسم الصنف موجود مسبقا'])->withInput();
            }
        }

        $data_insert['name'] = $request->name;
        $data_insert['item_type'] = $request->item_type;
        $data_insert['inv_itemcard_categories_id'] = $request->inv_itemcard_categories_id;
        $data_insert['uom_id'] = $request->uom_id;
        $data_insert['does_has_retailunit'] = $request->does_has_retailunit;

        $data_insert['price'] = $request->price;
        $data_insert['nos_gomla_price'] = $request->nos_gomla_price;
        $data_insert['gomla_price'] = $request->gomla_price;
        $data_insert['cost_price'] = $request->cost_price;
        $data_insert['parent_inv_itemcard_id'] = $request->parent_inv_itemcard_id;
        if($request->does_has_retailunit == 1){
            $data_insert['retail_uom_quntToParent'] = $request->retail_uom_quntToParent;
            $data_insert['price_retail'] = $request->price_retail;
            $data_insert['nos_gomla_price_retail'] = $request->nos_gomla_price_retail;
            $data_insert['gomla_price_retail'] = $request->gomla_price_retail;
            $data_insert['cost_price_retail'] = $request->cost_price_retail;
            $data_insert['retail_uom_id'] = $request->retail_uom_id;

        }
        $data_insert['active'] = $request->active;
        $data_insert['date'] = date('Y-m-d');
        $data_insert['has_fixed_price'] = $request->has_fixed_price;

        if($request->has('item_image')){
            $request->validate([
                'item_image' => 'required|mimes:jpg,jepg|max:2000'
            ]);
            $the_file_path = uploadImage('assets/admin/uploads',$request->item_image);
            $data_insert['photo'] = $the_file_path;
        }
        $data_insert['added_by'] = auth()->id();
        $data_insert['created_at'] = date('Y-m-d H:i:s');
        $data_insert['com_code'] = $com_code;
        Inv_itemCard::create($data_insert);
        return redirect()->route('admin.itemCard.index')->with(['success' => 'تم تحديث البيانات بنجاح']);
    }
    catch(\Exception $ex){
        return redirect()->route('admin.itemCard.create')->with(['error' => 'عفوا حدث خطأ ما'. $ex->getMessage()]);

    }

    }
}
