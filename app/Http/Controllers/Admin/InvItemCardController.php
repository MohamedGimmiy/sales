<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
                $info['retial_uom_name'] = get_field_value(new Inv_uom(),'name',array('id'=>$info['retial_uom_id']));



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

        return view('admin.inv_itemCard.create',compact('inv_itemcard_categories','inv_uoms_parent','inv_uoms_child'));
    }
}
