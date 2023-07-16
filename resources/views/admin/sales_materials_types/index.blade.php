@extends('layouts\admin')

@section('title')
الضبط العام
@endsection

@section('contentheader')
فئات الفواتير
@endsection

@section('contentheaderlink')
<a href="{{ route('admin.sales_materials_types.index') }}">فئات الفواتير</a>
@endsection

@section('contentheaderactive')
عرض
@endsection

@section('content')
<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center">بيانات فئات الفواتير </h3>
          <a href="{{ route('admin.sales_materials_types.create') }}" class="btn btn-success btn-sm">اضافة فئة فواتير</a>
          <input type="hidden" id="token_search" value="{{ csrf_token() }}">
          <input type="hidden" id="ajax_search_url" value="{{ route('admin.treasures.ajax_search') }}">

        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @if (@isset($data) && !@empty($data))
            <div id="ajax_response_searchDiv">
                <table id="example2" class="table table-bordered table-hover">
                    <thead class="custom_thead">
                        <th>مسلسل</th>
                        <th>اسم الفئة</th>
                        <th>حالة التفعيل</th>
                        <th>تاريخ الاضافة</th>
                        <th>تاريخ التحديث</th>
                    </thead>
                    <tbody>
                        @foreach ($data as $info)
                            <tr>
                                <td>{{ $loop->index+1 }}</td>
                                <td>{{ $info->name }}</td>
                                <td>
                                    @if ($info->active ==1)
                                    مفعلة
                                    @else
                                    معطلة
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $dt = new DateTime($info['created_at']);
                                        $date = $dt->format('Y-m-d');
                                        $time = $dt->format('h:i');
                                        $newDateTime = date("A",strtotime($time));
                                        $newDateTimeType = (($newDateTime == 'AM')? 'صباحا' : 'مساءا')
                                    @endphp
                                    {{ $date }}
                                    {{ $time }}
                                    {{ $newDateTimeType }}
                                    بواسطة
                                    {{ $info['added_by_admin'] }}
                            </td>
                            <td>
                                @if ($info['updated_by'] > 0 and $info['updated_by'] != null)
                                    @php
                                        $dt = new DateTime($info['updated_at']);
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
                            </td>
                                <td>
                                    <a href="{{ route('admin.sales_materials_types.edit',$info->id) }}" class="btn btn-primary btn-sm">تعديل</a>
                                    <a onclick="return confirm('هل متأكد من حذف الفئة؟')" href="{{ route('admin.sales_materials_types.delete',$info->id) }}"class="btn btn-danger btn-sm">حذف</a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                <br>
                {{ $data->links() }}
            </div>
            @else
            <div class="alert alert-danger">
                عفوا لا توجد بيانات لعرضها
            </div>
            @endif

        </div>
      </div>
    </div>
</div>


@endsection

@section('scripts')
<script src="{{ asset('assets/admin/js/treasures.js') }}"></script>

@endsection
