@extends('layouts\admin')

@section('title')
تعديل الضبط العام

@endsection

@section('contentheader')
الضبط
@endsection

@section('contentheaderlink')
<a href="{{ route('admin.adminPanelsetting.index') }}">الضبط</a>
@endsection

@section('contentheaderactive')
تعديل
@endsection

@section('content')
<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center">تعديل بيانات الضبط العام</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @if (@isset($data) && !@empty($data))
            <form action="{{ route('admin.adminPanelsetting.update') }}" method="POST" enctype="multipart/form-data">
            @method('POST')
            @csrf
            <div class="form-group">
                <label for="اسم الشركة">اسم الشركة</label>
                <input type="text" name="system_name" id="system_name" class="form-control"  placeholder="ادخل اسم الشركة" value="{{ old('system_name',$data['system_name']) }}">
                @error('system_name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            </div>
            <div class="form-group">
                <label for="اسم الشركة">عنوان الشركة</label>
                <input type="text" name="address" id="address" class="form-control"  placeholder="ادخل عنوان الشركة" value="{{ old('address',$data['address']) }}">
                @error('address')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            </div>
            <div class="form-group">
                <label >هاتف الشركة</label>
                <input type="text" name="phone" id="phone" class="form-control"  placeholder="ادخل هاتف الشركة" value="{{ old('phone',$data['phone']) }}">
                @error('phone')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            </div>
            <div class="form-group">
                <label >رسالة تنبيه اعلى الشاشة</label>
                <input type="text" name="general_alert" id="general_alert" class="form-control" placeholder="رسالة تنبية اعلى الشاشة" value="{{ old('general_alert',$data['general_alert']) }}">
            </div>
            <div class="form-group" >
                <label >شعار الشركة</label>
                <div class="image">
                    <img src="{{ asset($data['photo']) }}" alt="لوجو الشركة" class="custom_img">
                    <button id="update_image" class="btn btn-sm btn-danger">تغيير الصورة</button>
                    <button id="cancel_update_image" style="display:none;" class="btn btn-sm btn-danger">الغاء</button>
                </div>
                <div id="old_image"></div>

            </div>
            <div class="form-group text-center">
                <button class="btn btn-sm btn-primary" type="submit">حفظ التعديلات</button>
            </div>




            </form>
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
