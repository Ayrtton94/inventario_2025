@extends('layouts.menu')

@section('content')
    <create-products-dth></create-products-dth>
@endsection
<script>
    window.userPermissions = @json(Auth::user()->getAllPermissions()->pluck('name'));
</script>