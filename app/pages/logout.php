<?php

// remove session user login
if (isset($_SESSION['USER'])) {
    unset($_SESSION['USER']);
    session_destroy();
}

// redirect to home page
if (!headers_sent()) {
    header('Location: /home');
    exit;
} else {
    echo '<script>window.location.href = "/home";</script>';
    exit;
}
