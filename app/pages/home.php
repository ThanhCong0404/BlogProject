<?php
include '../app/pages/includes/header.php';

$query = "select posts.*,categories.category from posts join categories on posts.category_id = categories.id order by id desc limit 6";
$rows = query($query);

if ($rows === false) {
    echo "Error executing query";
} else {
    if (empty($rows)) {
        echo "No posts found!";
    } else {
        foreach ($rows as $row) {
            if (file_exists('../app/pages/includes/post-card.php')) {
                include '../app/pages/includes/post-card.php';
            } else {
                echo "post-card.php not found!";
            }
        }
    }
}
?>

<h3 class="mx-4">Featured</h3>

<div class="row my-2 justify-content-center">

</div>

<?php include '../app/pages/includes/footer.php'; ?>
