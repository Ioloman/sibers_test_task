<!-- include top parts of the page and pass variables there -->
<?php
/**
 * @var mixed $title
 */
$title = 'Log In';
include 'inc/header.php'
?>

<main role="main">
    <div class="container mt-3">
        <div class="row justify-content-center">
            <?php if (isset($message)): ?>
            <div class="alert alert-danger d-flex align-items-center col-lg-7 col-md-9 col-sm-12" role="alert"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg><div><?php echo $message ?></div></div>
            <?php endif; ?>
            <form class="form-group w-50 mb-3" method="post" action="<?php echo LOGIN_URL ?>">
                <div class="form-group">
                    <label>Login</label>
                    <input type="text" name="login" class="form-control" placeholder="Enter your login">
                    <small class="form-text text-muted">For users with admin permissions</small>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter your password">
                </div>
                <button type="submit" class="btn btn-primary mt-3">Log in</button>
            </form>
        </div>
    </div>
</main>

<!-- include footer -->
<?php
/**
 * @var array $scripts - pass scripts to the footer
 */
$scripts = [
    '/static/js/login.js',
    'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js',
    '//cdnjs.cloudflare.com/ajax/libs/validate.js/0.13.1/validate.min.js',
];
include 'inc/footer.php'
?>