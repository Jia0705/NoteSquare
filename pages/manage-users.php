<?php 

  // check if user is logged in or not
  checkIfuserIsNotLoggedIn();

  // check if the user is admin or not
  checkIfIsNotAdmin();

  // 1. connect to the database
  $database = connectToDB();
  
  // 2. get all the users
  // 2.1
  $sql = "SELECT * FROM users";
  // 2.2
  $query = $database->prepare( $sql );
  // 2.3
  $query->execute();
  // 2.4
  $users = $query->fetchAll();
  
  require "parts/header.php"; 
?>
<div class="container mx-auto my-5" style="max-width: 700px;">
      <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <h1 class="display-6 fw-bold mb-0">Manage Users</h1>
        <div class="text-end">
          <a href="<?= BASE_PATH ?>/manage-users-add" class="btn btn-primary btn-lg px-4 fw-bold">Add New User</a>
        </div>
      </div>
      <div class="card mb-2 p-4">
        <table class="table table-borderless align-middle">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Name</th>
              <th scope="col">Email</th>
              <th scope="col">Role</th>
              <th scope="col" class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            <!-- 3. use foreach to display all the users -->
             <?php foreach ($users as $index => $user) :?>
            <tr>
              <th scope="row"><?= e($user['id']); ?></th>
              <td><?= e($user['name']); ?></td>
              <td><?= e($user['email']); ?></td>
              <td>
                <?php if ( $user['role'] == 'admin' ) : ?>
                  <span class="badge bg-success"><?= e($user['role']); ?></span>
                <?php endif; ?>
                <?php if ( $user['role'] == 'editor' ) : ?>
                  <span class="badge bg-info"><?= e($user['role']); ?></span>
                <?php endif; ?>
                <?php if ( $user['role'] == 'user' ) : ?>
                  <span class="badge bg-primary"><?= e($user['role']); ?></span>
                <?php endif; ?>
              </td>
              <td class="text-end">
                <div class="d-flex flex-wrap justify-content-end gap-2">
                  <a href="<?= BASE_PATH ?>/manage-users-edit?id=<?= e($user['id']); ?>" class="btn btn-outline-secondary btn-sm"><i class="bi bi-pencil"></i></a>
                  <a href="<?= BASE_PATH ?>/manage-users-changepwd?id=<?= e($user['id']); ?>" class="btn btn-warning btn-sm"><i class="bi bi-key"></i></a>

                  <?php if ( $user['id'] != $_SESSION['user']['id'] ) : ?>
                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete-user-<?= e($user['id']); ?>">
                      <i class="bi bi-trash"></i>
                    </button>
                  <?php endif; ?>

                  <!-- Modal -->
                  <?php if ( $user['id'] != $_SESSION['user']['id'] ) : ?>
                  <div class="modal fade" id="delete-user-<?= e($user['id']); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="exampleModalLabdel">Delete User: <?= e($user['name']); ?></h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-start">
                          This action cannot be reversed.
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          <form method="POST" action="<?= BASE_PATH ?>/user/delete">
                            <input type="hidden" name="csrf_token" value="<?= e(getCsrfToken()); ?>">
                            <input type="hidden" name="id" value="<?= e($user['id']); ?>" />
                            <button class="btn btn-danger"> <i class="bi bi-trash"></i> Delete Now</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php endif; ?>
                  
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <div class="text-center mt-4">
        <a href="<?= BASE_PATH ?>/dashboard" class="btn btn-outline-secondary btn-lg px-4 fw-bold" style="border-radius:14px;"
          ><i class="bi bi-arrow-left"></i> Back to Dashboard</a>
      </div>
    </div>
    <?php require 'parts/footer.php';
