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
include("php/header.php");
?>

                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">Dashboard</h1>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <div class="btn-group mr-2">
                                <button class="btn btn-sm btn-outline-secondary">Share</button>
                                <button class="btn btn-sm btn-outline-secondary">Export</button>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="card mb-4 shadow">
                                <div class="card-body">
                                    <h5 class="card-title">Student</h5>
                                    <p class="card-text">Manage student records.</p>
                                    <a href="student.php" class="btn btn-primary">View</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card mb-4 shadow">
                                <div class="card-body">
                                    <h5 class="card-title">Classes</h5>
                                    <p class="card-text">Manage class information.</p>
                                    <a href="classes.php" class="btn btn-primary">View</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card mb-4 shadow">
                                <div class="card-body">
                                    <h5 class="card-title">Subjects</h5>
                                    <p class="card-text">Manage subjects.</p>
                                    <a href="subjects.php" class="btn btn-primary">View</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card mb-4 shadow">
                                <div class="card-body">
                                    <h5 class="card-title">Teachers</h5>
                                    <p class="card-text">Manage teacher information.</p>
                                    <a href="teachers.php" class="btn btn-primary">View</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card mb-4 shadow">
                                <div class="card-body">
                                    <h5 class="card-title">Time Tables</h5>
                                    <p class="card-text">Manage class schedules.</p>
                                    <a href="time-table.php" class="btn btn-primary">View</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <br><br><br>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <footer class="text-center mt-4">
        <div class="container">
            <p>Online Allied school management System | Developed By: Aqib Hameed</p>
        </div>
    </footer>

    

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
