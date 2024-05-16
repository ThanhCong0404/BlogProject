<?php
session_start();

function query($query, $data = [])
{
    // implementation of query function
}

function query_row($query, $data = [])
{
    // implementation of query_row function
}

function query_col($query, $data = [])
{
    // implementation of query_col function
}

function resize_image($source, $destination, $max_width = 800, $max_height = 600)
{
    // implementation of resize_image function
}

function display_errors($errors)
{
    if (!empty($errors)) {
        echo "<div style='color: red;'><ul>";
        foreach ($errors as $error) {
            echo "<li>" . htmlspecialchars($error) . "</li>";
        }
        echo "</ul></div>";
    }
}

$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? 0;

if ($action == 'add') {
    if (!empty($_POST)) {
        // validate
        $errors = [];

        $username = trim($_POST['username'] ?? '');
        if (empty($username)) {
            $errors['username'] = "A username is required";
        } else if (!preg_match("/^[a-zA-Z]+$/", $username)) {
            $errors['username'] = "Username can only have letters and no spaces";
        }

        $email = trim($_POST['email'] ?? '');
        if (empty($email)) {
            $errors['email'] = "An email is required";
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Email is not valid";
        } else {
            $query = "select id from users where email = :email && id != :id limit 1";
            $data = ['email' => $email, 'id' => $id];
            $existing_email = query_row($query, $data);

            if ($existing_email) {
                $errors['email'] = "That email is already in use";
            }
        }

        $password = trim($_POST['password'] ?? '');
        $retype_password = trim($_POST['retype_password'] ?? '');
        if (!empty($password)) {
            if (strlen($password) < 8) {
                $errors['password'] = "Password must be 8 characters or more";
            } else if ($password !== $retype_password) {
                $errors['password'] = "Passwords do not match";
            }
        }

        $image = $_FILES['image'] ?? [];
        $allowed = ['image/jpeg', 'image/png', 'image/webp'];
        $destination = '';
        if (!empty($image['name'])) {
            if (!in_array($image['type'], $allowed)) {
                $errors['image'] = "Image format not supported";
            } else {
                $folder = "uploads/";
                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                }

                $destination = $folder . time() . $image['name'];
                move_uploaded_file($image['tmp_name'], $destination);
                resize_image($destination);
            }
        }

        if (empty($errors)) {
            // save to database
            $data = [];
            $data['username'] = $username;
            $data['email'] = $email;
            $data['role'] = trim($_POST['role'] ?? '');

            if (!empty($password)) {
                $data['password'] = password_hash($password, PASSWORD_DEFAULT);
                $query = "insert into users (username, email, password, role" . ($destination ? ', image' : '') . ") values (:username, :email, :password, :role" . ($destination ? ', :image' : '') . ")";
            } else {
                $query = "insert into users (username, email, role" . ($destination ? ', image' : '') . ") values (:username, :email, :role" . ($destination ? ', :image' : '') . ")";
            }

            if (!empty($destination)) {
                $data['image'] = $destination;
            }

            query($query, $data);

            $_SESSION['success'] = 'User added successfully';
            exit(header('Location: admin/users'));
        }
    }
} else if ($action == 'edit') {
    $query = "select * from users where id = :id limit 1";
    $row = query_row($query, ['id' => $id]);

    if (!empty($_POST)) {
        if ($row) {
            // validate
            $errors = [];

            $username = trim($_POST['username'] ?? '');
            if (empty($username)) {
                $errors['username'] = "A username is required";
            } else if (!preg_match("/^[a-zA-Z]+$/", $username)) {
                $errors['username'] = "Username can only have letters and no spaces";
            }

            $email = trim($_POST['email'] ?? '');
            if (empty($email)) {
                $errors['email'] = "An email is required";
            } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Email is not valid";
            } else {
                $query = "select id from users where email = :email && id != :id limit 1";
                $data = ['email' => $email, 'id' => $id];
                $existing_email = query_row($query, $data);

                if ($existing_email) {
                    $errors['email'] = "That email is already in use";
                }
            }

            $password = trim($_POST['password'] ?? '');
            $retype_password = trim($_POST['retype_password'] ?? '');
            if (!empty($password)) {
                if (strlen($password) < 8) {
                    $errors['password'] = "Password must be 8 characters or more";
                } else if ($password !== $retype_password) {
                    $errors['password'] = "Passwords do not match";
                }
            }

            $image = $_FILES['image'] ?? [];
            $allowed = ['image/jpeg', 'image/png', 'image/webp'];
            $destination = '';
            if (!empty($image['name'])) {
                if (!in_array($image['type'], $allowed)) {
                    $errors['image'] = "Image format not supported";
                } else {
                    $folder = "uploads/";
                    if (!file_exists($folder)) {
                        mkdir($folder, 0777, true);
                    }

                    $destination = $folder . time() . $image['name'];
                    move_uploaded_file($image['tmp_name'], $destination);
                    resize_image($destination);
                }
            }

            if (empty($errors)) {
                // save to database
                $data = [];
                $data['username'] = $username;
                $data['email'] = $email;
                $data['role'] = trim($_POST['role'] ?? '');
                $data['id'] = $id;

                $password_str = "";
                $image_str = "";

                if (!empty($password)) {
                    $data['password'] = password_hash($password, PASSWORD_DEFAULT);
                    $password_str = "password = :password, ";
                }

                if (!empty($destination)) {
                    $image_str = "image = :image, ";
                    $data['image'] = $destination;
                }

                $query = "update users set username = :username, email = :email, $password_str $image_str role = :role where id = :id limit 1";

                query($query, $data);

                $_SESSION['success'] = 'User updated successfully';
                exit(header('Location: admin/users'));
            }
        }
    }
} else if ($action == 'delete') {
    $query = "select * from users where id = :id limit 1";
    $row = query_row($query, ['id' => $id]);

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if ($row) {
            // validate
            $errors = [];

            if (empty($errors)) {
                // delete from database
                $data = [];
                $data['id'] = $id;

                query("delete from users where id = :id limit 1", $data);

                if (file_exists($row['image'])) {
                    unlink($row['image']);
                }

                $_SESSION['success'] = 'User deleted successfully';
                exit(header('Location: admin/users'));
            }
        }
    }
}

// display errors
display_errors($errors ?? []);

// display form
// ...
?>
