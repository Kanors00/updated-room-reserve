<?php
session_start();
if ($_SESSION['role'] !== 'user' && $_SESSION['role'] !== 'admin') {
  header("Location: /room-res/index.php");
  exit;
}
?>

<?php
include 'sql.php';
include 'header.php';
include 'sidebar.php';
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
  <section class="content pt-4">
    <div class="container-fluid">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="text-primary font-weight-bold">
          <i class="fas fa-calendar-alt mr-2"></i> Reservation Records
        </h3>
      </div>

      <table id="reservationTable" class="table table-hover table-bordered table-striped shadow-sm rounded">
        <thead class="thead-light">
          <tr>
            <th>ID</th>
            <th>Room</th>
            <th>Name</th>
            <th>Company</th>
            <th>Contact #</th>
            <th>Email</th>
            <th>Date</th>
            <th>Guests</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()):
            $id = htmlspecialchars($row['id']);
          ?>
            <tr class="<?= $rowClass ?>">
              <td><?= $id ?></td>
              <td><?= htmlspecialchars($row['room_id']) ?></td>
              <td><?= htmlspecialchars($row['user_name']) ?></td>
              <td><?= htmlspecialchars($row['user_company']) ?></td>
              <td><?= htmlspecialchars($row['user_contact']) ?></td>
              <td><?= htmlspecialchars($row['user_email']) ?></td>
              <td><?= htmlspecialchars($row['booking_date']) ?></td>
              <td><?= htmlspecialchars($row['guest_count']) ?></td>
              <td>

                <button class="btn btn-danger btn-sm m-1" data-toggle="modal" data-target="#cancelModal<?= $id ?>">
                  <i class="fas fa-trash-alt"></i> Cancel
                </button>
    </div>
    </td>
    </tr>

    <!-- Edit Modal -->
    <!-- <div class="modal fade" id="editModal<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="editLabel<?= $id ?>" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <form method="POST" action="edit-reservation.php">
                  <input type="hidden" name="id" value="<?= $id ?>">
                  <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                      <h5 class="modal-title">
                        <i class="fas fa-pencil-alt mr-2"></i> Edit Reservation #<?= $id ?>
                      </h5>
                      <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>

                    <div class="modal-body">
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="name<?= $id ?>">Name</label>
                          <input type="text" id="name<?= $id ?>" name="user_name" class="form-control" value="<?= htmlspecialchars($row['user_name']) ?>" required>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="company<?= $id ?>">Company</label>
                          <input type="text" id="company<?= $id ?>" name="user_company" class="form-control" value="<?= htmlspecialchars($row['user_company']) ?>">
                        </div>
                        <div class="form-group col-md-6">
                          <label for="contact<?= $id ?>">Contact #</label>
                          <input type="text" id="contact<?= $id ?>" name="user_contact" class="form-control" value="<?= htmlspecialchars($row['user_contact']) ?>" required>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="email<?= $id ?>">Email</label>
                          <input type="email" id="email<?= $id ?>" name="user_email" class="form-control" value="<?= htmlspecialchars($row['user_email']) ?>" required>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="bookingDate<?= $id ?>">Booking Date</label>
                          <input type="date" id="bookingDate<?= $id ?>" name="booking_date" class="form-control" value="<?= htmlspecialchars($row['booking_date']) ?>" required>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="bookingTime<?= $id ?>">Booking Time Range</label>
                          <select id="bookingTime<?= $id ?>" name="booking_time" class="form-control" required>
                            PHP
                            $times = [
                              "08:00 - 08:30",
                              "08:30 - 09:00",
                              "09:00 - 09:30",
                              "09:30 - 10:00",
                              "10:00 - 10:30",
                              "10:30 - 11:00",
                              "11:00 - 11:30",
                              "11:30 - 12:00",
                              "12:00 - 12:30",
                              "12:30 - 13:00",
                              "13:00 - 13:30"
                            ];
                            foreach ($times as $time) {
                              $selected = ($row['booking_time'] === $time) ? 'selected' : '';
                              echo "<option value=\"$time\" $selected>$time</option>";
                            }
                            PHP
                          </select>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="guestCount<?= $id ?>">Number of Guests</label>
                          <input type="number" id="guestCount<?= $id ?>" name="guest_count" class="form-control" min="1" max="20" value="<?= htmlspecialchars($row['guest_count']) ?>" required>
                        </div>
                      </div>
                    </div>

                    <div class="modal-footer">
                      <button type="submit" class="btn btn-success">Save Changes</button>
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                  </div>
                </form>
              </div>
            </div> -->

    <!-- Cancel Modal -->
    <div class="modal fade" id="cancelModal<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="cancelLabel<?= $id ?>" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <form method="POST" action="cancel-reservation.php">
          <input type="hidden" name="id" value="<?= $id ?>">
          <div class="modal-content">
            <div class="modal-header bg-danger text-white">
              <h5 class="modal-title"><i class="fas fa-trash-alt mr-2"></i> Cancel Reservation #<?= $id ?></h5>
              <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Are you sure you want to cancel this reservation?</p>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-danger">Yes, Cancel</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  <?php endwhile; ?>
  </tbody>
  </table>
</div>
</section>
</div>

<?php include 'footer.php'; ?>
<script src="scripts.js"></script>
<?php $conn->close(); ?>