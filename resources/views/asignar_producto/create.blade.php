@extends('layouts.menu')

@section('content')
    <asignar-producto></asignar-producto>
@endsection
<script>
    window.userPermissions = @json(Auth::user()->getAllPermissions()->pluck('name'));
</script>