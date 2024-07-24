<?php
session_start();
include('includes/header.php'); 
include('includes/navbar.php'); 

$connection = mysqli_connect('localhost', 'root', '', 'finalresearch');

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['projectSelect'])) {
    $_SESSION['selected_project'] = $_POST['projectSelect']; // Store selected project in session
}

$query = "SELECT id, project_name FROM project";
$query_run = mysqli_query($connection, $query);

// Fetch project names from the database
$projects = []; // Initialize an empty array
$ids = [];

if (mysqli_num_rows($query_run) > 0) {
    // Loop through the result set
    while ($row = mysqli_fetch_assoc($query_run)) {
        $projects[] = $row['project_name'];
        $ids[] = $row['id'];
    }
}

// Check if a project is already selected in session
$selected_project_id = isset($_SESSION['selected_project']) ? $_SESSION['selected_project'] : '';
?>

<div class="container-fluid">

    <form method="POST">
        <div class="form-group">
            <label for="projectSelect">Select Project</label>
            <select class="form-control" name="projectSelect" id="projectSelect">
                <option value="">Select project</option>
                <?php
                // Populate dropdown options based on fetched projects
                foreach ($projects as $index => $project) {
                    $selected = ($ids[$index] == $selected_project_id) ? 'selected' : ''; // Check if this project is selected
                    echo '<option value="' . $ids[$index] . '" ' . $selected . '>' . $project . '</option>';
                }
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Submit</button>
    </form>

    <br>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Resource Profile</h6>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addadminprofile">
                Add Resource Profile
            </button>
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
                if (isset($_POST['projectSelect'])) {
                    $selectedProject = $_POST['projectSelect'];
                    $_SESSION['selectedProject'] = $selectedProject;
                    $query = "SELECT * FROM resource WHERE fk_project_id = '$selectedProject'";
                    $query_run = mysqli_query($connection, $query);
                ?>

                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Resource Name</th>
                                <th>Quantity</th>
                                <th>Cost</th>
                                <th colspan="2" style="text-align: center;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($query_run) > 0) {
                                while ($row = mysqli_fetch_assoc($query_run)) {
                            ?>
                                    <tr>
                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php echo $row['qty']; ?></td>
                                        <td><?php echo $row['cost']; ?></td>
                                        <td>
                                            <form action="resource_edit.php" method="post">
                                                <input type="hidden" name="resource_edit_id" value="<?php echo $row['id']; ?>">
                                                <button type="submit" name="resource_edit_btn" class="btn btn-success">EDIT</button>
                                            </form>
                                        </td>
                                        <td>
                                            <form action="resource_code.php" method="post">
                                                <input type="hidden" name="resource_delete_id" value="<?php echo $row['id']; ?>">
                                                <button type="submit" name="resource_delete_btn" class="btn btn-danger">DELETE</button>
                                            </form>
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo "No Record Found";
                            }
                            ?>
                        </tbody>
                    </table>
                <?php
                } else {
                    echo "Please select a project and submit the form.";
                }
                ?>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

<div class="modal fade" id="addadminprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Resource Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="resource_code.php" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Resource Name</label>
                        <input type="text" name="resource_name" class="form-control" placeholder="Eg: Excavator" required>
                    </div>
                    <div class="form-group">
                        <label>Quantity</label>
                        <input type="text" name="qty" class="form-control" placeholder="Eg: 2" required>
                    </div>
                    <div class="form-group">
                        <label>Cost</label>
                        <input type="text" name="cost" class="form-control" placeholder="Eg: 50 000.00" required>
                    </div>
                    <input type="hidden" name="resource_status" value="No">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="addresource_btn" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>
