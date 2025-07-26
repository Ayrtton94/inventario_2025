@extends('layouts.menu')

@section('content')
    <asignar-dth-index></asignar-dth-index>
@endsection
<script>
    window.userPermissions = @json(Auth::user()->getAllPermissions()->pluck('name'));
</script>