@extends('layouts.menu')

@section('content')
    <edit-roles :roles-id={{ $rolesId }}></edit-roles>
@endsection
<script>
    window.userPermissions = @json(Auth::user()->getAllPermissions()->pluck('name'));
</script>