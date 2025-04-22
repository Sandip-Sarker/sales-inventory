@extends('backend.master')

@section('content')

    @include('backend.component.customer.index')
    @include('backend.component.customer.create')
    @include('backend.component.customer.edit')
    @include('backend.component.customer.delete')


@endsection
