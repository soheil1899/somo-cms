@extends('layouts.admin.master')


@section('content')

    <product-comment-component :productid = {{$id}}></product-comment-component>

@stop