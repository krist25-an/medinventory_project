@extends('layouts.app')

@section('title', "Login - {{ env('APP_NAME') }}")

@section('content')
  <div class="d-flex justify-content-center align-items-center min-vh-100 bg-light">
    <div class="card m-3 shadow overflow-hidden d-flex flex-md-row flex-column w-100 rounded-4" style="max-width: 700px;">
      <div class="col-md-6 col-12 d-flex align-items-center">
        <img src="{{ asset('assets/img/login-banner.jpg') }}" alt="Login Image"
          class="w-100 h-100 img-fluid object-fit-cover rounded-top rounded-md-start">
      </div>
      <div class="col-md-6 col-12 p-4">
        <h3 class="text-center mb-3">Register</h3>
        <form action="{{ route('register') }}" method="POST">
          @csrf
          <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name"
              required>
          </div>
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
          <div class="mb-3 position-relative">
            <label for="confirm_password" class="form-label">Confirm Password</label>
            <div class="input-group">
              <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                placeholder="Enter your password" required>
            </div>
          </div>
          <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>
        <div class="text-center mt-3">
          <a href="{{ route('login') }}">Already have an account? Login</a>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  </div>
@endsection
