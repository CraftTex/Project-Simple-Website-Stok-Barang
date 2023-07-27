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
    <div class="container container-tight">
      <form class="card card-md" action="/register" method="POST" autocomplete="off" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
          <h2 class="h2 text-center mb-4">Create new account</h2>
          <div class="mb-3">
            <label class="form-label" for="name">Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Enter name" id="name" name="name" value="{{ old('name') }}">
            @error('name')
            <div class="form-check-description" style="color: #d63939">
                {{ $message }}
            </div>
            @enderror
          </div>
          <div class="mb-3">
            <label class="form-label" for="username">Username</label>
            <input type="text" class="form-control @error('username') is-invalid @enderror" placeholder="Enter username" id="username" name="username" value="{{ old('username') }}">
            @error('username')
            <div class="form-check-description" style="color: #d63939">
                {{ $message }}
            </div>
            @enderror
          </div>
          {{-- <div class="mb-3">
            <div class="form-label">Choose Profile Picture</div>
            <input type="file" class="form-control" />
          </div> --}}
          <div class="mb-3">
            <label class="form-label" for="email">Email address</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter email" id="email" name="email" value="{{ old('email') }}">
            @error('email')
            <div class="form-check-description" style="color: #d63939">
                {{ $message }}
            </div>
            @enderror
          </div>
          <div class="mb-3">
            <label class="form-label" for="password">Password</label>
            <div class="input-group input-group-flat">
              <input type="password" class="form-control @error('password') is-invalid @enderror"  placeholder="Password"  autocomplete="off" id="password" name="password">
            </div>
            @error('password')
            <div class="form-check-description" style="color: #d63939">
                {{ $message }}
            </div>
            @enderror
          </div>
          
          <div class="form-footer">
            <button type="submit" class="btn btn-primary w-100">Create new account</button>
          </div>
        </div>
        <div class="text-center text-muted mb-3">
          Already have account? <a href="/login" tabindex="-1">Login</a>
        </div>
      </form> 
    </div>
  </div>
@endsection