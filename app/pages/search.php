<?php include '../app/pages/includes/header.php'; ?>

<div class="mx-auto col-md-10">
    <h3 class="mx-4">Search</h3>

    <div class="row my-2 justify-content-center">

        <?php

        $limit = 10;
        $offset = (isset($PAGE['page_number']) && $PAGE['page_number'] > 0) ? ($PAGE['page_number'] - 1) * $limit : 0;

        $searchTerm = $_GET['find'] ?? '';
        $searchTerm = strlen($searchTerm) > 0 ? "%$searchTerm%" : null;

        if ($searchTerm) {
            $query = "select posts.*,categories.category from posts join categories on posts.category_id = categories.id where posts.title like :searchTerm order by id desc limit $limit offset $offset";
            $rows = query($query, ['searchTerm' => $searchTerm]);

            if (!$rows) {
                echo "No items found!";
                exit;
            }

            $totalRows = query("select count(*) from posts join categories on posts.category_id = categories.id where posts.title like :searchTerm", ['searchTerm' => $searchTerm])[0]['count'];
            $totalPages = ceil($totalRows / $limit);

            foreach ($rows as $row) {
                include '../app/pages/includes/post-card.php';
            }

        } else {
            echo "Please enter a search term!";
        }

        ?>

    </div>

    <div class="col-md-12 mb-4">
        <?php if (isset($PAGE) && !empty($PAGE)) : ?>
            <a href="<?=$PAGE['first_link'] ? htmlspecialchars($PAGE['first_link'], ENT_QUOTES, 'UTF-8') : '#'; ?>">
                <button class="btn btn-primary">First Page</button>
            </a>
            <a href="<?=$PAGE['prev_link'] ? htmlspecialchars($PAGE['prev_link'], ENT_QUOTES, 'UTF-8') : '#'; ?>">
                <button class="btn btn-primary">Prev Page</button>
            </a>
            <a href="<?=$PAGE['next_link'] ? htmlspecialchars($PAGE['next_link'], ENT_QUOTES, 'UTF-8') : '#'; ?>">
                <button class="btn btn-primary float-end">Next Page</button>
            </a>
        <?php endif; ?>
    </div>
</div>
<?php include '../app/pages/includes/footer.php'; ?>
