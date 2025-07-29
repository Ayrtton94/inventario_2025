@extends('layouts.menu')

@section('content')
    <create-pendiente-producto-dth></create-pendiente-producto-dth>
@endsection
<script>
    window.userPermissions = @json(Auth::user()->getAllPermissions()->pluck('name'));
</script>