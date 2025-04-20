@extends('backend.master')

@section('content')

    @include('backend.component.category.index')
    @include('backend.component.category.create')
    @include('backend.component.category.edit')
    @include('backend.component.category.delete')


@endsection
