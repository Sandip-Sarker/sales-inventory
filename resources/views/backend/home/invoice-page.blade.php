@extends('backend.master')

@section('content')

    @include('backend.component.invoice.index')
    @include('backend.component.invoice.delete')
    @include('backend.component.invoice.view')

@endsection
