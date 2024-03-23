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


// Fetch subjects along with their related class and teacher information with pagination
$sql = "SELECT s.id AS subject_id, 
               s.title AS subject_title, 
               s.status, 
               c.id AS class_id, 
               c.title AS class_title,
               t.name AS teacher_name
        FROM subjects s 
        LEFT JOIN classes c ON s.class_id = c.id
        LEFT JOIN teachers t ON s.teacher_id = t.id
        LIMIT $records_per_page OFFSET $offset";

$result = $conn->query($sql);

// Count total number of subjects for pagination
$total_sql = "SELECT COUNT(*) AS count FROM subjects";
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_assoc();
$total_subjects = $total_row['count'];
$total_pages = ceil($total_subjects / $records_per_page);

// Include header file
include("php/header.php");
?>
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
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 ">
        <h1 class="h2">Subjects</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                <button class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#addsubjectModal">Add New Subject</button>
            </div>
        </div>
    </div>

    <!-- Display subjects records -->
    <div class="table-responsive">
        <table class="table table-striped">
        <thead>
    <tr>
        <th>#</th>
        <th>Subject ID</th>
        <th>Subject Title</th>
        <th>Class Title</th>
        <th>Teacher Name</th>
        <th>Status</th>
        <th>Edit/Delete</th>
    </tr>
</thead>
<tbody>
    <?php
    // Check if there are any subject records
    if ($result->num_rows > 0) {
        $i = ($current_page - 1) * $records_per_page + 1; // Start numbering from correct position
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $i . "</td>";
            echo "<td>" . $row['subject_id'] . "</td>"; // Display subject ID
            echo "<td>" . $row['subject_title'] . "</td>";
            echo "<td>" . $row['class_title'] . "</td>";
            echo "<td>" . $row['teacher_name'] . "</td>";
            echo "<td>" . $row['status'] . "</td>";
            // Edit and Delete options merged into one column
            echo "<td>";
            echo "<a href='hanldequery/subjects/edit_subject.php?id=" . $row['subject_id'] . "' class='btn btn-primary'>Edit</a> ";
            echo "<a href='hanldequery/subjects/delete_subject.php?id=" . $row['subject_id'] . "' class='btn btn-danger'>Delete</a>";
            echo "</td>";
            echo "</tr>";
            $i++;
        }
    } else {
        echo "<tr><td colspan='7'>No subject records found.</td></tr>";
    }
    ?>
</tbody>

        </table>
    </div>

    <!-- Pagination -->
<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <?php
        // Previous page link
        $prev_page = $current_page - 1;
        if ($prev_page > 0) {
            echo "<li class='page-item'><a class='page-link' href='subjects.php?page=$prev_page'>Previous</a></li>";
        } else {
            echo "<li class='page-item disabled'><span class='page-link'>Previous</span></li>";
        }

        // Next page link
        $next_page = $current_page + 1;
        if ($next_page <= $total_pages) {
            echo "<li class='page-item'><a class='page-link' href='subjects.php?page=$next_page'>Next</a></li>";
        } else {
            echo "<li class='page-item disabled'><span class='page-link'>Next</span></li>";
        }
        ?>
    </ul>
</nav>

</main>

<!-- Modal for adding a new subject -->
<div class="modal fade" id="addsubjectModal" tabindex="-1" role="dialog" aria-labelledby="addSubjectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSubjectModalLabel">Add New Subject</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form for adding a new subject -->
                <form method="POST" action="hanldequery/subjects/add_subject.php">
                    <div class="form-group">
                        <label for="subjectTitle">Subject Title</label>
                        <input type="text" class="form-control" id="subjectTitle" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="classId">Class</label>
                        <select class="form-control" id="classId" name="class_id" required>
                            <?php
                            // Fetch classes from the database
                            $class_query = "SELECT id, title FROM classes";
                            $class_result = $conn->query($class_query);
                            if ($class_result->num_rows > 0) {
                                while ($class_row = $class_result->fetch_assoc()) {
                                    echo "<option value='" . $class_row['id'] . "'>" . $class_row['title'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="teacherId">Teacher</label>
                        <select class="form-control" id="teacherId" name="teacher_id" required>
                            <?php
                            // Fetch teachers from the database
                            $teacher_query = "SELECT id, name FROM teachers";
                            $teacher_result = $conn->query($teacher_query);
                            if ($teacher_result->num_rows > 0) {
                                while ($teacher_row = $teacher_result->fetch_assoc()) {
                                    echo "<option value='" . $teacher_row['id'] . "'>" . $teacher_row['name'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Subject</button>
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
    document.getElementById('addsubjectLink').addEventListener('click', function(event) {
        // Prevent the default behavior of the button (i.e., submitting the form)
        event.preventDefault();
        
        // Get the modal element
        var modal = document.getElementById('addsubjectModal');
        
        // Open the modal
        $(modal).modal('show');
    });
</script>
</body>
</html>
