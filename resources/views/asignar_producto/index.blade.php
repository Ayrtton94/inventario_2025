@extends('layouts.menu')

@section('content')
  <index-ap></index-ap>
@endsection
<script>
    window.userPermissions = @json(Auth::user()->getAllPermissions()->pluck('name'));
</script>