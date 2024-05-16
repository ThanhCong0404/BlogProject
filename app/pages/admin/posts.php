<?php

namespace App\Controllers;

class PostsController
{
    public function index()
    {
        // Add your code here
    }

    public function add()
    {
        // Add your code here
    }

    public function edit($id)
    {
        // Add your code here
    }

    public function delete($id)
    {
        // Add your code here
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts</title>
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/style.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/summernote/summernote-lite.min.css">
</head>
<body>
    <div class="container">
        <?php if ($action == 'add' || $action == 'edit'): ?>
            <h1 class="my-4 text-center">
                <?= $action == 'add' ? 'Add New' : 'Edit' ?> Post
            </h1>
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">Please fix the errors below</div>
            <?php endif; ?>
            <form action="<?= $action == 'add' ? ROOT . '/admin/posts/add' : ROOT . '/admin/posts/edit/' . $row['id'] ?>" method="post" enctype="multipart/form-data" novalidate>
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" class="form-control <?= !empty($errors['title']) ? 'is-invalid' : '' ?>" value="<?= old_value('title', $row['title'] ?? '') ?>" required autofocus minlength="3" maxlength="255">
                    <?php if (!empty($errors['title'])): ?>
                        <div class="invalid-feedback"><?= $errors['title'] ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="image">Featured Image</label>
                    <div class="custom-file">
                        <input type="file" name="image" id="image" class="custom-file-input <?= !empty($errors['image']) ? 'is-invalid' : '' ?>" onchange="display_image_edit(this.files[0])" required>
                        <label for="image" class="custom-file-label">Choose file</label>
                        <?php if (!empty($errors['image'])): ?>
                            <div class="invalid-feedback"><?= $errors['image'] ?></div>
                        <?php endif; ?>
                    </div>
                    <img class="img-fluid mt-2 image-preview-edit" src="<?= get_image($row['image'] ?? '') ?>" alt="Featured Image">
                </div>
                <div class="form-group">
                    <label for="content">Content</label>
                    <textarea id="summernote" name="content" id="floatingInput" placeholder="Post content" class="form-control <?= !empty($errors['content']) ? 'is-invalid' : '' ?>" required><?= old_value('content', $row['content'] ?? '') ?></textarea>
                    <?php if (!empty($errors['content'])): ?>
                        <div class="invalid-feedback"><?= $errors['content'] ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="category_id">Category</label>
                    <select name="category_id" id="category_id" class="form-control <?= !empty($errors['category']) ? 'is-invalid' : '' ?>" required>
                        <option value="" <?= old_select('category_id', '', $row['category_id'] ?? '') ?
