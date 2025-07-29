@extends('layouts.menu')

@section('content')
    <index-pendiente-producto-dth></index-pendiente-producto-dth>
@endsection
<script>
    window.userPermissions = @json(Auth::user()->getAllPermissions()->pluck('name'));
</script>