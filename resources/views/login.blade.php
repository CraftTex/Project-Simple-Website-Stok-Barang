@extends('layouts.noheader')

@section('container')
@if (session()->has('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {!! session('success') !!}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

@if (session()->has('error'))
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    {!! session('error') !!}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif
<div class="d-flex justify-content-center">
    <div class="card card-md p-3" style="width: 42%; height: 40%">
    <div class="card-body">
      <h2 class="h2 text-center mb-4">Login to your account</h2>
      <form action="/login" method="POST" autocomplete="off">
        @csrf
        <div class="my-3">
          <label class="form-label">Email address</label>
          <input type="email" class="form-control" placeholder="your@email.com" autocomplete="off" name="email" id="email">
        </div>
        
        <div class="my-2">
          <label class="form-label">
            Password
          </label>
          <div class="input-group input-group-flat">
            <input type="password" class="form-control"  placeholder="Your password"  autocomplete="off" name="password" id="password">
          </div>
        </div>
        <div class="form-footer">
          <button type="submit" class="btn btn-primary w-100">Sign in</button>
        </div>
      </form>
    </div>
    <div class="text-center text-muted mt-3">
        Don't have account yet? <a href="/register" tabindex="-1">Register</a>
    </div>
  </div>
</div>
@endsection