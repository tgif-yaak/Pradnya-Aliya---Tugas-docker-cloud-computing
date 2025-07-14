<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      background: linear-gradient(to bottom right, #ede9fe, #f5f3ff);
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .login-box {
      background: white;
      padding: 30px 40px;
      border-radius: 20px;
      box-shadow: 0 0 20px #d8b4feaa;
      width: 100%;
      max-width: 400px;
      text-align: center;
      color: #4c1d95;
    }

    h2 {
      margin-bottom: 20px;
      font-size: 28px;
      color: #9333ea;
      text-shadow: 0 0 5px #e9d5ff;
    }

    .alert-error {
      background-color: #fee2e2;
      color: #b91c1c;
      border: 1px solid #fca5a5;
      padding: 12px;
      border-radius: 10px;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }

    .alert-error i {
      font-size: 18px;
    }

    input[type="text"], input[type="password"] {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: 1px solid #d8b4fe;
      border-radius: 12px;
      font-size: 16px;
      background-color: #f9f5ff;
      box-shadow: inset 0 0 5px #e9d5ff;
    }

    button {
      background-color: #9333ea;
      color: white;
      border: none;
      padding: 12px 20px;
      border-radius: 12px;
      cursor: pointer;
      font-size: 16px;
      margin-top: 10px;
      transition: 0.3s;
      box-shadow: 0 0 8px #d8b4fe;
    }

    button:hover {
      background-color: #7e22ce;
      box-shadow: 0 0 12px #c084fc;
    }

    p {
      margin-top: 18px;
      font-size: 14px;
    }

    a {
      color: #7c3aed;
      text-decoration: none;
      font-weight: bold;
    }

    a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <div class="login-box">
    <h2>🔐 Login Dulu Yuk!</h2>

    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert-error">
        <i class="fas fa-exclamation-triangle"></i>
        <?= session()->getFlashdata('error') ?>
      </div>
    <?php endif; ?>

    <form method="post" action="<?= base_url('/proses-login') ?>">
      <input type="text" name="username" placeholder="Username" required><br>
      <input type="password" name="password" placeholder="Password" required><br>
      <button type="submit">Masuk</button>
      <p>Belum punya akun? <a href="<?= base_url('register') ?>">Daftar di sini</a></p>
    </form>
  </div>

</body>
</html>
