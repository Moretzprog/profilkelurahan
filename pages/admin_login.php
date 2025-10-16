<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
  <title>Admin Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      height: 100vh;
      margin: 0;
      font-family: 'Inter', sans-serif;
    }

    .login-container {
      display: flex;
      height: 100vh;
      position: relative;
    }

    .left-panel {
      flex: 1;
      background-color: #d9d6f5;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 40px;
    }

    .left-panel h2 {
      font-size: 2rem;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .left-panel span {
      color: #FFFFFFFF;
    }

    .left-panel img {
      max-width: 100%;
      margin-top: 30px;
      border-radius: 15px;
    }

    .right-panel {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 40px;
    }

    .login-box {
      width: 100%;
      max-width: 400px;
    }

    .login-box h3 {
      font-weight: 600;
      margin-bottom: 10px;
    }

    .form-control {
      border-radius: 10px;
      padding: 10px 15px;
    }

    .btn-login {
      background-color: #40A7EDFF;
      border: none;
      border-radius: 10px;
      padding: 10px;
      font-size: 18px;
      color: white;
      transition: 0.3s;
    }

    .btn-login:hover {
      background-color: #d9d6f5;
    }

    .footer-text {
      margin-top: 20px;
      font-size: 13px;
      color: #999;
      text-align: center;
    }

    /* Back Button Style - Fixed */
    .arrow-back {
      position: absolute;
      top: 25px;
      left: 25px;
      z-index: 10;
    }

    .arrow-back a {
      text-decoration: none;
      color: #333;
      font-size: 16px;
      font-weight: 500;
      padding: 8px 15px;
      border-radius: 8px;
      background-color: rgba(255, 255, 255, 0.9);
      border: 1px solid #ddd;
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .arrow-back a:hover {
      background-color: #f8f9fa;
      transform: translateX(-3px);
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }

    /* Arrow icon style */
    .arrow-back a::before {
      content: "←";
      font-size: 18px;
      font-weight: bold;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
      .login-container {
        flex-direction: column;
      }

      .left-panel {
        display: none;
        /* sembunyikan ilustrasi di layar kecil */
      }

      .right-panel {
        flex: none;
        height: 100vh;
        padding: 20px;
      }

      .arrow-back {
        top: 15px;
        left: 15px;
      }

      .arrow-back a {
        font-size: 14px;
        padding: 6px 12px;
      }
    }
  </style>
</head>

<body>
  <div class="login-container">
    <div class="arrow-back">
      <a href="../index.php">Back</a>
    </div>

    <div class="left-panel text-center">
      <h2>Selamat Datang<br><span>Kelurahan Sarijaya</span></h2>
      <img src="../assets/images/bg-loginpage.jpg" alt="Illustration">
    </div>

    <div class="right-panel">
      <div class="login-box">
        <h3>Welcome to Admin</h3>
        <p class="text-muted">Please login to continue</p>
        <form action="../ceklogin.php" method="POST">
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
          </div>
          <div class="mb-4"> <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
          </div>
          <button type="submit" class="btn btn-login w-100">Login</button>
        </form>
        <p class="footer-text">© 2025 Support by Sarijaya</p>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>