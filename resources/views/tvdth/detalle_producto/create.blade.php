@extends('layouts.menu')

@section('content')
    <create-detail-products-dth></create-detail-products-dth>
@endsection
<script>
    window.userPermissions = @json(Auth::user()->getAllPermissions()->pluck('name'));
</script>