@extends('layouts\admin')

@section('title')
الضبط
@endsection

@section('contentheader')
الخزن
@endsection

@section('contentheaderlink')
<a href="{{ route('admin.treasures.index') }}">الخزن الفرعية للاستلام</a>
@endsection

@section('contentheaderactive')
اضافة
@endsection

@section('content')
<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center">اضافة خزن للاستلام منها للخزن ({{ $data['name'] }})</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form action="{{ route('admin.treasures.store_treasures_delivery',$data['id']) }}" method="POST" enctype="multipart/form-data">
            @method('POST')
            @csrf

            <div class="form-group">
                <label for="">اختر الخزنة الفرعية</label>
                <select name="treasures_can_delivery_id" id="treasures_can_delivery_id" class="form-control">
                    <option value="" disabled selected>اختر الخزنة</option>
                    @if (@isset($treasures) && !@empty($treasures))
                    @foreach ($treasures as $info)
                        <option value="{{ old('id',$info->id) }}">{{ $info->name }}</option>
                    @endforeach
                    @endif
                </select>
                @error('treasures_can_delivery_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            </div>
            <div class="form-group text-center">
                <button class="btn btn-sm btn-primary" type="submit">اضافة </button>
                <a href="{{ route('admin.treasures.index') }}" class="btn btn-sm btn-danger" >الغاء</a>
            </div>
            </form>
        </div>
      </div>
    </div>
</div>


@endsection
