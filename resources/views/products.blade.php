@extends('layouts.main')

@section('title','produtos')

@section('content')

<h1>Pagina de produtos</h1>

@if($search != '')
    <p>{{$search}}</p>
@endif

@endsection