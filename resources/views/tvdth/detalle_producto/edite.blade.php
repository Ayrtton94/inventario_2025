@extends('layouts.menu')

@section('content')
    <edit-detail-products-dth :detailproduct-id="{{ $detailproductId }}"></edit-detail-products-dth>
@endsection
<script>
    window.userPermissions = @json(Auth::user()->getAllPermissions()->pluck('name'));
</script>