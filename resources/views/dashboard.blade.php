@extends('layout')
@section('content')


    <div class="p-5 mb-4 bg-light rounded-3">
      <div class="container-fluid py-5">

       

        <h1 class="display-5 fw-bold">Hi, {{ auth()->user()->name }}</h1>
         <button class="btn btn-primary btn-lg" type="button">Dashboard</button>
      </div>
    </div>

  </div>
  @endsection