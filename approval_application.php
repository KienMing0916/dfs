<?php
include 'config/database.php';
try {     
    $id=isset($_GET['id']) ? $_GET['id'] :  die('ERROR: Record ID not found.');
    $status=isset($_GET['status']) ? $_GET['status'] :  die('ERROR: status not found.');
    $user_id=isset($_GET['user_id']) ? $_GET['user_id'] :  die('ERROR: status not found.');

    if($status == 'Reject'){
        $updateStatusQuery = "UPDATE business_proof_documents SET status = ? WHERE  License_ID = ?";
        $updateStmt = $con->prepare($updateStatusQuery);
        $updateStmt->bindParam(1, $status);
        $updateStmt->bindParam(2, $id);

        if ($updateStmt->execute()){
            header('Location: admin.php?action=rejected');
        }else{
            header('Location: admin.php?action=failed');
        }
    }

    if($status == 'Approve'){
        $updateStatusQuery = "UPDATE business_proof_documents SET status = ? WHERE  License_ID = ?";
        $updateStmt = $con->prepare($updateStatusQuery);
        $updateStmt->bindParam(1, $status);
        $updateStmt->bindParam(2, $id);

        $updateRoleQuery = "UPDATE users SET role = 'Issuer' WHERE  User_ID = ?";
        $updateRoleStmt = $con->prepare($updateRoleQuery);
        $updateRoleStmt->bindParam(1, $user_id);

        if ($updateStmt->execute() && $updateRoleStmt->execute()) {
            header('Location: admin.php?action=approved');
        }else{
            header('Location: admin.php?action=failed');
        }
    }
}
catch(PDOException $exception){
    die('ERROR: ' . $exception->getMessage());
}
?>

