@extends('layouts.admin.master')


@section('content')

    <myinfo-component :userid="{{$userid}}"></myinfo-component>

@stop