<?php
include 'menu/validate_login.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DFS - Share Documents</title>
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
            <h1 class="p-3 pt-0"><strong>Share Documents</strong></h1>
        </div>

        <form class="p-3" action="generate_link.php" method="post">
            <?php
            $targetDirectory = "uploads/";
            $uploadedFiles = scandir($targetDirectory);

            foreach ($uploadedFiles as $file) {
                if ($file !== '.' && $file !== '..') {
                    echo '<label><input type="checkbox" name="selected_files[]" value="' . $file . '"> ' . $file . '</label><br>';
                }
            }
            ?>
            <button type="submit" name="generate_link" class="btn btn-white btn-outline-dark btn-lg px-5 my-3" style="background-color: #6F61C0; color: white; border-color: #6F61C0;">Generate Link</button>
        </form>

        <div class="p-5">
        </div>
    </div>
    <?php
        include "menu/footer.php";
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <!-- No script modification is needed here -->
</body>
</html>
