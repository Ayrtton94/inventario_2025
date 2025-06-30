@extends('layouts.menu')

@section('content')
    <editar-product :producto-id="{{ $productoId }}"></editar-product>
@endsection
<script>
    window.userPermissions = @json(Auth::user()->getAllPermissions()->pluck('name'));
</script>