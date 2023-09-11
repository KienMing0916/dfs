<?php
include 'menu/validate_login.php';
include 'config/database.php';
if ($_SESSION['role'] == 'Recipient') {
    echo '<script>alert("You are a Recipient and cannot access this feature.");</script>';
    echo '<script>window.location.href = "' . $_SERVER['HTTP_REFERER'] . '";</script>';
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DFS - Void Document</title>
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
            <h1 class="p-3 pt-0"><strong>Void Document</strong></h1>
        </div>

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

        <?php
        $action = isset($_GET['action']) ? $_GET['action'] : "";

        if ($action == 'updated') {
            echo "<div class='alert alert-success m-3'>Document status updated successfully.</div>";
        }
        if ($action == 'failed') {
            echo "<div class='alert alert-danger m-3'>Failed to update document status.</div>";
        }
        ?>

        <div class="m-3" style="overflow-x:auto;">
            <?php
            if ($num > 0) {
                echo '<table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Document Name</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Upload Date</th>
                            <th>Receiver</th>
                            <th class="col-2">Action</th>
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
                    echo "<td>";
                        echo "<a href='#' onclick=\"updateStatus({$document['Document_ID']}, 'Normal');\" class='btn btn-success m-r-1em text-white mx-2' style='width: 80px;'>Normal</a>";
                        echo "<a href='#' onclick=\"updateStatus({$document['Document_ID']}, 'Void');\" class='btn btn-danger m-r-1em mx-2' style='width: 80px;'>Void</a>";
                    echo "</td>";
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
    <script type='text/javascript'>
        function updateStatus(Document_ID, status) {
        if (confirm(`Are you sure you want to mark this document as ${status.charAt(0).toUpperCase() + status.slice(1)}?`)) {
            window.location = `update_status.php?id=${Document_ID}&status=${status}`;
        }
    }
    </script>
</body>
</html>
