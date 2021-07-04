<!-- include top parts of the page and pass variables there -->
<?php
/**
 * @var mixed $title
 */
$title = 'Admin';
include 'inc/header.php'
?>
<main>
  <!-- modal window for users creation -->
  <?php include 'inc/modal.php' ?>

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
                    <select class="form-select">
                      <option selected value="10">10</option>
                      <option value="25">25</option>
                      <option value="50">50</option>
                      <option value="100">100</option>
                    </select>
                  </div>
                  <label class="col-form-label col-auto">entries</label>
                </div>
              </div>
            </div>
            <table class="table no-wrap user-table mb-0">
              <thead>
                <tr>
                  <th scope="col" class="border-0 fs-5 sorting">Login</th>
                  <th scope="col" class="border-0 fs-5 sorting">Name</th>
                  <th scope="col" class="border-0 fs-5 sorting">Added</th>
                  <th scope="col" class="border-0 fs-5">Role</th>
                  <th scope="col" class="border-0 fs-5">Manage</th>
                </tr>
              </thead>
              <tbody>
                <!-- include user entries -->
                <?php for ($i = 0; $i < 3; $i++) : ?>
                <?php include 'inc/entry.php' ?>
                <?php endfor; ?>
              </tbody>
            </table>
          </div>
          <div class="card-footer clearfix">
            <div class="float-md-start">Showing 21 to 30 of 57 entries</div>
            <div class="float-md-end">PAGINATION</div>
          </div>
        </div>
      </div>
    </div>
  </div>

</main>
<!-- include footer -->
<?php
/**
 * @var array $scripts
 */
$scripts = [
  'static/js/sorting.js',
  'static/js/modalSetting.js',
];
include 'inc/footer.php'
?>