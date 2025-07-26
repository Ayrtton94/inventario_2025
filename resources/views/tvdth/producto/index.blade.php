@extends('layouts.menu')

@section('content')
    <index-products-dth></index-products-dth>
@endsection
<script>
    window.userPermissions = @json(Auth::user()->getAllPermissions()->pluck('name'));
</script>