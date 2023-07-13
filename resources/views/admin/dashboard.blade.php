@extends('layouts\admin')


@section('contentheader')
test heade1
@endsection

@section('contentheaderlink')
<a href="{{ route('admin.dashboard') }}">الرئيسية</a>
@endsection

@section('contentheaderactive')
عرض
@endsection

@section('content')
عرض
@endsection
