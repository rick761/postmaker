@extends('layouts.app')

@section('content')     
     <vue-app auth="{{Auth::user()}}"  csrf="{{ csrf_token() }}"  />
@endsection
