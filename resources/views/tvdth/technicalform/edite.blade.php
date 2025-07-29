@extends('layouts.menu')

@section('content')
    <edit-form-tecnico-dth :tecnico-id="{{ $tecnicoId }}"></edit-form-tecnico-dth>
@endsection
<script>
    window.userPermissions = @json(Auth::user()->getAllPermissions()->pluck('name'));
</script>