<!-- the main page -->

<!-- include top parts of the page and pass variables there -->
<?php
/**
 * @var mixed $title
 */
$title = 'Admin';
include 'inc/header.php'
?>
<main>
  <!-- authenticated content -->
  <?php if ($_SESSION['is_logged_in']): ?>

  <!-- modal window for users creation -->
  <?php include 'inc/modal.php'; ?>

  <div class="container mt-2">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title text-uppercase mb-0">Manage Users</h5>
          </div>
          <div class="table-responsive">
            <div class="container">
              <div class="row">
                <div class="col-auto my-2">
                  <button data-bs-toggle="modal" data-bs-target="#addUserModal" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/></svg></button>
                </div>
                <div class="col-auto row my-2 mx-2">
                  <label class="col-form-label col-auto">Show</label>
                  <div class="col-auto">
                    <!-- select how many pages to display -->
                    <select class="form-select" id="show">
                      <?php foreach (array(10, 25, 50, 100) as $v): ?>
                      <?php echo '<option value="'.$v.'"'.(!isset($show) && $v == 10 ? ' selected' : (isset($show) && $show == $v ? ' selected' : '')).'>'.$v.'</option>'; ?>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <label class="col-form-label col-auto">entries</label>
                </div>
              </div>
            </div>
            <table class="table no-wrap user-table mb-0">
              <thead>
                <tr>
                  <?php 
                  $sortingClass = $sorting[0] === 'd' ? 'sorting_desc' : 'sorting_asc'; 
                  $sortingField = substr($sorting, 1);
                  ?>
                  <th scope="col" class="border-0 fs-5 sorting <?php if ($sortingField === 'login') echo $sortingClass ?>" data-sorting-field="login">Login</th>
                  <th scope="col" class="border-0 fs-5 sorting <?php if ($sortingField === 'last_name') echo $sortingClass ?>" data-sorting-field="last_name">Name</th>
                  <th scope="col" class="border-0 fs-5 sorting <?php if ($sortingField === 'created_at') echo $sortingClass ?>" data-sorting-field="created_at">Added</th>
                  <th scope="col" class="border-0 fs-5">Role</th>
                  <th scope="col" class="border-0 fs-5">Manage</th>
                </tr>
              </thead>
              <tbody id="entries">
                <!-- include user entries -->
                <?php foreach ($users as $user) : ?>
                <?php include 'inc/entry.php' ?>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <div class="card-footer clearfix">
            <!-- info about pages -->
            <?php include 'inc/calculatePages.php' ?>
            <div class="float-md-end">
            <!-- pagination (just a default template) - rendered by javascript -->
            <nav>
              <ul class="pagination" data-entries-total="<?php echo $total; ?>">
                <li class="page-item disabled">
                  <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item active" aria-current="page">
                  <a class="page-link" href="#">2</a>
                </li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                  <a class="page-link" href="#">Next</a>
                </li>
              </ul>
            </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- unauthenticated content (jumbotron) -->
  <?php else: ?>

    <div class="p-5 mb-4 rounded-3 bg-light">
        <div class="container-fluid py-5">
            <h1 class="display-5 fw-bold">Admin page</h1>
            <p class="col-md-8 fs-4">Please, log in to be able to manage users.</p>
            <a class="btn btn-primary btn-lg" type="button" href="<?php echo LOGIN_URL; ?>">Log In</a>
        </div>
    </div>

  <?php endif; ?>

</main>
<!-- include footer -->
<?php
/**
 * @var array $scripts - pass scripts to the footer
 */
$scripts = [
  '/static/js/helpers.js',
  '/static/js/pagination.js',
  '/static/js/deleteUser.js',
  '/static/js/sorting.js',
  '/static/js/modalSetting.js',
  'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js',
  '//cdnjs.cloudflare.com/ajax/libs/validate.js/0.13.1/validate.min.js',
];
include 'inc/footer.php'
?>