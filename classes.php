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
$records_per_page = 6;

// Determine the current page number
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($current_page - 1) * $records_per_page;

// Fetch student records from the database with limit and offset
$sql = "SELECT c.id AS class_id, 
               GROUP_CONCAT(s.id SEPARATOR ', ') AS student_ids,
               GROUP_CONCAT(s.name SEPARATOR ', ') AS student_names,
               COUNT(s.id) AS total_students,
               c.title AS class_title
        FROM classes c
        LEFT JOIN students s ON c.id = s.class_id
        GROUP BY c.id
        LIMIT $records_per_page OFFSET $offset";

$result = $conn->query($sql);

// Include header file
include("php/header.php");
?>
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 ">
        <h1 class="h2">Classes Records</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                <!-- Button to trigger modal for adding a new class -->
                <button class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#addClassModal">Add New Class</button>
            </div>
        </div>
    </div>

   <!-- Display student records -->
<div class="table-responsive">
    <table class="table table-striped">
    <thead>
    <tr>
        <th>#</th>
        <th>Class ID</th>
        <th>Class Title</th>
        <th>Student IDs</th>
        <th>Student Names</th>
        <th>Total Students</th>
        <th>Edit/Delete</th> <!-- New column header -->
    </tr>
</thead>
<tbody>
    <?php
    // Check if there are any student records
    if ($result->num_rows > 0) {
        $i = $offset + 1; // Start numbering from the correct position
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $i . "</td>";
            echo "<td>" . $row['class_id'] . "</td>";
            echo "<td>" . $row['class_title'] . "</td>";
            echo "<td>" . ($row['student_ids'] ? $row['student_ids'] : 'None') . "</td>";
            echo "<td>" . ($row['student_names'] ? $row['student_names'] : 'None') . "</td>";
            echo "<td>" . $row['total_students'] . "</td>";
            
            // Edit and Delete options
            echo "<td>";
            echo "<a href='hanldequery/class/edit_classes.php?id=" . $row['class_id'] . "' class='btn btn-sm btn-primary mr-1'>Edit</a>";
            echo "<a href='hanldequery/class/delete_classes.php?id=" . $row['class_id'] . "' class='btn btn-sm btn-danger'>Delete</a>";
            echo "</td>";
            
            echo "</tr>";
            
            $i++;
        }
    } else {
        echo "<tr><td colspan='7'>No records found.</td></tr>"; // Change colspan from '6' to '7'
    }
    ?>
</tbody>

    </table>
</div>

    <!-- Pagination links -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <?php
            // Previous page link
            $prev_page = $current_page - 1;
            if ($prev_page > 0) {
                echo "<li class='page-item'><a class='page-link' href='classes.php?page=$prev_page'>Previous</a></li>";
            } else {
                echo "<li class='page-item disabled'><span class='page-link'>Previous</span></li>";
            }

            // Next page link
            $next_page = $current_page + 1;
            $sql_count = "SELECT COUNT(*) AS count FROM students"; // Change 'Students' to 'students'
            $result_count = $conn->query($sql_count);
            $row_count = $result_count->fetch_assoc();
            $total_records = $row_count['count'];
            $total_pages = ceil($total_records / $records_per_page);
            if ($next_page <= $total_pages) {
                echo "<li class='page-item'><a class='page-link' href='classes.php?page=$next_page'>Next</a></li>";
            } else {
                echo "<li class='page-item disabled'><span class='page-link'>Next</span></li>";
            }
            ?>
        </ul>
    </nav>
</main>

<!-- Modal for adding a new class -->
<div class="modal fade" id="addClassModal" tabindex="-1" role="dialog" aria-labelledby="addClassModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addClassModalLabel">Add New Class</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form for adding a new class -->
                <form method="POST" action="data-base/add-class.php">
                    <div class="form-group">
                        <label for="title">Class Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Class</button>
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
    // Add an event listener to the menu item
    document.getElementById('addClassLink').addEventListener('click', function(event) {
        // Prevent the default behavior of the link (i.e., navigating to another page)
        event.preventDefault();
        
        // Get the modal element
        var modal = document.getElementById('addClassModal');
        
        // Open the modal
        $(modal).modal('show');
    });

</script>
</body>
</html>
