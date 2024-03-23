<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Allied school management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
<?php
// Include database connection file
include("php/dbconnect.php");

// Define the number of records to display per page
$records_per_page = 5;

// Determine the current page number
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($current_page - 1) * $records_per_page;

// Fetch teacher records from the database along with the subjects they teach and the total number of subjects
$sql = "SELECT t.id AS teacher_id, t.name AS teacher_name, 
       GROUP_CONCAT(s.title) AS subject_titles,
       COUNT(s.id) AS total_subjects_taught
FROM teachers t
LEFT JOIN subjects s ON t.id = s.teacher_id
GROUP BY t.id, t.name
LIMIT $records_per_page OFFSET $offset;
";

$result = $conn->query($sql);

// Include header file
include("php/header.php");
?>
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 ">
        <h1 class="h2">Teachers</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                <button class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#addteacherModal">Add New Teacher</button>
            </div>
        </div>
    </div>

    <!-- Display teacher records -->
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Teacher ID</th>
                    <th>Teacher Name</th>
                    <th>Subjects Taught</th>
                    <th>Total Subjects Taught</th>
                    <th>Edit/Delete</th> <!-- New column for Edit/Delete buttons -->
                </tr>
            </thead>
            <tbody>
                <?php
                // Check if there are any teacher records
                if ($result->num_rows > 0) {
                    $i = $offset + 1; // Start numbering from the correct position
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $i . "</td>";
                        echo "<td>" . $row['teacher_id'] . "</td>";
                        echo "<td>" . $row['teacher_name'] . "</td>";
                        echo "<td>" . $row['subject_titles'] . "</td>";
                        echo "<td>" . $row['total_subjects_taught'] . "</td>";
                        // Edit and Delete options merged into one column
                        echo "<td>";
                        echo "<a href='hanldequery/teachers/edit_teacher.php?id=" . $row['teacher_id'] . "' class='btn btn-primary'>Edit</a> ";
                        echo "<a href='hanldequery/teachers/delete_teacher.php?id=" . $row['teacher_id'] . "' class='btn btn-danger'>Delete</a>";
                        echo "</td>";
                        echo "</tr>";
                        $i++;
                    }
                } else {
                    echo "<tr><td colspan='6'>No records found.</td></tr>"; // Change colspan from '5' to '6'
                }
                ?>
            </tbody>
        </table>
    </div>


    <nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <?php
        // Previous page link
        $prev_page = $current_page - 1;
        if ($prev_page > 0) {
            echo "<li class='page-item'><a class='page-link' href='teachers.php?page=$prev_page'>Previous</a></li>";
        } else {
            echo "<li class='page-item disabled'><span class='page-link'>Previous</span></li>";
        }

        // Next page link
        $next_page = $current_page + 1;
        $sql_count = "SELECT COUNT(*) AS count FROM teachers"; // Change 'students' to 'teachers'
        $result_count = $conn->query($sql_count);
        $row_count = $result_count->fetch_assoc();
        $total_records = $row_count['count'];
        $total_pages = ceil($total_records / $records_per_page);
        if ($next_page <= $total_pages) {
            echo "<li class='page-item'><a class='page-link' href='teachers.php?page=$next_page'>Next</a></li>";
        } else {
            echo "<li class='page-item disabled'><span class='page-link'>Next</span></li>";
        }
        ?>
    </ul>
</nav>

</main>






<!-- Modal for adding a new student -->
<!-- Modal for adding a new class -->
<div class="modal fade" id="addteacherModal" tabindex="-1" role="dialog" aria-labelledby="addClassModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addClassModalLabel">Add New Teacher</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form for adding a new class -->
                <form method="POST" action="hanldequery/teachers/add-teacher.php">
                    <div class="form-group">
                        <label for="title">Teacher Name </label>
                        <input type="text" class="form-control" id="title" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Teacher</button>
                </form>
            </div>
        </div>
    </div>
</div>



<footer class="text-center mt-4">
    <div class="container">
        <p>Online Allied school management System | Developed By: Aqib Hameed</p>
    </div>
</footer>
<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>

<script>
    // Add an event listener to the button triggering the modal
document.getElementById('addteacherLink').addEventListener('click', function(event) {
    // Prevent the default behavior of the button (i.e., submitting the form)
    event.preventDefault();
    
    // Get the modal element
    var modal = document.getElementById('addteacherModal');
    
    // Open the modal
    $(modal).modal('show');
});

</script>
</body>
</html>
