@extends('layouts.menu')

@section('content')
    <index-roles></index-roles>
@endsection
<script>
    window.userPermissions = @json(Auth::user()->getAllPermissions()->pluck('name'));
</script>