@extends('layouts.menu')

@section('content')
    <create-roles></create-roles>
@endsection
<script>
    window.userPermissions = @json(Auth::user()->getAllPermissions()->pluck('name'));
</script>