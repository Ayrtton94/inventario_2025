@extends('layouts.menu')

@section('content')
 <index-detail-product></index-detail-product>
@endsection
<script>
    window.userPermissions = @json(Auth::user()->getAllPermissions()->pluck('name'));
</script>
