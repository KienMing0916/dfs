<?php
$targetDirectory = "uploads/";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["selected_files"])) {
    $selectedFiles = $_POST["selected_files"];

    if (!empty($selectedFiles)) {
        $zip = new ZipArchive();
        $zipFileName = "shared_files.zip";

        if ($zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
            foreach ($selectedFiles as $file) {
                $filePath = $targetDirectory . $file;
                if (file_exists($filePath)) {
                    $zip->addFile($filePath, $file);
                }
            }
            $zip->close();

            // Move the generated ZIP file to a public directory
            $publicZipPath = "public/" . $zipFileName;
            rename($zipFileName, $publicZipPath);

            // Provide a download link for the generated ZIP file
            echo "Generated link: <a href='$publicZipPath' download>Download ZIP</a>";
        } else {
            echo "Error creating the ZIP file.";
        }
    } else {
        echo "No files selected.";
    }
}
?>
