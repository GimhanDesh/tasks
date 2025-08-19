<?php
session_start();

if (isset($_SESSION["user"])) {
    header("Location: home.php");
    exit(); 
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>User Login - Medi_Lab</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-lg-5 col-md-7">
        <div class="card shadow-lg rounded-4 border-0">
          <div class="card-body p-4">
            <h3 class="card-title text-center mb-3 text-success fw-bold">Welcome Back</h3>
            <p class="text-center text-muted mb-4">Login to continue uploading prescriptions</p>

            <div>
              <!-- Email -->
              <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" placeholder="Enter your email" required>
              </div>

              <!-- Password -->
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Enter your password" required>
              </div>

              <!-- Remember Me + Forgot Password -->
              <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="remember">
                  <label class="form-check-label" for="remember">Remember me</label>
                </div>
                <a href="#" class="text-decoration-none text-success small">Forgot password?</a>
              </div>

              <!-- Submit Button -->
              <div class="d-grid mt-4">
                <button class="btn btn-success btn-lg" onclick="userLogin()">Login</button>
              </div>
            </div>

            <!-- Register Link -->
            <p class="text-center text-muted mt-4">
              Don’t have an account?
              <a href="index.php" class="text-success fw-semibold text-decoration-none">Register here</a>
            </p>

          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
   <script src="js/script.js"></script>
</body>

</html>