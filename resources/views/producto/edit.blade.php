@extends('layouts.menu')

@section('content')
    <editar-product :producto-id="{{ $productoId }}"></editar-product>
@endsection
