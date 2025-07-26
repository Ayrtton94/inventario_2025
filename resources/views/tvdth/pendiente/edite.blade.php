@extends('layouts.menu')

@section('content')
    <edite-pendiente-dth :pendiente-id="{{ $pendienteId }}"></edite-pendiente-dth>
@endsection
<script>
    window.userPermissions = @json(Auth::user()->getAllPermissions()->pluck('name'));
</script>