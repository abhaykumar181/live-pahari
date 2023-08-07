@extends('backend.app')
@section('title','Admin Dashboard')

@section('content')

<nav class="navbar bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand">Dashboard</a>
    <a href="{{route('admin.logout')}}">Logout</a>
  </div>
</nav>

@endsection
