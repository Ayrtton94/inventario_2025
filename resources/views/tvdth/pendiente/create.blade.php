@extends('layouts.menu')

@section('content')
    <create-pendiente-dth></create-pendiente-dth>
@endsection
<script>
    window.userPermissions = @json(Auth::user()->getAllPermissions()->pluck('name'));
</script>