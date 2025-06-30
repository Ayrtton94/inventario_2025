@extends('layouts.menu')

@section('content')
    <editar-pendiente :pendiente-id="{{ $pendienteId }}"></editar-pendiente>
@endsection
