@extends('layouts.app')

@section('content')
    <submissions-component :user="{{Auth::user()}}"></submissions-component>

@endsection
