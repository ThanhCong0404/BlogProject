<?php
// Define the root URL
define('ROOT', '/path/to/root');

// Define the old value function
function old_value($name, $default = '')
{
    return isset($_POST[$name]) ? htmlspecialchars(trim($_POST[$name])) : $default;
}

// Define the old select function
function old_select($name, $default, $selected)
{
    return $selected == $default ? ' selected' : '';
}

// Define the PAGE constant
$PAGE = [
    'page_number' => isset($_GET['page']) ? (int)$_GET['page'] : 1,
    'first_link' => ROOT . '/admin/categories?page=1',
    'prev_link' => max(1, $PAGE['page_number'] - 1),
    'next_link' => min(ceil(countAll('categories') / 10), $PAGE['page_number'] + 1),
];

// Define the query function
function query($query)
{
    // Execute the query and return the result
}

// Define the countAll function
function countAll($table)
{
    // Count the number of rows in the table and return it
}

// Define the escape function
function esc($value)
{
    // Escape the value and return it
}

// Define the action variable
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Switch statement to handle different actions
switch ($action) {
    case 'add':
        // Add category form
        ?>
        <div class="col-md-6 mx-auto">
            <form method="post" action="<?= ROOT ?>/admin/categories/add" enctype="multipart/form-data" autocomplete="off">
                <h1 class="h3 mb-3 fw-normal">Create category</h1>

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">Please fix the errors below</div>
                <?php endif; ?>

                <div class="form-floating">
                    <input value="<?= old_value('category') ?>" name="category" type="text" class="form-control mb-2" id="category" placeholder="Category" required>
                    <label for="category">Category</label>
                </div>
                <?php if (!empty($errors['category'])): ?>
                    <div class="text-danger"><?= $errors['category'] ?></div>
                <?php endif; ?>

                <div class="form-floating my-3">
                    <select name="disabled" class="form-select" id="disabled" required>
                        <option value="0">Yes</option>
                        <option value="1">No</option>
                    </select>
                    <label for="disabled">Active</label>
                </div>

                <button class="mt-4 btn btn-lg btn-primary" type="submit" name="back">Back</button>
                <button class="mt-4 btn btn-lg btn-primary float-end" type="submit" name="create">Create</button>
            </form>
        </div>
        <?php
        break;
    case 'edit':
        // Edit category form
        ?>
        <div class="col-md-6 mx-auto">
            <form method="post" action="<?= ROOT ?>/admin/categories/edit/<?= $row['id'] ?>" enctype="multipart/form-data" autocomplete="off">
                <h1 class="h3 mb-3 fw-normal">Edit category</h1>

                <?php if (!empty($row)): ?>

                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">Please fix the errors below</div>
                    <?php endif; ?>

                    <div class="form-floating">
                        <input value="<?= old_value('category', $row['category']) ?>" name="category" type="text" class="form-control mb-2" id="category" placeholder="Category" required>
                        <label for="category">Category</label>
                    </div>
                    <?php if (!empty($errors['category'])): ?>
                        <div class="text-danger"><?= $errors['category'] ?></div>
                    <?php endif; ?>

                    <div class="form-floating my-3">
                        <select name="disabled" class="form-select" id="disabled" required>
                            <option <?= old_select('disabled', '0', $row['disabled']) ?> value="0">Yes</option>
                            <option <?= old_select('disabled', '1', $row['disabled']) ?> value="1">No</option>
                        </select>
                        <label for="disabled">Active</label>
                    </div>

                    <button class="mt-4 btn btn-lg btn-primary" type="submit" name="back">Back</button>
                    <button class="mt-4 btn btn-lg btn-primary float-end" type="submit" name="save">Save</button>
                <?php else: ?>

                    <div class="alert alert-danger text-center">Record not found!</div>
                <?php endif; ?>

            </form>
        </div>
        <?php
        break;
    case 'delete':
        // Delete category form
        ?>
        <div class="col-md-6 mx-auto">
            <form method="post" action="<?= ROOT ?>/admin/categories/delete/<?= $row['id'] ?>" enctype="multipart/form-data" autocomplete="off">
                <h1 class="h3 mb-3 fw-normal">Delete category</h1>

                <?php if (!empty($row)): ?>

                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">Please fix the errors below</div>
                    <?php endif; ?>

                    <div class="form-floating">
                        <input value="<?= old_value('category', $row['category']) ?>" name="category" type="text" class="form-control mb-2" id="category" placeholder="Category" readonly>
                        <label for="category">Category</label>
                    </div>
                    <?php if (!empty($errors['category'])): ?>
                        <div class="text-danger"><?= $errors['category'] ?></div>
                    <?php endif; ?>

                    <div class="form-floating">
                        <input value="<?= old_value('slug', $row['slug']) ?>" name="slug" type="text" class="form-control mb-2" id="slug" placeholder="Slug" readonly>
                        <label for="slug">Slug</label>
                    </div>
                    <?php if (!empty($errors['slug'])): ?>
                        <div class="text-danger"><?= $errors['slug'] ?></div>
                    <?php endif; ?>

                    <button class="mt-4 btn btn-lg btn-primary" type="submit" name="back">Back</button>
                    <button class="mt-4 btn btn-lg btn-danger float-end" type="submit" name="delete" value="delete">Delete</button>
                <?php else: ?>

                    <div class="alert alert-danger text-center">Record not found!</div>
                <?php endif; ?>

            </form>
        </div>
        <?php
        break;
    default:
        // Categories list
        ?>
        <h4>
            Categories
            <a href="<?= ROOT ?>/admin/categories/add">
                <button class="btn btn-primary">Add New</button>
            </a>
        </h4>

        <div class="table-responsive">
            <table class="table">

                <tr>
                    <th>#</th>
                    <th>Category</th>
                    <th>Slug</th>
                    <th>Active</th>
                    <th>Action</th>
                </tr>
                <?php
                $limit = 10;
                $offset = ($PAGE['page_number'] - 1) * $limit;

                $query = "select * from categories order by id desc limit $limit offset $offset";
                $rows = query($query);
                ?>

                <?php if (!empty($rows)): ?>
                    <?php foreach ($rows as $row): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= esc($row['category']) ?></td>
                            <td><?= $row['slug'] ?></td>
                            <td><?= $row['disabled'] ? 'No' : 'Yes' ?></td>
                            <td>
                                <a href="<?= ROOT ?>/admin/categories/edit/<?= $row['id'] ?>">
                                    <button class="btn btn-warning text-white btn-sm"><i class="bi bi-pencil-square"></i></button>
                                </a>
                                <a href="<?= ROOT ?>/admin/categories/delete/<?= $row['id'] ?>">
                                    <button class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i></button>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </table>

            <div class="col-md-12 mb-4">
                <a href="<?= $PAGE['first_link'] ?>">
                    <button class="btn btn-primary">First Page</button>
                </a>
                <a href="<?= $PAGE['prev_link'] ?>">
                    <button class="btn btn-primary">Prev Page</button>
                </a>
                <a href="<?= $PAGE['next_link'] ?>">
                    <button class="btn btn-primary float-end">Next Page</button>
                </a>
            </div>
        </div>

        <?php
        break;
}
?>
