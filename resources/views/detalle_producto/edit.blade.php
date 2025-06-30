@extends('layouts.menu')

@section('content')
    <edit-detail-product :detailproduct-id="{{ $detailproductId }}"></edit-detail-product>
@endsection
