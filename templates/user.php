<!-- include top parts of the page and pass variables there -->
<?php
/**
 * @var mixed $title
 */
$title = "User: $user->login";
include 'inc/header.php'
?>
<main>
    <form>
        <div class="container mt-3">
            <div class="row justify-content-center" id="content">
                <div class="mb-3 row col-lg-7 col-md-9 col-sm-12">
                    <label class="col-form-label col-2">Login: </label>
                    <div class="col">
                        <input name="login" class="form-control" type="text" placeholder="User's login" maxlength="50" name="login" value="<?php echo $user->login ?>">
                    </div>
                </div>
                <div class="mb-3 row col-lg-7 col-md-9 col-sm-12">
                    <label class="col-form-label col-2">Password: </label>
                    <div class="col">
                        <input name="password" class="form-control" type="password" placeholder="New password" maxlength="50" name="password">
                    </div>
                </div>
                <div class="mb-3 row col-lg-7 col-md-9 col-sm-12">
                    <label class="col-form-label col-2">Role: </label>
                    <div class="col-auto">
                        <select class="form-select" name="role">
                            <?php foreach ($roles as $role) : ?>
                                <?php echo "<option value=\"$role->id\"" . ($role->id == $user->role_id ? " selected" : "") . ">$role->role</option>" ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="accordion col-lg-7 col-md-9 col-sm-12" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                Optional Data
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="mb-3 row">
                                    <div class="col-6 form-floating">
                                        <input type="text" class="form-control" placeholder="First name" aria-label="First name" id="floatingFirstName" name="first_name" maxlength="50" value="<?php echo $user->first_name ?>">
                                        <label for="floatingFirstName" class="ms-2">First name</label>
                                    </div>
                                    <div class="col-6 form-floating">
                                        <input type="text" class="form-control" placeholder="Last name" aria-label="Last name" id="floatingLastName" name="last_name" maxlength="50" value="<?php echo $user->last_name ?>">
                                        <label for="floatingLastName" class="ms-2">Last name</label>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-form-label col-auto">Gender: </label>
                                    <div class="col-auto mt-2">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="inlineRadio1" value="male" <?php echo $user->gender == "male" ? ' checked' : '' ?>>
                                            <label class="form-check-label" for="inlineRadio1">M</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="female" <?php echo $user->gender == "female" ? ' checked' : '' ?>>
                                            <label class="form-check-label" for="inlineRadio2">F</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-form-label col-auto">Date of Birth: </label>
                                    <div class="col-auto">
                                        <input class="form-control" type="date" placeholder="Date of Birth" name="birth_date" value="<?php echo $user->birth_date ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div class="row justify-content-center mt-3">
                <div class="col-auto">
                    <input type="submit" class="btn btn-primary" value="Save changes" formaction="<?php echo UPDATE_URL; ?>" id="update" formmethod="POST">
                </div>
                <div class="col-auto">
                    <input type="submit" class="btn btn-danger" value="Delete" formaction="<?php echo DELETE_URL; ?>" formmethod="POST">
                </div>
            </div>
        </div>
        <input type="hidden" value="<?php echo $user->id; ?>" name="id"/>
        <input type="hidden" value="true" name="form"/>
    </form>

</main>
<!-- include footer -->
<?php
/**
 * @var array $scripts
 */
$scripts = [
    '/static/js/helpers.js',
    '/static/js/updateUser.js',
    'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js',
    '//cdnjs.cloudflare.com/ajax/libs/validate.js/0.13.1/validate.min.js',
];
include 'inc/footer.php'
?>