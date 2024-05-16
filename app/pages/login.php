<?php
session_start();
require_once 'functions.php';

if (isset($_SESSION['user'])) {
  redirect('admin');
}

if (!empty($_POST)) {
  //validate
  $errors = [];

  // Check for valid CSRF token
  if (!validate_csrf('login')) {
    $errors[] = 'Invalid CSRF token';
  }

  $query = "SELECT * FROM users WHERE email = :email LIMIT 1";
  $row = query($query, ['email' => htmlspecialchars($_POST['email'])]);

  if ($row) {
    $data = [];
    $test = password_verify(htmlspecialchars($_POST['password']), $row[0]['password']);

    if ($test) {
      if (isset($_POST['remember'])) {
        // Set a persistent user session
        authenticate_persistent($row[0]);
      } else {
        // Set a regular user session
        authenticate($row[0]);
      }
      redirect('admin');
    } else {
      $errors['email'] = 'Wrong Email or Password';
    }
  } else {
    $errors['email'] = 'Wrong Email or Password';
  }
}

?>

<!doctype html>
<html lang="en">
<head>
  <!-- head content here -->
</head>
<body class="text-center">

<main class="form-signin w-100 m-auto">
  <form method="post">
    <!-- form content here -->
  </form>
</main>

<?php if (!empty($errors)): ?>
  <div class="alert alert-danger">
    <ul>
      <?php foreach ($errors as $error): ?>
        <li><?= htmlspecialchars($error) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

</body>
</html>
