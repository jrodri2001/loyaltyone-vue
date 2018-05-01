@extends('layouts.app')

@section('content')
    <submissions-component :user="{{Auth::user()}}" :gkey="'{!! config('app.google_geocode_key') !!}'"></submissions-component>

@endsection
