@extends('layout-client')

@section('title', trans('main.HomeStatus'))

@section('content')
  <div class="container">
    <div class="my-container bg-white">
      <x-solution.solutions />
    </div>
  </div>
@endsection
