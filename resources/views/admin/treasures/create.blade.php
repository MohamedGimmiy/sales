@extends('layouts\admin')

@section('title')
اضافة خزنة جديدة
@endsection

@section('contentheader')
الخزن
@endsection

@section('contentheaderlink')
<a href="{{ route('admin.treasures.index') }}">الخزن</a>
@endsection

@section('contentheaderactive')
اضافة
@endsection

@section('content')
<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center">اضافة خزنة جديدة</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form action="{{ route('admin.treasures.store') }}" method="POST" enctype="multipart/form-data">
            @method('POST')
            @csrf
            <div class="form-group">
                <label for="">اسم الخزنة</label>
                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="">هل رئيسية</label>
                <select name="is_master" id="" class="form-control">
                    <option value="" disabled selected>اختر النوع</option>
                    <option  value="1">رئيسية</option>
                    <option  value="0">فرعية</option>
                </select>
                @error('is_master')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            </div>
            <div class="form-group">
                <label for="">اخر رقم ايصال صرف نقدية لهذه الخزنة</label>
                <input type="number" id="last_isal_exchange" value="{{ old('last_isal_exchange') }}" class="form-control" name="last_isal_exchange">
                @error('last_isal_exchange')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            </div>
            <div class="form-group">
                <label for="">اخر رقم ايصال تحصيل نقدية لهذه الخزنة</label>
                <input type="number" id="last_isal_collect" value="{{ old('last_isal_collect') }}" class="form-control" name="last_isal_collect">
                @error('last_isal_collect')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            </div>
            <div class="form-group">
                <label for="">حالة التفعيل</label>
                <select name="active" id="active" class="form-control">
                    <option value="" disabled selected>اختر الحالة</option>
                    <option   value="1">مفعلة</option>
                    <option   value="0">معطلة</option>
                </select>
                @error('active')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            </div>
            <div class="form-group text-center">
                <button class="btn btn-sm btn-primary" type="submit">اضافة</button>
                <a href="{{ route('admin.treasures.index') }}" class="btn btn-sm btn-danger" >الغاء</a>
            </div>
            </form>
        </div>
      </div>
    </div>
</div>


@endsection
