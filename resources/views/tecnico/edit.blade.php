@extends('layouts.menu')

@section('content')
    <edit-tecnico :tecnico-id="{{ $tecnicoId }}"></edit-tecnico>
@endsection
<script>
    window.userPermissions = @json(Auth::user()->getAllPermissions()->pluck('name'));
</script>