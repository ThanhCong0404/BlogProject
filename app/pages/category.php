<?php include '../app/pages/includes/header.php'; ?>

<div class="mx-auto col-md-10">
    <h3 class="mx-4">Category</h3>

      <div class="row my-2 justify-content-center">

        <?php
        // Define the limit and offset
        $limit = 10;
        $offset = (isset($PAGE['page_number']) ? $PAGE['page_number'] : 1) * $limit - $limit;

        // Get the category slug from the URL
        $category_slug = isset($url[1]) ? $url[1] : null;

        // Check if the category slug is set
        if ($category_slug) {

          // Prepare the query
          $query = "select posts.*,categories.category from posts join categories on posts.category_id = categories.id where posts.category_id in (select id from categories where slug = :category_slug && disabled = 0) order by id desc limit $limit offset $offset";

          // Execute the query
          $rows = query($query, ['category_slug' => $category_slug]);

          // Check if the query was successful
          if ($rows) {
            foreach ($rows as $row) {
              include '../app/pages/includes/post-card.php';
            }
          } else {
            echo "No items found!";
          }

        } else {
          echo "Category slug not set!";
        }

        ?>

      </div>


  <div class="col-md-12 mb-4">
    <a href="<?= isset($PAGE['first_link']) ? $PAGE['first_link'] : '#' ?>">
      <button class="btn btn-primary">First Page</button>
    </a>
    <a href="<?= isset($PAGE['prev_link']) ? $PAGE['prev_link'] : '#' ?>">
      <button class="btn btn-primary">Prev Page</button>
    </a>
    <a href="<?= isset($PAGE['next_link']) ? $PAGE['next_link'] : '#' ?>">
      <button class="btn btn-primary float-end">Next Page</button>
    </a>
  </div>
</div>
<?php include '../app/pages/includes/footer.php'; ?>
