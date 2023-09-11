<?php
include 'menu/validate_login.php';
include 'config/database.php';

if (isset($_POST['generate_link'])) {
    if (isset($_POST['selected_files']) && is_array($_POST['selected_files'])) {
        $selectedDocumentIDs = $_POST['selected_files'];
        $zipFileName = 'shared_documents_' . date('Ymd') . '.zip';

        // Create a new ZIP archive
        $zip = new ZipArchive();
        if ($zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            // Loop through the selected document IDs and add them to the ZIP archive
            foreach ($selectedDocumentIDs as $documentID) {
                // Fetch the document file path based on the $documentID and add it to the ZIP
                $query = "SELECT document FROM document_details WHERE Document_ID = :documentID";
                $stmt = $con->prepare($query);
                $stmt->bindParam(':documentID', $documentID);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($result) {
                    $documentPath = $result['document'];
                    $zip->addFile($documentPath, basename($documentPath));
                }
            }
            $zip->close();

            // Provide the ZIP file for download
            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename="' . $zipFileName . '"');
            readfile($zipFileName);
            // Delete the ZIP file after download
            unlink($zipFileName);
            exit();

        }else {
            echo 'Failed to create the ZIP file.';
        }
    }else {
        echo 'No documents selected for sharing.';
    }
}else {
    echo 'Invalid request.';
}
?>
