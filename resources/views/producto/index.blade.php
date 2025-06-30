@extends('layouts.menu')

@section('content')
    <index-product></index-product>
@endsection
<script>
    window.userPermissions = @json(Auth::user()->getAllPermissions()->pluck('name'));
</script>