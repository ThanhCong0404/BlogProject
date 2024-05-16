<?php include '../app/pages/includes/header.php'; ?>

<div class="mx-auto col-md-10">
  <h3 class="mx-4">Blog</h3>

  <div class="row my-2 justify-content-center">
    <?php
    $limit = 10;
    $offset = ($PAGE['page_number'] - 1) * $limit;

    $query = "select posts.*,categories.category from posts join categories on posts.category_id = categories.id order by id desc limit $limit offset $offset";
    $rows = query($query);

    if ($rows) {
      foreach ($rows as $row) {
        include '../app/pages/includes/post-card.php';
      }
    } else {
      echo "No items found!";
    }
    ?>
  </div>

  <div class="col-md-12 mb-4">
    <?php
    $total_pages = ceil(count(query("select * from posts")) / $limit);

    if ($PAGE['page_number'] > 1) {
      echo '<a href="' . $PAGE['first_link'] . '">';
      echo '<button class="btn btn-primary">First Page</button>';
      echo '</a>';

      echo '<a href="' . $PAGE['prev_link'] . '">';
      echo '<button class="btn btn-primary">Prev Page</button>';
      echo '</a>';
    }

    if ($PAGE['page_number'] < $total_pages) {
      echo '<a href="' . $PAGE['next_link'] . '">';
      echo '<button class="btn btn-primary float-end">Next Page</button>';
      echo '</a>';
    }
    ?>
  </div>
</div>
<?php include '../app/pages/includes/footer.php'; ?>
