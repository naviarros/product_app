<template>
    <div class="login-page">
      <div class="login-box">
        <div class="login-logo">
          <a href="#">AdminLTE</a>
        </div>
        <!-- /.login-logo -->

        <div class="card">
          <div class="card-body login-card-body">
            <p class="login-box-msg">Sign in to start your session</p>

            <form>
              <div class="input-group mb-3">
                <input type="email" class="form-control" placeholder="Email">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                  </div>
                </div>
              </div>
              <div class="input-group mb-3">
                <input type="password" class="form-control" placeholder="Password">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-8">
                  <div class="icheck-primary">
                    <input type="checkbox" id="remember">
                    <label for="remember">
                      Remember Me
                    </label>
                  </div>
                </div>
                <!-- /.col -->
                <div class="col-4">
                  <router-link to="/dashboard" class="btn btn-primary btn-block">Sign In</router-link>
                </div>
                <!-- /.col -->
              </div>
            </form>

            <p class="mb-1">
              <a href="#">Forgot password</a>
            </p>
            <p class="mb-0">
              <a href="#" class="text-center">Register a new membership</a>
            </p>
          </div>
          <!-- /.login-card-body -->
        </div>
      </div>
      <!-- /.login-box -->
    </div>
  </template>

  <script>
    export default {
    // Component logic here
  }
  </script>

  <style>
  /* Customize the styles as needed */
  </style>
