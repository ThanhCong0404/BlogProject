<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found - Your Website</title>
    <?php include '../app/pages/includes/head.php'; ?>
</head>
<body>
    <header>
        <?php include '../app/pages/includes/nav.php'; ?>
    </header>
    <main class="container">
        <section class="row justify-content-center">
            <div class="col-md-6 text-center">
                <div class="alert alert-danger mt-5">
                    <h1>Oops! The page you're looking for can't be found.</h1>
                    <p>It seems that the page you're trying to access doesn't exist or has been moved. Please check the URL or try searching for the content you're looking for.</p>
                    <a href="/" class="btn btn-primary">Go Back Home</a>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <?php include '../app/pages/includes/footer.php'; ?>
    </footer>
</body>
</html>
