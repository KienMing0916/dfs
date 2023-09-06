<?php
include 'menu/validate_login.php';

if (!isset($_SESSION['User_ID'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DFS - My Profile</title>
    <link rel="icon" type="image/x-icon" href="img/logo.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/register.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://kit.fontawesome.com/c3573e9c36.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body>
    <?php
    include "menu/navbar.php";
    ?>

    <div class="container-fluid p-4" style="background-color:#CBC3E3">

        <div class="page-header">
            <h1 class="p-3 pt-0"><strong>My Profile</strong></h1>
        </div>

        <?php
        include 'config/database.php';
        $editMode = false;

        // Fetch user data
        $query = "SELECT * FROM users WHERE User_ID = ?";
        $stmt = $con->prepare($query);
        $stmt->bindParam(1, $_SESSION['User_ID']);
        $stmt->execute();
        $userProfile = $stmt->fetch(PDO::FETCH_ASSOC);

        if (isset($_POST['identityAuthentication'])) {
            header("Location: identity_authentication.php");
            exit();
        }
        ?>

        <?php
        if (isset($_POST['save_button'])) {
            try {
                $username = $_POST['username'];
                $phone_number = $_POST['phone_number'];
                $email = $_POST['email'];
                $linkedEmail1 = $_POST['linked_email_1'];
                $linkedEmail2 = $_POST['linked_email_2'];
                $bio = $_POST['bio'];

                // Update user data
                $updateQuery = "UPDATE users SET username=:username, phone_number=:phone_number, email=:email, linked_email_1=:linked_email_1, linked_email_2=:linked_email_2, bio=:bio WHERE User_ID=:id";
                $updateStmt = $con->prepare($updateQuery);

                include 'menu/validate_function.php';
                $errorMessage = validateProfile($username, $phone_number, $email);

                if(!empty($errorMessage)) {
                    echo "<div class='alert alert-danger m-3'>";
                        foreach ($errorMessage as $displayErrorMessage) {
                            echo $displayErrorMessage . "<br>";
                        }
                    echo "</div>";
                }else {
                    $updateStmt->bindParam(':username', $username);
                    $updateStmt->bindParam(':phone_number', $phone_number);
                    $updateStmt->bindParam(':email', $email);
                    $updateStmt->bindParam(':linked_email_1', $linkedEmail1);
                    $updateStmt->bindParam(':linked_email_2', $linkedEmail2);
                    $updateStmt->bindParam(':bio', $bio);
                    $updateStmt->bindParam(':id', $_SESSION['User_ID']);
                    
                    // Execute the query
                    if ($updateStmt->execute()) {
                        echo "<div class='alert alert-success m-3'>Record updated successfully.</div>";
                        $stmt->execute();
                        $userProfile = $stmt->fetch(PDO::FETCH_ASSOC);
                    } else {
                        echo "<div class='alert alert-danger m-3'>Unable to update record. Please try again.</div>";
                    }
                }

            } catch (PDOException $exception) {
                echo "<div class='alert alert-danger m-3'>ERROR: " . $exception->getMessage() . "</div>";
                die('ERROR: ' . $exception->getMessage());
            }
        }

        if (isset($_POST['upload_profile'])) {
            // Handle image upload
            $uploadDir = 'profile/'; // Update the directory path as per your file structure
            $uploadedFile = $_FILES['profile_image'];
        
            if ($uploadedFile['error'] === UPLOAD_ERR_OK) {
                $uniqueFilename = uniqid() . '_' . $uploadedFile['name'];
                $targetPath = $uploadDir . $uniqueFilename;
        
                if (move_uploaded_file($uploadedFile['tmp_name'], $targetPath)) {
                    // Update the user's profile_image column in the database
                    $updateQuery = "UPDATE users SET profile_image = ? WHERE User_ID = ?";
                    $profileStmt = $con->prepare($updateQuery);
                    $profileStmt->bindParam(1, $targetPath);
                    $profileStmt->bindParam(2, $_SESSION['User_ID']);
        
                    if ($profileStmt->execute()) {
                        echo "<div class='alert alert-success m-3'>Profile image updated successfully.</div>";
                        if ($userProfile['profile_image'] !== 'No profile') {
                            if (file_exists($userProfile['profile_image'])) {
                                unlink($userProfile['profile_image']);
                            }
                        }
                        $stmt->execute();
                        $userProfile = $stmt->fetch(PDO::FETCH_ASSOC);
                    } else {
                        echo "<div class='alert alert-danger m-3'>Unable to update profile image. Please try again.</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger m-3'>Error moving the uploaded file.</div>";
                }
            } else {
                echo "<div class='alert alert-danger m-3'>Upload error: " . $uploadedFile['error'] . "</div>";
            }
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data" class="m-3">
            <div class="row">
                <div class="col-md-5 <?php echo $editMode ? 'order-md-1' : 'order-md-2'; ?> d-flex align-items-center justify-content-center flex-column">
                    <div class="image-container text-center d-flex flex-column align-items-center">
                        <?php
                        if (is_array($userProfile) && isset($userProfile['profile_image'])) {
                            $profileImage = ($userProfile['profile_image'] !== "No profile") ? $userProfile['profile_image'] : 'profile/defaultprofile.jpg';
                        } else {
                            // Handle the case where $userProfile is not an array or 'profile_image' is not set.
                            $profileImage = 'profile/defaultprofile.jpg';
                        }
                        ?>
                        <img src="<?php echo $profileImage; ?>" alt="Profile Image" class="img-fluid rounded-circle" height="250" width="250">
                        <label for="profile_image_input" class="btn btn-primary mt-3 text-center" id="edit_button"><i class="far fa-edit"></i> Edit</label>
                        <input type="file" name="profile_image" style="display: none;" accept="image/*" id="profile_image_input">
                        <input type="submit" class="btn btn-primary mt-3 text-center" name="upload_profile" style="display: none;" id="upload_button">
                    </div>
                </div>

                <div class="col-md-7 <?php echo $editMode ? 'order-md-2' : 'order-md-1'; ?>">
                    <div class="row mb-1">
                        <div class="col-md-10">
                            <label for="name" class="col-form-label">Username:</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?php echo isset($userProfile['username']) ? $userProfile['username'] : ''; ?>" <?php echo $editMode ? '' : 'readonly'; ?>>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-md-10">
                            <label for="hpno" class="col-form-label">Phone Number:</label>
                            <input type="tel" class="form-control" id="phone_number" name="phone_number" value="<?php echo isset($userProfile['phone_number']) ? $userProfile['phone_number'] : ''; ?>" <?php echo $editMode ? '' : 'readonly'; ?>>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-10">
                            <label for="email" class="col-form-label">Email:</label>
                            <input type="email" class="form-control mt-2" id="email" name="email" value="<?php echo isset($userProfile['email']) ? $userProfile['email'] : ''; ?>" <?php echo $editMode ? '' : 'readonly'; ?>>
                            <input type="email" class="form-control mt-2" id="linked_email_1" name="linked_email_1" value="<?php echo isset($userProfile['linked_email_1']) ? $userProfile['linked_email_1'] : ''; ?>" <?php echo $editMode ? '' : 'readonly'; ?>>
                            <input type="email" class="form-control mt-2" id="linked_email_2" name="linked_email_2" value="<?php echo isset($userProfile['linked_email_2']) ? $userProfile['linked_email_2'] : ''; ?>" <?php echo $editMode ? '' : 'readonly'; ?>>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-10">
                            <label for="intro" class="col-form-label">Intro:</label>
                            <textarea class="form-control" id="bio" name="bio" rows="5" <?php echo $editMode ? '' : 'readonly'; ?>><?php echo isset($userProfile['bio']) ? $userProfile['bio'] : ''; ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center my-5">
                <button type="button" id="manageAccountButton" class="btn me-2" style="background-color: #6F61C0; color: white;" onclick="toggleEditMode()">Manage Account</button>
                <button type="submit" class="btn btn-primary me-2" id="saveButton" name="save_button" style="display: none;">Save</button>
                <button type="button" class="btn btn-danger me-2" id="cancelButton" style="display: none;" onclick="cancelEdit()">Cancel</button>
                <button type="submit" class="btn me-2" style="background-color: #3C28AC; color: white;" id="authButton" name="identityAuthentication" onclick="toggleIdentityAuth()">Identity Authentication</button>
            </div>
        </form>
    </div>

    <?php
    include "menu/footer.php";
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script>
        var editMode = false;

        function toggleEditMode() {
            editMode = true;
            showButtons(true);
        }

        function cancelEdit() {
            editMode = false;
            showButtons(false);
        }

        function toggleIdentityAuth() {
            // nothing to do
        }

        function showButtons(show) {
            var saveButton = document.getElementById("saveButton");
            var cancelButton = document.getElementById("cancelButton");
            var manageAccountButton = document.getElementById("manageAccountButton");
            var authButton = document.getElementById("authButton");

            if (show) {
                saveButton.style.display = "block";
                cancelButton.style.display = "block";
                manageAccountButton.style.display = "none";
                authButton.style.display = "none";
                var fields = document.querySelectorAll('input[readonly], textarea[readonly]');
                fields.forEach(function (field) {
                    field.readOnly = false;
                });
            } else {
                saveButton.style.display = "none";
                cancelButton.style.display = "none";
                manageAccountButton.style.display = "block";
                authButton.style.display = "block";
                var fields = document.querySelectorAll('input:not([type="button"]), textarea');
                fields.forEach(function (field) {
                    field.readOnly = true;
                });
            }
        }

        const profileImageInput = document.getElementById("profile_image_input");
        const editButton = document.getElementById("edit_button");
        const uploadButton = document.getElementById("upload_button");

        profileImageInput.addEventListener("change", function () {
        if (profileImageInput.files.length > 0) {
            editButton.style.display = "none";
            uploadButton.style.display = "block";
        } else {
            editButton.style.display = "block";
            uploadButton.style.display = "none";
        }
        });

    </script>
</body>
</html>
