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
  <title>User Registration - Medi_Lab</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-lg-6 col-md-8">
        <div class="card shadow-lg rounded-4 border-0">
          <div class="card-body p-4">
            <h3 class="card-title text-center mb-3 text-success fw-bold">Create Account</h3>
            <p class="text-center text-muted mb-4">Register to upload your medical prescriptions</p>

            <div>
              <!-- Name -->
              <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="name" placeholder="Enter your full name" required>
              </div>

              <!-- Email -->
              <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" placeholder="Enter your email" required>
              </div>

              <!-- password -->
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Enter your password" required>
              </div>

              <!-- Address -->
              <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control" id="address" rows="2" placeholder="Enter your address" required></textarea>
              </div>

              <!-- Contact & DOB in row -->
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="contact" class="form-label">Contact Number</label>
                  <input type="tel" class="form-control" id="contact" placeholder="e.g.  077 123 4567" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="dob" class="form-label">Date of Birth</label>
                  <input type="date" class="form-control" id="dob" required>
                </div>
              </div>

              <!-- Submit Button -->
              <div class="d-grid mt-4">
                <button class="btn btn-success btn-lg" onclick="userRegister()">Register</button>
              </div>
            </div>
            <!-- Register Link -->
            <p class="text-center text-muted mt-4">
              Already have an account?
              <a href="login.php" class="text-success fw-semibold text-decoration-none">Login here</a>
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