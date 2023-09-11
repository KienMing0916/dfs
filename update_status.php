<?php
include 'config/database.php';
try {     
    $id=isset($_GET['id']) ? $_GET['id'] :  die('ERROR: Record ID not found.');
    $status=isset($_GET['status']) ? $_GET['status'] :  die('ERROR: status not found.');
    // update query
    $updateStatusQuery = "UPDATE document_details SET status = ? WHERE  Document_ID = ?";
    $updateStmt = $con->prepare($updateStatusQuery);
    $updateStmt->bindParam(1, $status);
    $updateStmt->bindParam(2, $id);

    if($updateStmt->execute()){
        header('Location: void_document.php?action=updated');
    }else{
        header('Location: void_document.php?action=failed');
    }
}
catch(PDOException $exception){
    die('ERROR: ' . $exception->getMessage());
}
?>

