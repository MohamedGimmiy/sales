@extends('layouts\admin')

@section('title')
تعديل وحدة
@endsection

@section('contentheader')
الوحدات
@endsection

@section('contentheaderlink')
<a href="{{ route('admin.stores.index') }}">الوحدات</a>
@endsection

@section('contentheaderactive')
تعديل
@endsection

@section('content')
<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center">تعديل بيانات وحدة قياس  </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form action="{{ route('admin.uoms.update',$data['id']) }}" method="POST">
            @method('POST')
            @csrf
            <div class="form-group">
                <label for="">اسم الوحدة</label>
                <input type="text" class="form-control" name="name" value="{{ old('name', $data['name']) }}">
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for=""> اختر النوع</label>
                <select name="is_master" id="is_master" class="form-control">
                    <option @if ($data['is_master'] == 1)
                        selected
                    @endif  value="1">وحدة اب</option>
                    <option @if ($data['is_master'] == 0)
                    selected
                @endif  value="0">وحدة تجزئة</option>
                </select>
                @error('is_master')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            </div>
            <div class="form-group">
                <label for="">حالة التفعيل</label>
                <select name="active" id="active" class="form-control">
                    <option @if ($data['active'] == 1)
                        selected
                    @endif  value="1">مفعلة</option>
                    <option @if ($data['active'] == 0)
                    selected
                @endif  value="0">معطلة</option>
                </select>
                @error('active')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            </div>
            <div class="form-group text-center">
                <button class="btn btn-sm btn-primary" type="submit">تعديل</button>
                <a href="{{ route('admin.uoms.index') }}" class="btn btn-sm btn-danger" >الغاء</a>
            </div>
            </form>
        </div>
      </div>
    </div>
</div>


@endsection
