@extends('layouts.menu')

@section('content')
<import-excel></import-excel>
@endsection
<script>
    window.userPermissions = @json(Auth::user()->getAllPermissions()->pluck('name'));
</script>