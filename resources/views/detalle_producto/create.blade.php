@extends('layouts.menu')

@section('content')
    <create-detail-product></create-detail-product>
@endsection
<script>
    window.userPermissions = @json(Auth::user()->getAllPermissions()->pluck('name'));
</script>