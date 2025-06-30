@extends('layouts.menu')

@section('content')
   <create-product></create-product>
@endsection
<script>
    window.userPermissions = @json(Auth::user()->getAllPermissions()->pluck('name'));
</script>