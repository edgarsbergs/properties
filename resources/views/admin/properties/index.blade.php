@extends('layouts.default')

@section('meta_title')
    Properties
@endsection

@section('content')
    @include('admin.includes.search')
    @if(count($properties) > 0)

        <ul class="list-group mt-20">
            @foreach($properties as $property)
                <li class="list-group-item">
                    @include('admin.includes.item', ['item' => $property])
                </li>
            @endforeach
        </ul>

        <div class="mt-20">
            {{ $properties->links('vendor/pagination/bootstrap-4') }}
        </div>
    @endif
@endsection
