<?php
include 'menu/validate_login.php';
include 'config/database.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Documents</title>
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
            <h1 class="p-3 pt-0"><strong>View and Download Documents</strong></h1>
        </div>

        <?php
        $searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';
        $query = "SELECT * FROM document_details WHERE User_ID = :user_id";
        if (!empty($searchKeyword)) {
            $query .= " AND (document LIKE :keyword OR document_type LIKE :keyword)";
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

        <div class="m-3">
            <?php
            if ($num > 0) {
                // Display the table only if there are matching documents
                echo '<table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Document Name</th>
                            <th>Type</th>
                            <th>Download</th>
                        </tr>
                    </thead>
                    <tbody>';
                
                $i = 1;
                foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $document) {
                    echo "<tr>";
                    echo "<td>$i</td>";
                    echo "<td>" . str_replace('uploads/', '', $document['document']) . "</td>";
                    echo "<td>{$document['document_type']}</td>";
                    echo "<td><a href='{$document['document']}' download>Download</a></td>";
                    // Display other table cells
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
    <?php
        include "menu/footer.php";
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <!-- No script modification is needed here -->
</body>
</html>
