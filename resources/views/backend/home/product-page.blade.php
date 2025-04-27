@extends('backend.master')

@section('content')

    @include('backend.component.product.index')
    @include('backend.component.product.create')
    @include('backend.component.product.edit')
    @include('backend.component.product.delete')


@endsection
