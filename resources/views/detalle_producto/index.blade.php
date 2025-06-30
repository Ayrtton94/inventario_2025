@extends('layouts.menu')

@section('content')
  <asignar-index></asignar-index>
@endsection
<script>
    window.userPermissions = @json(Auth::user()->getAllPermissions()->pluck('name'));
</script>
