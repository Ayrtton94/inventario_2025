@extends('layouts.menu')

@section('content')
    <create-form-tecnico-dth :cliente-id="{{ $clienteId }}" :tecnico-id="{{ $tecnicoId }}"></create-form-tecnico-dth>
@endsection
<script>
    window.userPermissions = @json(Auth::user()->getAllPermissions()->pluck('name'));
</script>