@extends('layouts\admin')

@section('title')
ضبط المخازن
@endsection

@section('contentheader')
الاصناف
@endsection

@section('contentheaderlink')
<a href="{{ route('admin.itemCard.index') }}">الاصناف </a>
@endsection

@section('contentheaderactive')
عرض
@endsection

@section('content')

      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center">بيانات  الاصناف </h3>
          <a href="{{ route('admin.itemCard.create') }}" class="btn btn-success btn-sm">اضافة صنف جديد</a>
          <input type="hidden" id="token_search" value="{{ csrf_token() }}">
          <input type="hidden" id="ajax_search_url" value="{{ route('admin.itemCard.ajax_search') }}">
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">

                <div class="col-md-4">
                    <input checked type="radio" name="searchByRadio" id="searchByRadio" value="barcode">بالباركود
                    <input type="radio" name="searchByRadio" id="searchByRadio" value="item_code">بالكود
                    <input type="radio" name="searchByRadio" id="searchByRadio" value="name">بالاسم

                    <input type="text" id="search_by_text" placeholder="اسم - باركود - كود للصنف " class="form-control">
                    <br>
                </div>
                <div class="col-md-4">

                    <div class="form-group">
                        <label for="">بحث بنوع الصنف</label>
                        <select name="item_type_search" id="item_type_search" class="form-control">
                            <option value="all" selected> بحث بالكل</option>
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
                        <label for="">بحث بفئة الصنف</label>
                        <select name="inv_itemcard_categories_id_search" id="inv_itemcard_categories_id_search" class="form-control">
                            <option value="all" selected>بحث بالكل</option>
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
                <div class="clearfix"></div>
                @if (@isset($data) && !@empty($data))
                <div id="ajax_response_searchDiv">
                    <table id="example2" class="table table-bordered table-hover">
                        <thead class="custom_thead">
                            <th>مسلسل</th>
                            <th>الاسم</th>
                            <th>النوع</th>
                            <th>الفئة</th>
                            <th>الصنف الاب</th>
                            <th>الوحدة الاب</th>
                            <th>الوحدة التجزئة</th>
                            <th>حالة التفعيل</th>
                        </thead>
                        <tbody>
                            @foreach ($data as $info)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $info->name }}</td>
                                    <td>
                                        @if ($info->item_type ==1)
                                        مخزنى
                                        @elseif ($info->item_type ==2)
                                        استهلاكى
                                        @elseif($info->item_type ==3)
                                        عهده
                                        @else
                                        غير محدد
                                        @endif
                                    </td>
                                    <td>{{ $info->inv_itemcard_categories_name }}</td>
                                    <td>{{ $info->parent_item_name }}</td>
                                    <td>{{ $info->uom_name }}</td>
                                    <td>{{ $info->retail_uom_name }}</td>
                                    <td>
                                        @if ($info->active ==1)
                                        مفعلة
                                        @else
                                        معطلة
                                        @endif
                                    </td>


                                    <td>
                                        <a href="{{ route('admin.itemCard.edit',$info->id) }}" class="btn btn-primary btn-sm">تعديل</a>
                                        <a onclick="return confirm('هل متأكد من حذف الصنف؟')" href="{{ route('admin.itemCard.delete',$info->id) }}"class="btn btn-danger btn-sm">حذف</a>
                                        <a href="{{ route('admin.itemCard.show',$info->id) }}" class="btn btn-info btn-sm">عرض</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <br>
                    <div class="col-md-12" id="ajax_pagination_in_search">

                        {{ $data->links() }}
                    </div>
                </div>
                @else
                <div class="alert alert-danger">
                    عفوا لا توجد بيانات لعرضها
                </div>
                @endif
            </div>

        </div>

</div>


@endsection

@section('scripts')
    <script src="{{ asset('assets/admin/js/inv_itemcard.js') }}"></script>
@endsection
