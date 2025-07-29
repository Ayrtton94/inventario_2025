@extends('layouts.menu')

@section('content')
    <index-form-tecnico-dth></index-form-tecnico-dth>
@endsection
<script>
    window.userPermissions = @json(Auth::user()->getAllPermissions()->pluck('name'));
</script>