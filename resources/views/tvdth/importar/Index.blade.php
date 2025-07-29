@extends('layouts.menu')

@section('content')
    <index-importar-dth></index-importar-dth>
@endsection
<script>
    window.userPermissions = @json(Auth::user()->getAllPermissions()->pluck('name'));
</script>