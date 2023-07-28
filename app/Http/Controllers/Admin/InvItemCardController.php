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
    public function index()
    {
        $com_code = auth()->user()->com_code;
        $data = Inv_itemCard::select()->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
        $data = get_cols_where_p(new Inv_itemCard(), array('*'), array("com_code" => $com_code), 'id', 'DESC', PAGINATION_COUNT);
        if (!empty($data)) {

            foreach ($data as $info) {
                $info['added_by_admin'] = get_field_value(new Admin(), 'name', array('id' => $info['added_by']));
                $info['inv_itemcard_categories_name'] = get_field_value(new Inv_itemcardCategories(), 'name', array('id' => $info['inv_itemcard_categories_id']));
                $info['parent_item_name'] = get_field_value(new Inv_itemCard(), 'name', array('id' => $info['parent_inv_itemcard_id']));
                $info['uom_name'] = get_field_value(new Inv_uom(), 'name', array('id' => $info['uom_id']));
                $info['retail_uom_name'] = get_field_value(new Inv_uom(), 'name', array('id' => $info['retail_uom_id']));



                if ($info['updated_by'] > 0 and $info['updated_by'] != null) {
                    $info['updated_by_admin'] = get_field_value(new Admin(), 'name', array('id' => $info['updated_by']));
                }
            }
        }
        $inv_itemcard_categories = get_cols_where(
            new Inv_itemcardCategories(),
            array('id', 'name'),
            array('com_code' => $com_code, 'active' => 1),
            'id',
            'DESC'
        );
        return view('admin.inv_itemCard.index', compact('data', 'inv_itemcard_categories'));
    }

    public function create()
    {
        $com_code = auth()->user()->com_code;
        $inv_itemcard_categories = get_cols_where(
            new Inv_itemcardCategories(),
            array('id', 'name'),
            array('com_code' => $com_code, 'active' => 1),
            'id',
            'DESC'
        );

        $inv_uoms_parent = get_cols_where(
            new Inv_uom(),
            array('id', 'name'),
            array('com_code' => $com_code, 'active' => 1, 'is_master' => 1),
            'id',
            'DESC'
        );

        $inv_uoms_child = get_cols_where(
            new Inv_uom(),
            array('id', 'name'),
            array('com_code' => $com_code, 'active' => 1, 'is_master' => 0),
            'id',
            'DESC'
        );

        $item_card_data = get_cols_where(
            new Inv_itemCard(),
            array('id', 'name'),
            array('com_code' => $com_code, 'active' => 1),
            'id',
            'DESC'
        );

        return view(
            'admin.inv_itemCard.create',
            compact(
                'inv_itemcard_categories',
                'inv_uoms_parent',
                'inv_uoms_child',
                'item_card_data'
            )
        );
    }

    public function store(ItemcardRequest $request)
    {


        try {


            $com_code = auth()->user()->com_code;


            $row = get_cols_where_row_orderby(new Inv_itemCard(), array('item_code'), array('com_code' => $com_code), 'id', 'DESC');
            if (!empty($row)) {
                $data_insert['item_code'] = $row['item_code'] + 1;
            } else {
                $data_insert['item_code'] = 1;
            }


            // check if barcode exists
            if ($request->has('barcode') && $request->barcode != '') {
                $check_if_exists_barcode = Inv_itemCard::where(['barcode' => $request->barcode, 'com_code' => $com_code])->first();
                if (!empty($check_if_exists_barcode)) {
                    return back()->with(['error' => 'باركود الصنف موجود مسبقا'])->withInput();
                } else {
                    $data_insert['barcode'] = $request->barcode;
                }
            } else {
                $data_insert['barcode'] = 'item' . $data_insert['item_code'];
            }

            // check if name exists
            if ($request->has('name') && $request->name != '') {
                $check_if_exists_name = Inv_itemCard::where(['name' => $request->name, 'com_code' => auth()->user()->com_code])->first();
                if (!empty($check_if_exists_name)) {
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
            if ($request->does_has_retailunit == 1) {
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

            if ($request->has('item_image')) {
                $request->validate([
                    'item_image' => 'required|mimes:jpg,jepg|max:2000'
                ]);
                $the_file_path = uploadImage('assets/admin/uploads', $request->item_image);
                $data_insert['photo'] = $the_file_path;
            }
            $data_insert['added_by'] = auth()->id();
            $data_insert['created_at'] = date('Y-m-d H:i:s');
            $data_insert['com_code'] = $com_code;
            Inv_itemCard::create($data_insert);
            return redirect()->route('admin.itemCard.index')->with(['success' => 'تم تحديث البيانات بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->route('admin.itemCard.create')->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()]);
        }
    }

    public function edit($id)
    {
        $data = get_cols_where_row(new Inv_itemCard(), array('*'), array('id' => $id));
        $com_code = auth()->user()->com_code;
        $inv_itemcard_categories = get_cols_where(
            new Inv_itemcardCategories(),
            array('id', 'name'),
            array('com_code' => $com_code, 'active' => 1),
            'id',
            'DESC'
        );

        $inv_uoms_parent = get_cols_where(
            new Inv_uom(),
            array('id', 'name'),
            array('com_code' => $com_code, 'active' => 1, 'is_master' => 1),
            'id',
            'DESC'
        );

        $inv_uoms_child = get_cols_where(
            new Inv_uom(),
            array('id', 'name'),
            array('com_code' => $com_code, 'active' => 1, 'is_master' => 0),
            'id',
            'DESC'
        );

        $item_card_data = get_cols_where(
            new Inv_itemCard(),
            array('id', 'name'),
            array('com_code' => $com_code, 'active' => 1),
            'id',
            'DESC'
        );

        return view(
            'admin.inv_itemCard.edit',
            compact(
                'data',
                'inv_itemcard_categories',
                'inv_uoms_parent',
                'inv_uoms_child',
                'item_card_data'
            )
        );
    }


    function update($id, ItemcardRequest $request)
    {
        try {
            $com_code = auth()->user()->com_code;
            $data = get_cols_where_row(new Inv_itemCard(), array('*'), array('id' => $id));
            if (empty($data)) {
                return back()->with(['error' => 'عفوا غير قادر على الوصول للبيانات المطلوبة ']);
            }

            if ($request->has('barcode') && $request->barcode != '') {
                $check_if_exists_barcode = Inv_itemCard::where([
                    'barcode' => $request->barcode,
                    'com_code' => auth()->user()->com_code
                ])->where('id', '!=', $id)->first();

                if (!empty($check_if_exists_barcode)) {
                    return back()->with(['error' => 'باركود الصنف موجود مسبقا'])->withInput();
                }
            }

            // check if name exists
            if ($request->has('name') && $request->name != '') {
                $check_if_exists_name = Inv_itemCard::where(['name' => $request->name, 'com_code' => auth()->user()->com_code])->where('id', '!=', $id)->first();
                if (!empty($check_if_exists_name)) {
                    return back()->with(['error' => 'اسم الصنف موجود مسبقا'])->withInput();
                }
            }

            $dataToUpdate['barcode'] = $request->barcode;
            $dataToUpdate['name'] = $request->name;
            $dataToUpdate['item_type'] = $request->item_type;
            $dataToUpdate['inv_itemcard_categories_id'] = $request->inv_itemcard_categories_id;
            $dataToUpdate['uom_id'] = $request->uom_id;
            $dataToUpdate['does_has_retailunit'] = $request->does_has_retailunit;

            $dataToUpdate['price'] = $request->price;
            $dataToUpdate['nos_gomla_price'] = $request->nos_gomla_price;
            $dataToUpdate['gomla_price'] = $request->gomla_price;
            $dataToUpdate['cost_price'] = $request->cost_price;
            $dataToUpdate['parent_inv_itemcard_id'] = $request->parent_inv_itemcard_id;
            if ($request->does_has_retailunit == 1) {
                $dataToUpdate['retail_uom_quntToParent'] = $request->retail_uom_quntToParent;
                $dataToUpdate['price_retail'] = $request->price_retail;
                $dataToUpdate['nos_gomla_price_retail'] = $request->nos_gomla_price_retail;
                $dataToUpdate['gomla_price_retail'] = $request->gomla_price_retail;
                $dataToUpdate['cost_price_retail'] = $request->cost_price_retail;
                $dataToUpdate['retail_uom_id'] = $request->retail_uom_id;
            }
            $dataToUpdate['active'] = $request->active;
            $dataToUpdate['date'] = date('Y-m-d');
            $dataToUpdate['has_fixed_price'] = $request->has_fixed_price;

            if ($request->has('item_image')) {
                $request->validate([
                    'item_image' => 'required|mimes:jpg,jepg|max:2000'
                ]);
                $the_file_path = uploadImage('assets/admin/uploads', $request->item_image);
                unlink($data->photo);

                $dataToUpdate['photo'] = $the_file_path;
            } else {
                $dataToUpdate['photo'] = $data->photo;
            }
            $dataToUpdate['added_by'] = auth()->id();
            $dataToUpdate['created_at'] = date('Y-m-d H:i:s');
            $dataToUpdate['com_code'] = $com_code;

            update(new Inv_itemCard(), $dataToUpdate, array('id' => $id, 'com_code' => $com_code));
            return redirect()->route('admin.itemCard.index')->with(['success' => 'تم تعديل الصنف بنجاح']);
        } catch (\Exception $ex) {
            return back()->with(['error' => 'حدث خطأ ما ' . $ex->getMessage()])->withInput();
        }
    }

    public function delete($id)
    {
        Inv_itemCard::where(['id' => $id, 'com_code' => auth()->user()->com_code])->delete();
        return redirect()->route('admin.itemCard.index')->with(['success' => 'تم حذف الصنف بنجاح']);
    }


    public function show($id)
    {
        $data = get_cols_where_row(new Inv_itemCard(), array('*'), array('id' => $id));
        $com_code = auth()->user()->com_code;
        $data['added_by_admin'] = get_field_value(new Admin(), 'name', array('id' => $data['added_by']));
        $data['inv_itemcard_categories_name'] = get_field_value(new Inv_itemcardCategories(), 'name', array('id' => $data['inv_itemcard_categories_id']));
        $data['parent_item_name'] = get_field_value(new Inv_itemCard(), 'name', array('id' => $data['parent_inv_itemcard_id']));
        $data['uom_name'] = get_field_value(new Inv_uom(), 'name', array('id' => $data['uom_id']));
        if ($data['does_has_retailunit']) {
            $data['retail_uom_name'] = get_field_value(new Inv_uom(), 'name', array('id' => $data['retail_uom_id']));
        }



        if ($data['updated_by'] > 0 and $data['updated_by'] != null) {
            $data['updated_by_admin'] = get_field_value(new Admin(), 'name', array('id' => $data['updated_by']));
        }




        return view('admin.inv_itemCard.show', compact('data'));
    }

    public function ajax_search(Request $request)
    {
        if ($request->ajax()) {
            $search_by_text = $request->searchByText;
            $item_type = $request->item_type;
            $inv_itemcard_categories_id = $request->inv_itemcard_categories_id;
            $searchByRadio = $request->searchByRadio;

            $field3 = 'id';
            $operator3 = '>';
            $value3 = 0;
            if ($item_type == 'all') {
                $field1 = 'id';
                $operator1 = '>';
                $value = 0;
            } else {
                $field1 = 'item_type';
                $operator1 = '=';
                $value = $item_type;
            }

            if ($inv_itemcard_categories_id == 'all') {
                $field2 = 'id';
                $operator2 = '>';
                $value2 = 0;
            } else {
                $field2 = 'inv_itemcard_categories_id';
                $operator2 = '=';
                $value2 = $inv_itemcard_categories_id;
            }
            if ($search_by_text != null) {
                if ($searchByRadio == 'barcode') {
                    $field3 = 'barcode';
                    $operator3 = '=';
                    $value3 = $search_by_text;
                } else if ($searchByRadio == 'item_code') {
                    $field3 = 'item_code';
                    $operator3 = '=';
                    $value3 = $search_by_text;
                } else {
                    $field3 = 'name';
                    $operator3 = 'LIKE';
                    $value3 = "%{$search_by_text}%";
                }
            }
        }

        $data = Inv_itemCard::where($field1, $operator1, $value)
            ->where($field2, $operator2, $value2)
            ->where($field3, $operator3, $value3)
            ->orderBy('id', 'DESC')
            ->paginate(PAGINATION_COUNT);
        if (!empty($data)) {
            foreach ($data as $info) {
                $info['added_by_admin'] = get_field_value(new Admin(), 'name', array('id' => $info['added_by']));
                $info['inv_itemcard_categories_name'] = get_field_value(new Inv_itemcardCategories(), 'name', array('id' => $info['inv_itemcard_categories_id']));
                $info['parent_item_name'] = get_field_value(new Inv_itemCard(), 'name', array('id' => $info['parent_inv_itemcard_id']));
                $info['uom_name'] = get_field_value(new Inv_uom(), 'name', array('id' => $info['uom_id']));
                $info['retail_uom_name'] = get_field_value(new Inv_uom(), 'name', array('id' => $info['retail_uom_id']));



                if ($info['updated_by'] > 0 and $info['updated_by'] != null) {
                    $info['updated_by_admin'] = get_field_value(new Admin(), 'name', array('id' => $info['updated_by']));
                }
            }
        }
        return view('admin.inv_itemCard.ajax_search', compact('data'));
    }
}
