<?php
include 'menu/validate_login.php';
include 'config/database.php'; 

if (isset($_POST['submit'])) {
    $User_ID = $_SESSION['User_ID'];
    $User_Role = $_SESSION['role'];
    $files = $_FILES['files'];

    if($User_Role === "Recipient"){
        $document_status = "Unverified Document";
    } else if($User_Role === "Issuer"){
        $document_status = "Verified Document";
    }

    // Loop through uploaded files
    for ($i = 0; $i < count($files['name']); $i++) {
        $document_name = $files['name'][$i];
        $tmp_name = $files['tmp_name'][$i];
        $upload_path = 'uploads/' . $document_name; // Set your upload path
    
        if (move_uploaded_file($tmp_name, $upload_path)) {
            // Insert document details into the database
            $query = "INSERT INTO document_details (document, document_type, User_ID) VALUES (?, ?, ?)";
            $stmt = $con->prepare($query);
            $stmt->bindParam(1, $upload_path);
            $stmt->bindParam(2, $document_status);
            $stmt->bindParam(3, $User_ID);
            
            if ($stmt->execute()) {
                header("Location: upload_document.php?action=upload_success");
                exit();
            }else {
                header("Location: upload_document.php?action=upload_failed");
                exit();
            }
        } else {
            header("Location: upload_document.php?action=no_file");
            exit();
        }
    }
}
?>
