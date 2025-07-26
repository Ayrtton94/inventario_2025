@extends('layouts.menu')

@section('content')
    <edit-products-dth :producto-id="{{ $productoId }}"></edit-products-dth>
@endsection
<script>
    window.userPermissions = @json(Auth::user()->getAllPermissions()->pluck('name'));
</script>