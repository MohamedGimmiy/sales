@extends('layouts\admin')

@section('title')
    اضافة صنف
@endsection

@section('contentheader')
    الاصناف
@endsection

@section('contentheaderlink')
    <a href="{{ route('admin.itemCard.index') }}">الاصناف </a>
@endsection

@section('contentheaderactive')
    اضافة
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title card_title_center">اضافة صنف جديد</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form action="{{ route('admin.itemCard.store') }}" method="POST" enctype="multipart/form-data">
                @method('POST')
                <div class="row">
                    @csrf
                    <div class="col-md-4">

                        <div class="form-group">
                            <label for=""> باركود الصنف فى حالة عدم الادخال سيولد بشكل الى</label>
                            <input type="text" class="form-control" name="barcode" value="{{ old('barcode') }}">
                            @error('barcode')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">

                        <div class="form-group">
                            <label for=""> اسم الصنف</label>
                            <input type="text" id="name" class="form-control" name="name" value="{{ old('name') }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">

                        <div class="form-group">
                            <label for="">نوع الصنف</label>
                            <select name="item_type" id="item_type" class="form-control">
                                <option value="" disabled selected>اختر النوع</option>
                                <option value="1">مخزنى</option>
                                <option value="2">استهلاكى بتاريخ صلاحية</option>
                                <option value="3">عهده</option>
                            </select>
                            @error('active')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">فئة الصنف</label>
                            <select name="inv_itemcard_categories_id" id="inv_itemcard_categories_id" class="form-control">
                                <option value="" disabled selected>اختر الفئة</option>
                                @if (@isset($inv_itemcard_categories) && !@empty($inv_itemcard_categories))
                                    @foreach ($inv_itemcard_categories as $info)
                                        <option value="{{ old('inv_itemcard_categories_id', $info->id) }}">
                                            {{ $info->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('inv_itemcard_categories_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for=""> وحدة القياس الاب</label>
                            <select name="uom_id" id="uom_id" class="form-control">
                                <option value="" disabled selected>اختر الوحدة</option>
                                @if (@isset($inv_uoms_parent) && !@empty($inv_uoms_parent))
                                    @foreach ($inv_uoms_parent as $info)
                                        <option value="{{ old('uom_id', $info->id) }}">{{ $info->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('uom_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">

                        <div class="form-group">
                            <label for="">هل للصنف وحدة تجزئة ابن؟</label>
                            <select name="does_has_retailunit" id="does_has_retailunit" class="form-control">
                                <option value="" disabled selected>اختر الحالة</option>
                                <option value="1">نعم</option>
                                <option value="0">لا</option>
                            </select>
                            @error('does_has_retailunit')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4 " style="display: none;" id="retail_uom_idDiv">

                        <div class="form-group">
                            <label for="">وحدة قياس التجزئة الابن بالنسبة للاب (<span
                                    class="parentuomname"></span>)</label>
                            <select name="retail_uom_id" id="retail_uom_id" class="form-control">
                                <option value="" disabled selected>اختر الحالة</option>
                                @if (@isset($inv_uoms_child) && !@empty($inv_uoms_child))
                                    @foreach ($inv_uoms_child as $info)
                                        <option value="{{ old('retail_uom_id', $info->id) }}">{{ $info->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('retial_uom_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4 related_retail_counter" style="display: none;">

                        <div class="form-group">
                            <label for="">عدد وحدات التجزئة بالنسبة للاب (<span
                                    class="parentuomname"></span>)</label>
                            <input min="0" type="number" id="retail_uom_quntToParent"
                                value="{{ old('retail_uom_quntToParent') }}" class="form-control"
                                name="retail_uom_quntToParent">
                            @error('retail_uom_quntToParent')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4 related_parent_counter" style="display: none;">
                        <div class="form-group">
                            <label for="">السعر القطاعى بوحدة(<span
                                    class="parentuomname"></span>)</label>
                            <input min="0" type="number" id="price"
                                value="{{ old('price') }}" class="form-control"
                                name="price">
                            @error('price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4 related_parent_counter" style="display: none;">
                        <div class="form-group">
                            <label for="">السعر نص جملة بوحدة(<span
                                    class="parentuomname"></span>)</label>
                            <input min="0" type="number" id="nos_gomla_price"
                                value="{{ old('nos_gomla_price') }}" class="form-control"
                                name="nos_gomla_price">
                            @error('nos_gomla_price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4 related_parent_counter" style="display: none;">
                        <div class="form-group">
                            <label for="">سعر  الجملة بوحدة(<span
                                    class="parentuomname"></span>)</label>
                            <input min="0" type="number" id="gomla_price"
                                value="{{ old('gomla_price') }}" class="form-control"
                                name="gomla_price">
                            @error('gomla_price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4 related_parent_counter" style="display: none;">
                        <div class="form-group">
                            <label for="">سعر  تكلفة الشراء بوحدة(<span
                                    class="parentuomname"></span>)</label>
                            <input min="0" type="number" id="cost_price"
                                value="{{ old('cost_price') }}" class="form-control"
                                name="cost_price">
                            @error('cost_price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4 related_retail_counter" style="display: none;">
                        <div class="form-group">
                            <label for="">السعر القطاعى بوحدة(<span
                                    class="childuomname"></span>)</label>
                            <input min="0" type="number" id="price_retail"
                                value="{{ old('price_retail') }}" class="form-control"
                                name="price_retail">
                            @error('price_retail')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4 related_retail_counter" style="display: none;">
                        <div class="form-group">
                            <label for="">السعر النص جملة بوحدة(<span
                                    class="childuomname"></span>)</label>
                            <input min="0" type="number" id="nos_gomla_price_retail"
                                value="{{ old('nos_gomla_price_retail') }}" class="form-control"
                                name="nos_gomla_price_retail">
                            @error('nos_gomla_price_retail')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4 related_retail_counter" style="display: none;">
                        <div class="form-group">
                            <label for="">السعر  الجملة بوحدة(<span
                                    class="childuomname"></span>)</label>
                            <input min="0" type="number" id="gomla_price_retail"
                                value="{{ old('gomla_price_retail') }}" class="form-control"
                                name="gomla_price_retail">
                            @error('gomla_price_retail')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4 related_retail_counter" style="display: none;">
                        <div class="form-group">
                            <label for="">السعر  الشراء  بوحدة(<span
                                    class="childuomname"></span>)</label>
                            <input min="0" type="number" id="cost_price_retail"
                                value="{{ old('cost_price_retail') }}" class="form-control"
                                name="cost_price_retail">
                            @error('cost_price_retail')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">هل للصنف سعر ثابت؟ </label>
                            <select name="has_fixed_price" id="has_fixed_price" class="form-control">
                                <option value="" disabled selected>اختر الحالة</option>
                                <option value="1">نعم ثابت و لا يتغير بالفواتير</option>
                                <option value="0">لا و قابل للتغيير بالفواتير</option>
                            </select>
                            @error('has_fixed_price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">حالة التفعيل</label>
                            <select name="active" id="active" class="form-control">
                                <option value="" disabled selected>اختر الحالة</option>
                                <option value="1">مفعلة</option>
                                <option value="0">معطلة</option>
                            </select>
                            @error('active')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4" style="border: solid 5px #000; margin:10px;">

                        <div class="form-group">
                            <label for="">صورة الصنف ان وجدت</label>
                            <img src="#" id="uploaed_img" alt="uploaded_img" width="200px" height="200px">
                            <input onchange="readURL(this)" type="file" id="item_image" name="item_image"
                                class="form_controll">
                            @error('active')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">

                        <div class="form-group text-center">
                            <button id="do_add_item_card" class="btn btn-sm btn-primary" type="submit">اضافة</button>
                            <a href="{{ route('admin.stores.index') }}" class="btn btn-sm btn-danger">الغاء</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>



@endsection

<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#uploaed_img').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@section('scripts')
    <script src="{{ asset('assets/admin/js/inv_itemcard.js') }}"></script>
@endsection