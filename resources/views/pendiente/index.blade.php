@extends('layouts.menu')

@section('content')
    <index-pendiente></index-pendiente>
@endsection
<script>
    window.userPermissions = @json(Auth::user()->getAllPermissions()->pluck('name'));
</script>