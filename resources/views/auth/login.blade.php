@extends('layouts.app')

@section('title', "Login - {{ env('APP_NAME') }}")

@section('content')
  <div class="d-flex justify-content-center align-items-center min-vh-100 bg-light">
    <div class="card m-3 shadow overflow-hidden d-flex flex-md-row flex-column w-100 rounded-4" style="max-width: 700px;">
      <div class="col-md-6 col-12 d-flex align-items-center">
        <img src="{{ asset('assets/img/login-banner.jpg') }}" alt="Login Image"
          class="w-100 img-fluid object-fit-cover rounded-top rounded-md-start" style="max-height: 512%">
      </div>
      <div class="col-md-6 col-12 p-4">
        <h3 class="text-center mb-3">Login</h3>
        <form action="{{ route('login') }}" method="POST">
          @csrf
          <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email"
              required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password"
              required>
          </div>
          <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
        <div class="text-center mt-3">
          <a href="{{ route('register') }}">Don't have an account? Register</a>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  </div>
@endsection
