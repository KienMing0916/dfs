<?php
include 'menu/validate_login.php';
include 'config/database.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DFS - Identity Authentication</title>
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

    <?php
    if (isset($_POST['submit'])) {
        $files = $_FILES['files'];
        $User_ID = $_SESSION['User_ID'];

        // Loop through uploaded files
        for ($i = 0; $i < count($files['name']); $i++) {
            $document_name = $files['name'][$i];
            $tmp_name = $files['tmp_name'][$i];
            $upload_path = 'uploads_license/' . $document_name;
        
            if (move_uploaded_file($tmp_name, $upload_path)) {
                // Insert document details into the database
                $query = "INSERT INTO business_proof_documents (document, User_ID) VALUES (?, ?)";
                $stmt = $con->prepare($query);
                $stmt->bindParam(1, $upload_path);
                $stmt->bindParam(2, $User_ID);
                
                if ($stmt->execute()) {
                    header("Location: identity_authentication.php?action=upload_success");
                    exit();
                }else {
                    header("Location: identity_authentication.php?action=upload_failed");
                    exit();
                }
            } else {
                header("Location: identity_authentication.php?action=no_file");
                exit();
            }
        }
    }
    ?>

    <div class="container-fluid p-4" style="background-color:#CBC3E3">
    
        <div>
            <h1 class="p-3 pt-0"><strong>Become a Verified Issuer</strong></h1>
            <h5 class="p-3 pt-0">Current Account Identity: <?php echo $_SESSION['role']; ?></h5>
            <p class="p-3 pt-0">As a verified issuer in our document filing system, your identity and authority will be verified, instilling confidence and trust in users who rely on the system. This verification ensures that the documents issued by you are authentic and legitimate.</p>
        </div>

        <?php
        $action = isset($_GET['action']) ? $_GET['action'] : "";

        if ($action == 'upload_success') {
            echo "<div class='alert alert-success m-3'>File was uploaded, please wait patiently for the result.</div>";
        }
        if ($action == 'upload_failed') {
            echo "<div class='alert alert-danger m-3'>File upload failed.</div>";
        }
        if ($action == 'no_file') {
            echo "<div class='alert alert-danger m-3'>Please select the file you want to upload.</div>";
        }
        ?>

        <form  class="p-3" action="" method="post" enctype="multipart/form-data">
            <label for="files">Upload your business proof documents:</label>
            <div class="upload-box" id="uploadBox">
                <i class="fas fa-cloud-upload-alt fa-4x mb-3"></i>
                <p>Drag and drop files here<br>or<br>click to select files</p>
            </div>
            <input type="file" name="files[]" id="files" multiple style="display: none;">
            <button type="submit" name="submit" class="btn btn-white btn-outline-dark btn-lg px-5 my-3" style="background-color: #6F61C0; color: white; border-color: #6F61C0;">Upload</button>
        </form>

        <div class="mt-3">
            <h1 class="p-3 pt-0"><strong>How does it work? </strong></h1>
            <p class="p-3 pt-0">Upload your documents such as business licenses, certifications, or identification documents. Don’t worry, your documents are secure.</p>
        </div>

        <div class="row" style="border-bottom: 3px solid black;">
            <div class="col-md-4">
                <div class="text-center">
                    <img src="img/uploadimg.png" alt="Image 1" class="img-fluid p-2" width='200' height='200'>
                    <p><strong>Step 1:<br>Upload your documents</strong></p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <img src="img/verifyimg.png" alt="Image 2" class="img-fluid p-2" width='200' height='200'>
                    <p><strong>Step 2:<br>Our system verify them for authenticity</strong></p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <img src="img/verifiedimg.png" alt="Image 3" class="img-fluid p-2" width='200' height='200'>
                    <p><strong>Step 3:<br>You are verified!!</strong></p>
                </div>
            </div>
        </div>

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
