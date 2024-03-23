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

// Define $current_page and $records_per_page
$current_page = isset($_GET['page']) ? $_GET['page'] : 1; // Set default page to 1 if not provided
$records_per_page = 5; // Change this to your desired number of records per page

// Fetch timetable records from the database
$sql = "SELECT timetable.id, classes.title AS class_title, subjects.title AS subject_title, teachers.name AS teacher_name, timetable.day_of_week, timetable.start_time, timetable.end_time FROM timetable LEFT JOIN classes ON timetable.class_id = classes.id LEFT JOIN subjects ON timetable.subject_id = subjects.id LEFT JOIN teachers ON timetable.teacher_id = teachers.id ORDER BY timetable.day_of_week, timetable.start_time;
";

$result = $conn->query($sql);

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
        <h1 class="h2">Timetable</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                <button class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#addTimetableModal">Add New Timetable</button>
            </div>
        </div>
    </div>

    <!-- Display timetable records -->
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Class Title</th>
                    <th>Subject Title</th>
                    <th>Teacher Name</th>
                    <th>Day</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Edit/Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Check if there are any timetable records
                if ($result->num_rows > 0) {
                    $i = 1; // Start numbering from 1
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $i . "</td>";
                        echo "<td>" . $row['class_title'] . "</td>";
                        echo "<td>" . $row['subject_title'] . "</td>";
                        echo "<td>" . $row['teacher_name'] . "</td>";
                        echo "<td>" . $row['day_of_week'] . "</td>";
                        echo "<td>" . $row['start_time'] . "</td>";
                        echo "<td>" . $row['end_time'] . "</td>";
                        echo "<td>";
                        echo "<a href='hanldequery/timetable/edit_timetable.php?id=" . $row['id'] . "' class='btn btn-primary'>Edit</a> ";
                        echo "<a href='hanldequery/timetable/delete_timetable.php?id=" . $row['id'] . "' class='btn btn-danger'>Delete</a>";
                        echo "</td>";
                        echo "</tr>";
                        $i++;
                    }
                } else {
                    echo "<tr><td colspan='8'>No timetable records found.</td></tr>";
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
                echo "<li class='page-item'><a class='page-link' href='time-table.php?page=$prev_page'>Previous</a></li>";
            } else {
                echo "<li class='page-item disabled'><span class='page-link'>Previous</span></li>";
            }

            // Next page link
            $next_page = $current_page + 1;
            $sql_count = "SELECT COUNT(*) AS count FROM timetable"; // Change 'teachers' to 'timetable'
            $result_count = $conn->query($sql_count);
            $row_count = $result_count->fetch_assoc();
            $total_records = $row_count['count'];
            $total_pages = ceil($total_records / $records_per_page);
            if ($next_page <= $total_pages) { // Add missing open curly brace here
                echo "<li class='page-item'><a class='page-link' href='time-table.php?page=$next_page'>Next</a></li>";
            } else {
                echo "<li class='page-item disabled'><span class='page-link'>Next</span></li>";
            }
                ?>
            </ul>
        </nav>
    </main>
    
    <!-- Modal for adding a new timetable -->
<div class="modal fade" id="addTimetableModal" tabindex="-1" role="dialog" aria-labelledby="addTimetableModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTimetableModalLabel">Add New Timetable</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form for adding a new timetable -->
                <form method="POST" action="hanldequery/timetable/add-timetable.php">
                    <div class="form-group">
                        <label for="class">Class</label>
                        <select class="form-control" id="class" name="class_id" required>
                            <?php
                            // Fetch classes from the database
                            $class_query = "SELECT * FROM classes";
                            $class_result = $conn->query($class_query);
                            while ($class_row = $class_result->fetch_assoc()) {
                                echo "<option value='" . $class_row['id'] . "'>" . $class_row['title'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="teacher">Teacher</label>
                        <select class="form-control" id="teacher" name="teacher_id" required>
                            <?php
                            // Fetch teachers from the database
                            $teacher_query = "SELECT * FROM teachers";
                            $teacher_result = $conn->query($teacher_query);
                            while ($teacher_row = $teacher_result->fetch_assoc()) {
                                echo "<option value='" . $teacher_row['id'] . "'>" . $teacher_row['name'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <select class="form-control" id="subject" name="subject_id" required>
                            <?php
                            // Fetch subjects from the database
                            $subject_query = "SELECT * FROM subjects";
                            $subject_result = $conn->query($subject_query);
                            while ($subject_row = $subject_result->fetch_assoc()) {
                                echo "<option value='" . $subject_row['id'] . "'>" . $subject_row['title'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="day">Day of Week</label>
                        <input type="text" class="form-control" id="day" name="day_of_week" required>
                    </div>
                    <div class="form-group">
                        <label for="start">Start Time</label>
                        <input type="time" class="form-control" id="start" name="start_time" required>
                    </div>
                    <div class="form-group">
                        <label for="end">End Time</label>
                        <input type="time" class="form-control" id="end" name="end_time" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Timetable</button>
                </form>
            </div>
        </div>
    </div>
</div>

    <!-- Footer -->
    <footer class="text-center mt-4">
        <div class="container">
            <p>Online Allied School Management System | Developed By: Aqib Hameed</p>
        </div>
    </footer>
    
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>
    
    <script>
        // Add an event listener to the button triggering the modal
        document.getElementById('addTimetableLink').addEventListener('click', function(event) {
            // Prevent the default behavior of the button (i.e., submitting the form)
            event.preventDefault();
            
            // Get the modal element
            var modal = document.getElementById('addTimetableModal');
            
            // Open the modal
            $(modal).modal('show');
        });
    </script>
    </body>
    </html>
    