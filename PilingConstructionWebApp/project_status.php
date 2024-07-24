<?php
session_start();
$connection = mysqli_connect('localhost', 'root', '', 'finalresearch');

// Handle AJAX request
if (isset($_POST['project_id'])) {
    $project_id = $_POST['project_id'];

    $query = "SELECT pile_number FROM pile WHERE fk_project_id = '$project_id' AND pile_status = 'yes'";
    $query_run = mysqli_query($connection, $query);

    $pile_names = array();
    if (mysqli_num_rows($query_run) > 0) {
        while ($row = mysqli_fetch_assoc($query_run)) {
            $pile_names[] = $row['pile_number'];
        }
    }

    echo json_encode($pile_names);
    exit();
}

include('includes/header.php'); 
include('includes/navbar.php'); 
?>

<div class="container-fluid">

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Project status</h6>
    </div>

    <div class="card-body">

      <?php
      if (isset($_SESSION['status_code']) && $_SESSION['status_code'] != '') {
      ?>
        <div class="alert alert-success alert-block">
          <button type="button" class="close" data-dismiss="alert">×</button>
          <?php echo $_SESSION['status']; ?>
        </div>
      <?php
        unset($_SESSION['status_code']);
      }
      ?>

      <div class="table-responsive">
        <?php
        $query = "SELECT p.id, p.project_code, p.project_name, p.pilecount, COUNT(pl.fk_project_id) AS piles_count
                  FROM project p
                  LEFT JOIN pile pl ON p.id = pl.fk_project_id AND pl.pile_status = 'yes'
                  GROUP BY p.id, p.project_code, p.project_name, p.pilecount";
        $query_run = mysqli_query($connection, $query);
        ?>

        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Project Code</th>
              <th>Project Name</th>
              <th>Total Piles</th>
              <th>Completed Piles</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if (mysqli_num_rows($query_run) > 0) {
              while ($row = mysqli_fetch_assoc($query_run)) {
            ?>
                <tr data-project-id="<?php echo $row['id']; ?>" class="project-row">
                  <td><?php echo $row['project_code']; ?></td>
                  <td><?php echo $row['project_name']; ?></td>
                  <td><?php echo $row['pilecount']; ?></td>
                  <td class="completed-piles-cell"><?php echo $row['piles_count']; ?></td>
                </tr>
            <?php
              }
            } else {
              echo "No Record Found";
            }
            ?>
          </tbody>
        </table>

      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->

<!-- Add a modal -->
<div class="modal fade" id="completedPilesModal" tabindex="-1" aria-labelledby="completedPilesModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="completedPilesModalLabel">Completed Piles</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="completedPilesContent">
        <!-- Completed piles content will be dynamically populated here -->
      </div>
    </div>
  </div>
</div>

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>

<script>
  $(document).ready(function() {
    $('.completed-piles-cell').click(function() {
      var projectId = $(this).closest('tr').data('project-id');

      $.ajax({
        url: 'project_status.php', // Same file for handling AJAX request
        method: 'POST',
        data: { project_id: projectId },
        success: function(response) {
          var pileNames = JSON.parse(response);
          var modalContent = '';
          pileNames.forEach(function(pileName) {
            modalContent += '<div>' + pileName + '</div>';
          });
          $('#completedPilesContent').html(modalContent);
          $('#completedPilesModal').modal('show');
        }
      });
    });
  });
</script>
