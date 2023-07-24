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
عرض التفاصيل
@endsection

@section('content')
<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center">  عرض بيانات الصنف</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @if (@isset($data) && !@empty($data))
            <table id="example2" class="table table-bordered table-hover">
                    <tr>
                        <td>
                            <label>باركود الصنف</label> <br>
                            {{ $data['barcode'] }}
                        </td>
                        <td>
                            <label>اسم الصنف</label> <br>
                            {{ $data['name'] }}
                        </td>
                        <td>
                            <label>نوع الصنف</label> <br>
                            @if ($data['item_type'] ==1)
                                    مخزنى
                                    @elseif ($data['item_type'] ==2)
                                    استهلاكى
                                    @elseif($data['item_type'] ==3)
                                    عهده
                                    @else
                                    غير محدد
                                    @endif
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label>فئة الصنف</label> <br>
                            {{ $data['inv_itemcard_categories_name'] }}
                        </td>
                        <td>
                            <label>الصنف الاب</label> <br>
                            {{ $data['parent_item_name'] }}
                        </td>
                        <td>
                            <label>وحدة قياس الاب </label> <br>
                            {{ $data['uom_name'] }}
                        </td>
                    </tr>
                    <tr>
                        <td @if ($data['does_has_retailunit'] ==0) colspan="3" @endif>
                            <label>هل للصنف وحدة تجزئة ابن؟</label> <br>
                            @if ($data['does_has_retailunit'] ==1)
                            نعم
                            @else
                            لا
                            @endif
                        </td>
                        @if ($data['does_has_retailunit'] ==1)
                            <td>
                                <label> وحدة القياس التجزئة</label> <br>
                                {{ $data['retail_uom_name'] }}
                            </td>
                            <td>
                                <label>عدد وحدات ({{ $data['retail_uom_name'] }}) بالنسبة ({{ $data['uom_name'] }})</label> <br>
                                {{ $data['retail_uom_quntToParent'] }}
                            </td>
                        @endif
                    </tr>
                    <tr>
                        <td>
                            <label>سعر القطاعى   ({{ $data['uom_name'] }})</label> <br>
                            {{ $data['price'] }}
                        </td>
                        <td>
                            <label>سعر نص جملة  ({{ $data['uom_name'] }})</label> <br>
                            {{ $data['nos_gomla_price'] }}
                        </td>
                        <td>
                            <label>سعر الجملة  ({{ $data['uom_name'] }})</label> <br>
                            {{ $data['gomla_price'] }}
                        </td>
                    </tr>
                    <tr>
                        <td @if ($data['does_has_retailunit'] ==0) colspan="3"  @endif>
                            <label>سعر تكفة الشراء بوحدة الاب   ({{ $data['uom_name'] }})</label> <br>
                            {{ $data['cost_price'] }}
                        </td>
                        @if ($data['does_has_retailunit'] ==1)
                        <td>
                            <label>سعر القطاعى   ({{ $data['retail_uom_name'] }})</label> <br>
                            {{ $data['price_retail'] }}
                        </td>
                        <td>
                            <label>سعر النص  جملة  ({{ $data['retail_uom_name'] }})</label> <br>
                            {{ $data['nos_gomla_price_retail'] }}
                        </td>
                        @endif
                    </tr>
                    @if ($data['does_has_retailunit'] ==1)
                    <tr>
                        <td colspan="3">
                            <label>سعر تكفة الشراء بوحدة    ({{ $data['retail_uom_name'] }})</label> <br>
                            {{ $data['cost_price_retail'] }}
                        </td>
                    </tr>
                    @endif

                    <tr>
                        <td>
                            <label> هل للصنف سعر ثابت</label> <br>
                            @if ($data['has_fixed_price'] ==1)
                            نعم
                            @else
                            لا
                            @endif
                        </td>
                        <td colspan="2">
                            <label>حالة التفعيل</label> <br>
                            @if ($data['active'] ==1)
                            مفعل
                            @else
                            معطل
                            @endif
                        </td>

                    </tr>

                    <tr>
                        <td class="width30">لوجو الصنف</td>
                        <td colspan="2">
                            <div class="image">
                                <img src="{{ asset( $data['photo'])  }}" alt="لوجو الشركة" class="custom_img">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>تاريخ اخر تحديث</td>
                        <td colspan="2">
                            @if ($data['updated_by'] > 0 and $data['updated_by'] != null)
                                @php
                                    $dt = new DateTime($data['updated_at']);
                                    $date = $dt->format('Y-m-d');
                                    $time = $dt->format('h:i');
                                    $newDateTime = date("A",strtotime($time));
                                    $newDateTimeType = (($newDateTime == 'AM')? 'صباحا' : 'مساءا')
                                @endphp
                                {{ $date }}
                                {{ $time }}
                                {{ $newDateTimeType }}
                                بواسطة
                                {{ $data['updated_by_admin'] }}
                            @else
                            لا يوجد تحديث
                            @endif
                            <a class="btn btn-small btn-success" href="{{ route('admin.itemCard.edit',$data['id']) }}">تعديل</a>
                        </td>
                    </tr>
              </table>
            @else
            <div class="alert alert-danger">
                هفوا لا توجد بيانات لعرضها
            </div>
            @endif

        </div>
      </div>
    </div>
</div>


@endsection
