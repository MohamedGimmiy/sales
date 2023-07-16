@extends('layouts\admin')

@section('title')
اضافة مخزن جديد
@endsection

@section('contentheader')
المخازن
@endsection

@section('contentheaderlink')
<a href="{{ route('admin.stores.index') }}">المخازن</a>
@endsection

@section('contentheaderactive')
اضافة
@endsection

@section('content')
<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center">اضافة  مخزن جديد</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form action="{{ route('admin.stores.store') }}" method="POST">
            @method('POST')
            @csrf
            <div class="form-group">
                <label for="">اسم المخزن</label>
                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="">هاتف المخزن</label>
                <input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
                @error('phone')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="">عنوان المخزن</label>
                <input type="text" class="form-control" name="address" value="{{ old('address') }}">
                @error('address')
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
                <a href="{{ route('admin.stores.index') }}" class="btn btn-sm btn-danger" >الغاء</a>
            </div>
            </form>
        </div>
      </div>
    </div>
</div>


@endsection
