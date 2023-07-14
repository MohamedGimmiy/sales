@extends('layouts\admin')

@section('title')
الضبط العام

@endsection

@section('contentheader')
الخزن
@endsection

@section('contentheaderlink')
<a href="{{ route('admin.treasures.index') }}">الخزن</a>
@endsection

@section('contentheaderactive')
عرض
@endsection

@section('content')
<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center">بيانات الخزن </h3>
          <a href="{{ route('admin.treasures.create') }}" class="btn btn-success btn-sm">اضافة خزنة</a>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @if (@isset($data) && !@empty($data))
            <table id="example2" class="table table-bordered table-hover">
                <thead class="custom_thead">
                    <th>مسلسل</th>
                    <th>اسم الخزنة</th>
                    <th>هل رئيسية</th>
                    <th>اخر ايصال صرف</th>
                    <th>اخر ايصال تحصيل</th>
                    <th>حالة التفعيل</th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach ($data as $info)
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            <td>{{ $info->name }}</td>
                            <td>
                                @if ($info->is_master ==1)
                                    رئيسية
                                @else
                                    فرعية
                                @endif
                        </td>
                            <td>
                                {{ $info->last_isal_exchange }}
                            </td>
                            <td>
                                {{ $info->last_isal_collect }}
                            </td>
                            <td>
                                @if ($info->active ==1)
                                مفعلة
                                @else
                                معطلة
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-primary btn-sm">تعديل</button>
                                <button data-id="{{ $info->id }}" class="btn btn-info btn-sm">المزيد</button>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
            <br>
            {{ $data->links() }}
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
