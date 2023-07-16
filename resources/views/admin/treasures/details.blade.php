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
عرض التفاصيل
@endsection

@section('content')
<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center">تفاصيل الخزنة</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @if (@isset($data) && !@empty($data))
            <table id="example2" class="table table-bordered table-hover">
                <tr>
                    <td class="width30">اسم الخزنة</td>
                    <td>{{ $data['name'] }}</td>
                </tr>
                <tr>
                    <td class="width30">اخر ايصال صرف</td>
                    <td>{{ $data['last_isal_exchange'] }}</td>
                </tr>
                <tr>
                    <td class="width30">اخر ايصال تحصيل</td>
                    <td>{{ $data['last_isal_collect'] }}</td>
                </tr>
=
                    <tr>
                        <td class="width30">حالة تفعيل الخزنة</td>
                        <td>
                            @if ($data['active']==1)
                            مفعل
                            @else
                            غير مفعل
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="width30">هل رئيسية</td>
                        <td>{{ ($data['is_master'] == 1)? 'رئيسية':'فرعية' }}</td>
                    </tr>

                    <tr>
                        <td class="width30">تاريخ الاضافة</td>
                        <td>
                                @php
                                    $dt = new DateTime($data['created_at']);
                                    $date = $dt->format('Y-m-d');
                                    $time = $dt->format('h:i');
                                    $newDateTime = date("A",strtotime($time));
                                    $newDateTimeType = (($newDateTime == 'AM')? 'صباحا' : 'مساءا')
                                @endphp
                                {{ $date }}
                                {{ $time }}
                                {{ $newDateTimeType }}
                                بواسطة
                                {{ $data['added_by_admin'] }}
                        </td>


                    </tr>
                    <tr>
                        <td class="width30">تاريخ اخر تحديث</td>
                        <td>
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
                            <a class="btn btn-small btn-success" href="{{ route('admin.treasures.edit',$data['id']) }}">تعديل</a>
                        </td>
                    </tr>
              </table>

              <!-- treasures delivery -->
              <div class="card-header">
                <h3 class="card-title card_title_center">الخزن الفرعية التى سوف تسلم عهدتها الى الخزنة ({{ $data['name'] }})

                    <a href="{{ route('admin.treasures.add_treasures_delivery', $data['id']) }}" class="btn btn-sm btn-primary">اضافة جديد</a>
                </h3>
            </div>
              @if (@isset($treasures_delivery) && !@empty($treasures_delivery))

              <table id="example2" class="table table-bordered table-hover">
                <thead class="custom_thead">
                    <th>مسلسل</th>
                    <th>اسم الخزنة</th>

                    <th>تاريخ الاصافة</th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach ($treasures_delivery as $info)
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            <td>{{ $info->name }}</td>
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
                                <a onclick="return confirm('هل متأكد من حذفها؟')" href="{{ route('admin.treasures.delete_treasures_delivery',$info->id) }}" class="btn btn-sm btn-danger">حذف</a>
                            </td>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        @endif

              <!-- end treasures delivery -->
            @else
            <div class="alert alert-danger">
                هفوا لا توجد بيانات لعرضها
            </div>
            @endif

        </div>
      </div>
    </div>


@endsection
