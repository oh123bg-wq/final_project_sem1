<?php
session_start();

if (isset($_SESSION['user'])) {
  header("Location: login.php");
}

?>
<!DOCTYPE html>
<html>

<head>
  <title>Login Form</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
    crossorigin="anonymous" />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" />
  <style type="text/css">
    body {
      background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
      min-height: 100vh;
    }
  </style>
</head>

<body>

  <div class="container my-5 mx-auto" style="max-width: 500px;">
    <div class="text-center mb-4">
      <img src="../final_project_sem1/asset/masterballs-removebg-preview.png" alt="Pokémon TCG Tracker Logo" style="width: 70px; height: 70px; object-fit: cover;"/>
      <h1>Pokémon TCG Tracker</h1>
      <p>Manage your collection and track real-time values.</p>

    </div>
    <h1 class="mb-4 text-center"><i class="bi bi-shield-lock text-primary"></i>Login</h1>

    <div class="card p-4">
      <form method="POST" action="login.php">
        <div class="mb-2">
          <label for="username" class="form-label small fw-semibold text-secondary">Username</label>
          <input
            type="text"
            class="form-control"
            id="username"
            name="username"
            placeholder="Enter your username" />
        </div>
        <div class="mb-2">
          <label for="password" class="form-label small fw-semibold text-secondary">Password</label>
          <input
            type="password"
            class="form-control"
            id="password"
            name="password"
            placeholder="Enter your password" />
        </div>
        <div class="d-grid">
          <button type="submit" class="btn btn-primary">Login</button>
        </div>
      </form>
    </div>


    <div
      class="d-flex justify-content-between align-items-center gap-3 mx-auto pt-3">
      <a href="index.php" class="text-decoration-none small"><i class="bi bi-arrow-left-circle"></i> Go back</a>
      <a href="register-form.php" class="text-decoration-none small">Don't have an account? Sign up here
        <i class="bi bi-arrow-right-circle"></i></a>
    </div>
  </div>

  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
    crossorigin="anonymous"></script>
</body>

</html>