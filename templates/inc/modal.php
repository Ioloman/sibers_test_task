<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="modalLabel">Create User</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <div class="mb-3 row">
                      <label class="col-form-label col-2">Login: </label>
                      <div class="col">
                          <input name="login" class="form-control" type="text" placeholder="User's login" maxlength="50" name="login" required>
                      </div>
                  </div>
                  <div class="mb-3 row">
                      <label class="col-form-label col-2">Password: </label>
                      <div class="col">
                          <input name="password" class="form-control" type="password" placeholder="User's password"  maxlength="50" name="password" required>
                      </div>
                  </div>
                  <div class="mb-3 row">
                      <label class="col-form-label col-2">Role: </label>
                      <div class="col-auto">
                        <select class="form-select" name="role">
                          <?php foreach ($roles as $role): ?>
                          <?php echo "<option value=\"$role->id\"".($role->id == 1 ? " selected" : "").">$role->role</option>" ?>
                          <?php endforeach; ?>
                        </select>
                      </div>
                  </div>
                  
                  <div class="accordion" id="accordionExample">
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
                              <input type="text" class="form-control" placeholder="First name" aria-label="First name" id="floatingFirstName" name="first_name" maxlength="50">
                              <label for="floatingFirstName" class="ms-2">First name</label>
                            </div>
                            <div class="col-6 form-floating">
                              <input type="text" class="form-control" placeholder="Last name" aria-label="Last name" id="floatingLastName" name="last_name" maxlength="50">
                              <label for="floatingLastName"  class="ms-2">Last name</label>
                            </div>
                          </div>
                          <div class="mb-3 row">
                            <label class="col-form-label col-auto">Gender: </label>
                            <div class="col-auto mt-2">
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="inlineRadio1" value="male">
                                <label class="form-check-label" for="inlineRadio1">M</label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="female">
                                <label class="form-check-label" for="inlineRadio2">F</label>
                              </div>
                            </div>
                          </div>
                          <div class="mb-3 row">
                            <label class="col-form-label col-auto">Date of Birth: </label>
                            <div class="col-auto">
                                <input class="form-control" type="date" placeholder="Date of Birth" name="birth_date">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-primary" id="createUserButton">Create</button>
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
          </div>
      </div>
  </div>

  <div class="modal" tabindex="-1" id="errorModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Sorry, but an error occured!</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>