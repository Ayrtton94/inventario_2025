@extends('layouts.menu')

@section('content')
    <edit-users :usuarios-id={{ $usuariosId }}></edit-users>
@endsection
