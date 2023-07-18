@extends('layouts\admin')

@section('title')
الضبط العام
@endsection

@section('contentheader')
فئات الاصناف
@endsection

@section('contentheaderlink')
<a href="{{ route('inv_itemcard_categories.index') }}">فئات الاصناف</a>
@endsection

@section('contentheaderactive')
تعديل
@endsection

@section('content')
<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center">تعديل بيانات فئة الاصناف </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form action="{{ route('inv_itemcard_categories.update',$data['id']) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="">اسم فئة الاصناف</label>
                <input type="text" class="form-control" name="name" value="{{ old('name', $data['name']) }}">
                @error('name')
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
                <a href="{{ route('inv_itemcard_categories.index') }}" class="btn btn-sm btn-danger" >الغاء</a>
            </div>
            </form>
        </div>
      </div>
    </div>
</div>


@endsection
