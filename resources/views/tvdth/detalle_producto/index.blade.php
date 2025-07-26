@extends('layouts.menu')

@section('content')
    <index-detail-products-dth></index-detail-products-dth>
@endsection
<script>
    window.userPermissions = @json(Auth::user()->getAllPermissions()->pluck('name'));
</script>