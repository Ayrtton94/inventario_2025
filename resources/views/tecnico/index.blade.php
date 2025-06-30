@extends('layouts.menu')

@section('content')
    <index-tecnico></index-tecnico>
@endsection
<script>
    window.userPermissions = @json(Auth::user()->getAllPermissions()->pluck('name'));
</script>