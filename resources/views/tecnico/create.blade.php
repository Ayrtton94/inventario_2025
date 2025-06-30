@extends('layouts.menu')

@section('content')
    <create-tecnico :cliente-id="{{ $clienteId }}" :tecnico-id="{{ $tecnicoId }}">></create-tecnico>
@endsection
<script>
    window.userPermissions = @json(Auth::user()->getAllPermissions()->pluck('name'));
</script>