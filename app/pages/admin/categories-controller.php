<?php

function isValidCategory($category): bool
{
    return !empty($category) && preg_match("/^[a-zA-Z0-9 \-\_\&]+$/", $category);
}

function getSafeCategoryData($category, $disabled, $id = null): array
{
    $slug = str_to_url($category);
    $slug .= rand(1000, 9999);

    return [
        'category' => $category,
        'slug' => $slug,
        'disabled' => $disabled,
        'id' => $id
    ];
}

function processCategoryRequest($action, $id = null, $data = [])
{
    global $errors;

    switch ($action) {
        case 'add':
            if (empty($errors) && isValidCategory($data['category'])) {
                saveCategory($data);
                redirect('admin/categories');
            }
            break;
        case 'edit':
            if (!empty($row)) {
                if (empty($errors) && isValidCategory($data['category'])) {
                    updateCategory($data);
                    redirect('admin/categories');
                }
            }
            break;
        case 'delete':
            if (!empty($row)) {
                if (empty($errors)) {
                    deleteCategory($id);
                    redirect('admin/categories');
                }
            }
            break;
    }
}

// Add, Edit, and Delete functions
function saveCategory($data)
{
    global $query;
    $query("insert into categories (category, slug, disabled) values (:category, :slug, :disabled)", $data);
}

function updateCategory($data)
{
    global $query;
    $query("update categories set category = :category, disabled = :disabled where id = :id limit 1", $data);
}

function deleteCategory($id)
{
    global $query;
    $query("delete from categories where id = :id limit 1", ['id' => $id]);
}

// Main logic
$errors = [];
$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action == 'add' || $action == 'edit') {
    $id = isset($_GET['id']) ? (int)$_GET['id'] : null;

    if (!empty($_POST)) {
        $data = [
            'category' => $_POST['category'],
            'disabled' => isset($_POST['disabled']) ? 1 : 0
        ];

        processCategoryRequest($action, $id, $data);
    } else {
        if ($action == 'edit') {
            $query = "select * from categories where id = :id limit 1";
            $row = query_row($query, ['id' => $id]);

            if ($row) {
                $data = [
                    'category' => $row['category'],
                    'disabled' => $row['disabled']
                ];
            }
        }
    }
} else if ($action == 'delete') {
    $id = isset($_GET['id']) ? (int)$_GET['id'] : null;

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        processCategoryRequest($action, $id);
    } else {
        $query = "select * from categories where id = :id limit 1";
        $row = query_row($query, ['id' => $id]);
    }
}

// Display form
if ($action == 'add' || ($action == 'edit' && !empty($row))) {
    include 'category_form.php';
} else if ($action == 'delete' && !empty($row)) {
    include 'category_delete_form.php';
} else {
    include 'categories.php';
}
