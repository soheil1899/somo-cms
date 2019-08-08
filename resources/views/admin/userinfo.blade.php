@extends('layouts.admin.master')


@section('content')

    <userinfo-component :userid="{{$id}}"></userinfo-component>

@stop
