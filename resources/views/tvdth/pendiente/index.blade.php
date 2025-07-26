@extends('layouts.menu')

@section('content')
    <index-pendiente-dth></index-pendiente-dth>
@endsection
<script>
    window.userPermissions = @json(Auth::user()->getAllPermissions()->pluck('name'));
</script>