<?php
include 'menu/validate_login.php';
include 'config/database.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DFS - Issuer Role Application List</title>
    <link rel="icon" type="image/x-icon" href="img/logo.png">
    <link rel="stylesheet" href="css/upload_document.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/c3573e9c36.js" crossorigin="anonymous"></script>  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar navbar-expand-lg m-0 navbar-dark" style="background-color: #1C2331;">
        <div class="navbar-brand ms-2">
            <img src="img/logo.png" alt="logo" width="50" height="40" class="ms-3">
            <span style="vertical-align: middle; color: #fff;"><strong>DFS</strong></span>
        </div>
        <button class="navbar-toggler me-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end m-0 pe-3" id="navbarNav">
            <ul class="navbar-nav ps-3">
                <li class="nav-item p-1">
                <a class="dropdown-item text-white me-3" href="?logout=true"><strong>Log Out</strong></a>

                </li>
            </ul>
        </div>
   </nav>

    <div class="container-fluid p-4" style="background-color:#CBC3E3">
    
        <div>
            <h1 class="p-3 pt-0"><strong>Issuer Role Application List</strong></h1>
        </div>

        <?php
        $searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';
        $query = "SELECT * FROM business_proof_documents WHERE status = 'Pending'";
        if (!empty($searchKeyword)) {
            $query .= " AND (document LIKE :keyword OR upload_date LIKE :keyword)";
            $searchKeyword = "%{$searchKeyword}%";
        }
        $query .= " ORDER BY License_ID ASC";
        $stmt = $con->prepare($query);
        if (!empty($searchKeyword)) {
            $stmt->bindParam(':keyword', $searchKeyword);
        }

        $stmt->execute();
        $num = $stmt->rowCount();

        echo '<div class="p-3 pb-1">
            <form method="GET" action="">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="search" placeholder="Search document..." value="' . str_replace('%', '', $searchKeyword) . '">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </form>
        </div>';
        ?>

        <?php
        $action = isset($_GET['action']) ? $_GET['action'] : "";

        if ($action == 'approved') {
            echo "<div class='alert alert-success m-3'>The application has been approved and the role has been successfully updated.</div>";
        }
        if ($action == 'rejected') {
            echo "<div class='alert alert-success m-3'>The application has been rejected.</div>";
        }
        if ($action == 'failed') {
            echo "<div class='alert alert-danger m-3'>Something went wrong. Failed to correction application.</div>";
        }
        ?>

        <div class="m-3" style="overflow-x:auto;">
            <?php
            if ($num > 0) {
                // Display the table only if there are matching documents
                echo '<table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Proof Document Name</th>
                            <th>Username</th>
                            <th>Upload Date</th>
                            <th>Download Link</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>';
                
                $i = 1;
                foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $prooflicense) {
                    $senderUsernameQuery = "SELECT username FROM users WHERE User_ID = :user_id";
                    $senderUsernameStmt = $con->prepare($senderUsernameQuery);
                    $senderUsernameStmt->bindParam(':user_id', $prooflicense['User_ID']);
                    $senderUsernameStmt->execute();
                    $senderUsername = $senderUsernameStmt->fetch(PDO::FETCH_ASSOC)['username'];

                    echo "<tr>";
                    echo "<td>$i</td>";
                    echo "<td>" . str_replace('uploads_license/', '', $prooflicense['document']) . "</td>";
                    echo "<td>{$senderUsername}</td>";
                    echo "<td>{$prooflicense['upload_date']}</td>";
                    echo "<td><a href='{$prooflicense['document']}' download>Download</a></td>";
                    echo "<td>{$prooflicense['status']}</td>";
                    echo "<td>";
                        echo "<a href='#' onclick=\"approvalApAplication({$prooflicense['User_ID']}, {$prooflicense['License_ID']}, 'Approve');\" class='btn btn-success m-r-1em text-white mx-2' style='width: 100px;'>Approve</a>";
                        echo "<a href='#' onclick=\"approvalApAplication({$prooflicense['User_ID']}, {$prooflicense['License_ID']}, 'Reject');\" class='btn btn-danger m-r-1em mx-2' style='width: 100px;'>Reject</a>";
                    echo "</td>";
                    echo "</tr>";
                    $i++;
                }

                echo '</tbody></table>';
            }else {
                echo "<div class='alert alert-danger'>No documents found matching your search criteria.</div>";
            }
            ?>
        </div>
        <div class="pb-5"></div>

    </div>

    <footer class="text-center text-lg-start text-white" style="background-color: #1C2331">
        <!-- section social media -->
        <section class="d-flex justify-content-between p-4" style="background-color: #6351CE">
            <div class="me-5">
                <span>Get connected with us on social medias:</span>
            </div>
            <div>
                <a href="#" class="text-white me-4"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="text-white me-4"><i class="fab fa-twitter"></i></a>
                <a href="#" class="text-white me-4"><i class="fab fa-instagram"></i></a>
                <a href="#" class="text-white me-4"><i class="fab fa-github"></i></a>
            </div>
        </section>
        <!-- Section links  -->
        <section>
            <div class="container text-center text-md-start mt-5">
                <div class="row mt-3">
                    <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                        <h6 class="text-uppercase fw-bold">Document Filing System (DFS)</h6>
                        <hr class="mb-4 mt-0 d-inline-block mx-auto" style="width: 60px; background-color: #7c4dff; height: 2px"/>
                        <p>Our document filing system is a structured method for organizing, storing, and managing various types of documents, files, and information within an organization.</p>
                    </div>

                    <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4"></div>

                    <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4"></div>

                    <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                        <h6 class="text-uppercase fw-bold">Contact</h6>
                        <hr class="mb-4 mt-0 d-inline-block mx-auto" style="width: 60px; background-color: #7c4dff; height: 2px"/>
                        <p><i class="fas fa-home mr-3"></i> Malaysia, New Era University College</p>
                        <p><i class="fas fa-envelope mr-3"></i> tankienming0916@e.newera.edu.my</p>
                        <p><i class="fas fa-phone mr-3"></i> + 01169611730</p>
                    </div>
                </div>
            </div>
        </section>

        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">© 2023 Copyright DFS</div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script type='text/javascript'>
        function approvalApAplication(User_ID, License_ID, status) {
        if (confirm(`Are you sure you want to mark this document as ${status.charAt(0).toUpperCase() + status.slice(1)}?`)) {
            window.location = `approval_application.php?user_id=${User_ID}&id=${License_ID}&status=${status}`;
        }
    }
    </script>
</body>
</html>
