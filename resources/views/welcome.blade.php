@extends('layouts.default')

@section('meta_title')
    Home
@endsection

@section('content')
    <a class="btn btn-light" href="{{ route('admin.properties') }}">Admin  - properties</a>
@endsection
