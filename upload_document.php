<?php
include 'menu/validate_login.php';
include 'config/database.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DFS - Upload Document</title>
    <link rel="icon" type="image/x-icon" href="img/logo.png">
    <link rel="stylesheet" href="css/upload_document.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/c3573e9c36.js" crossorigin="anonymous"></script>  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
    <?php
        include "menu/navbar.php";
    ?>

    <div class="container-fluid p-4" style="background-color:#CBC3E3">
    
        <div>
            <h1 class="p-3 pt-0"><strong>Upload Document</strong></h1>
        </div>

        <?php
        $userQuery = "SELECT User_ID, username FROM users WHERE role != 'Admin'";
        $userStmt = $con->prepare($userQuery);
        $userStmt->execute();
        $users = $userStmt->fetchAll(PDO::FETCH_ASSOC);
        $usersRowCount = $userStmt->rowCount();
        $action = isset($_GET['action']) ? $_GET['action'] : "";

        if ($action == 'upload_success') {
            echo "<div class='alert alert-success m-3'>File was uploaded.</div>";
        }
        if ($action == 'upload_failed') {
            echo "<div class='alert alert-danger m-3'>File upload failed.</div>";
        }
        ?>

        <?php
        if (isset($_POST['submit'])) {

            try {
                $User_ID = $_SESSION['User_ID'];
                $User_Role = $_SESSION['role'];
                $files = $_FILES['files'];

                if($User_Role === "Recipient"){
                    $document_status = "Unverified Document";
                    $Receiver_ID = $_SESSION['User_ID'];
                } else if($User_Role === "Issuer"){
                    $document_status = "Verified Document";
                    //$Receiver_ID = $_SESSION['User_ID'];
                    $Receiver_ID = isset($_POST['user']) ? $_POST['user'] : '';
                }

                $errorMessage = array();

                if(empty($Receiver_ID)) {
                    $errorMessage[] = "Please select a receiver for this file.";
                }
                if(empty($files['name'][0])) {
                    $errorMessage[] = "Please select a file to upload.";
                }

                if(!empty($errorMessage)) {
                    echo "<div class='alert alert-danger m-3'>";
                        foreach ($errorMessage as $displayErrorMessage) {
                            echo $displayErrorMessage . "<br>";
                        }
                    echo "</div>";

                }else {
                    // Loop through uploaded files
                    for ($i = 0; $i < count($files['name']); $i++) {
                        $document_name = $files['name'][$i];
                        $tmp_name = $files['tmp_name'][$i];
                        $upload_path = 'uploads/' . $document_name; // Set your upload path

                        if (move_uploaded_file($tmp_name, $upload_path)) {
                            // Insert document details into the database
                            $query = "INSERT INTO document_details (document, document_type, Sender_ID, Receiver_ID) VALUES (?, ?, ?, ?)";
                            $stmt = $con->prepare($query);
                            $stmt->bindParam(1, $upload_path);
                            $stmt->bindParam(2, $document_status);
                            $stmt->bindParam(3, $User_ID);
                            $stmt->bindParam(4, $Receiver_ID);
                            
                            if ($stmt->execute()) {
                                header("Location: upload_document.php?action=upload_success");
                                exit();
                            }else {
                                header("Location: upload_document.php?action=upload_failed");
                                exit();
                            }
                        }
                    }
                }
            }catch (PDOException $exception) {
                echo "<div class='alert alert-danger m-3'>Unable to place the order.</div>";
            }
        }
        ?>

        <form  class="p-3" action="" method="post" enctype="multipart/form-data">
            <?php
            if ($_SESSION['role'] == "Issuer") {
                echo '<div class="mb-3">
                    <select name="user" id="user" class="form-select">
                        <option value="" selected hidden>Choose a Receiver</option>';
                        for ($i = 0; $i < $usersRowCount; $i++) {
                            $selected = isset($_POST["user"]) && $users[$i]['User_ID'] == $_POST["user"] ? "selected" : "";
                            echo "<option value='{$users[$i]['User_ID']}' $selected>{$users[$i]['username']}</option>";
                        }
                    echo '</select>
                </div>';
            }
            ?>

            <label for="files">Choose files to upload:</label>
            <div class="upload-box" id="uploadBox">
                <i class="fas fa-cloud-upload-alt fa-4x mb-3"></i>
                <p>Drag and drop files here<br>or<br>click to select files</p>
            </div>

            <input type="file" name="files[]" id="files" multiple style="display: none;">
            <button type="submit" name="submit" class="btn btn-white btn-outline-dark btn-lg px-5 my-3" style="background-color: #6F61C0; color: white; border-color: #6F61C0;">Upload</button>
        </form>
    
        <?php
        $searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';
        $query = "SELECT * FROM document_details WHERE Sender_ID = :user_id";
        if (!empty($searchKeyword)) {
            $query .= " AND (document LIKE :keyword OR document_type LIKE :keyword OR upload_date LIKE :keyword OR status LIKE :keyword)";
            $searchKeyword = "%{$searchKeyword}%";
        }
        $query .= " ORDER BY Document_ID ASC";
        $stmt = $con->prepare($query);
        if (!empty($searchKeyword)) {
            $stmt->bindParam(':keyword', $searchKeyword);
        }

        $stmt->bindParam(':user_id', $_SESSION['User_ID']);
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

        <div class="m-3" style="overflow-x:auto;">
            <?php

            if ($num > 0) {
                // Display the table only if there are matching documents
                echo '<table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Document Name</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Upload Date</th>
                            <th>Receiver</th>
                        </tr>
                    </thead>
                    <tbody>';
                
                $i = 1;
                foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $document) {
                    $receiverUsernameQuery = "SELECT username FROM users WHERE User_ID = :receiver_id";
                    $receiverUsernameStmt = $con->prepare($receiverUsernameQuery);
                    $receiverUsernameStmt->bindParam(':receiver_id', $document['Receiver_ID']);
                    $receiverUsernameStmt->execute();
                    $receiverUsername = $receiverUsernameStmt->fetch(PDO::FETCH_ASSOC)['username'];

                    echo "<tr>";
                    echo "<td>$i</td>";
                    echo "<td>" . str_replace('uploads/', '', $document['document']) . "</td>";
                    echo "<td>{$document['document_type']}</td>";
                    echo "<td>{$document['status']}</td>";
                    echo "<td>{$document['upload_date']}</td>";
                    echo "<td>{$receiverUsername}</td>";
                    // Display other table cells
                    echo "</tr>";
                    $i++;
                }

                echo '</tbody></table>';
            }else {
                echo "<div class='alert alert-danger'>No uploaded documents found.</div>";
            }
            ?>
        </div>
        <div class="pb-5"></div>

    </div>
    <?php
        include "menu/footer.php";
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script>
        const uploadBox = document.getElementById("uploadBox");
        const filesInput = document.getElementById("files");

        uploadBox.addEventListener("click", () => {
            filesInput.click();
        });

        filesInput.addEventListener("change", () => {
            if (filesInput.files.length > 0) {
                uploadBox.innerHTML = `
                    <i class="fas fa-check-circle fa-4x mb-3 text-success"></i>
                    <p>${filesInput.files.length} file(s) selected</p>
                `;
            }
        });

        uploadBox.addEventListener("dragover", (e) => {
            e.preventDefault();
            uploadBox.style.backgroundColor = "#e0e0e0";
        });

        uploadBox.addEventListener("dragleave", (e) => {
            e.preventDefault();
            uploadBox.style.backgroundColor = "#f9f9f9";
        });

        uploadBox.addEventListener("drop", (e) => {
            e.preventDefault();
            uploadBox.style.backgroundColor = "#f9f9f9";
            filesInput.files = e.dataTransfer.files;
            
            if (filesInput.files.length > 0) {
                uploadBox.innerHTML = `
                    <i class="fas fa-check-circle fa-4x mb-3 text-success"></i>
                    <p>${filesInput.files.length} file(s) selected</p>
                `;
            }
        });
    </script>
</body>
</html>
