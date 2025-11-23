<?php 
  // check if user is logged in or not
  checkIfuserIsNotLoggedIn();
  checkIfIsNotAdmin();

  // 1. connect to the database
  $database = connectToDB();
  
  // 2. get all the contact messages
  // 2.1
  $sql = "SELECT contacts.id, contacts.name, contacts.email, contacts.message 
          FROM contacts";
  // 2.2
  $query = $database->prepare( $sql );
  // 2.3
  $query->execute();
  // 2.4
  $contacts = $query->fetchAll();
  
  require "parts/header.php"; 
?>
<div class="container mx-auto my-5" style="max-width: 700px;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="display-6 fw-bold">Manage Messages</h1>
      </div>
      <div class="card mb-2 p-4">
        <table class="table table-borderless align-middle">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Name</th>
              <th scope="col">Email</th>
              <th scope="col">Message</th>
              <th scope="col" class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            <!-- 3. use foreach to display all the contact messages -->
             <?php foreach ($contacts as $contact) :?>
            <tr>
              <th scope="row"><?= e($contact['id']); ?></th>
              <td><?= e($contact['name']); ?></td>
              <td><?= e($contact['email']); ?></td>
              <td><?= e($contact['message']); ?></td>
              <td class="text-end">
                <div class="d-flex justify-content-end gap-2">
                  <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete-contact-<?= e($contact['id']); ?>">
                    <i class="bi bi-trash"></i>
                  </button>

                  <!-- Modal -->
                  <div class="modal fade" id="delete-contact-<?= e($contact['id']); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Contact: <?= e($contact['name']); ?></h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-start">
                          This action cannot be reversed. Are you sure you want to delete this contact message?
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          <form method="POST" action="<?= BASE_PATH ?>/contact/delete">
                            <input type="hidden" name="csrf_token" value="<?= e(getCsrfToken()); ?>">
                            <input type="hidden" name="id" value="<?= e($contact['id']); ?>" />
                            <button class="btn btn-danger"><i class="bi bi-trash"></i> Delete Now</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                  
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
    <?php require 'parts/footer.php'; ?>
