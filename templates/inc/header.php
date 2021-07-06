<!-- header that show login/logout button -->

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="/static/css/styles.css">
    <link rel="icon" href="/static/icons/favicon.png" type="image/png">
    <title><?php if (isset($title)) echo $title; else echo 'Admin page'; ?></title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="<?php echo ROOT_URL; ?>">Admin</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarText">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link <?php if ($_SERVER['PHP_SELF'] == ROOT_URL) echo ' active'; ?>" href="<?php echo ROOT_URL; ?>">Manage Users</a>
                        </li>
                    </ul>
                    <!-- links are provided as defined constants -->
                    <?php if (!$_SESSION['is_logged_in']): ?>
                    <a class="btn btn-primary" href="<?php echo LOGIN_URL; ?>">
                        Log In
                    </a>
                    <?php endif; ?>
                    <?php if ($_SESSION['is_logged_in']): ?>
                    <a class="btn btn-primary" href="<?php echo LOGOUT_URL; ?>">
                        Log Out
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </header>