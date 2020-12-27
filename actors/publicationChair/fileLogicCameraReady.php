<?php
// connect to the database
$conn = mysqli_connect('localhost', 'root', '', 'webcomsdb');

// $sql = "SELECT name,size,downloads,full_name,university,contact_details,other_links FROM fileuploadtable";
$sql = "SELECT crc_id,name,size,downloads,title,abstract FROM camerareadycopypaper";

$result = mysqli_query($conn, $sql);

$files = mysqli_fetch_all($result, MYSQLI_ASSOC);
// Uploads files
if (isset($_POST['save'])) { // if save button on the form is clicked
    // name of the uploaded file
    $filename = $_FILES['myfile']['name'];

    // destination of the file on the server
    $destination = '../../cameraReadyUploads/' . $filename;

    // get the file extension
    $extension = pathinfo($filename, PATHINFO_EXTENSION);

    // the physical file on a temporary uploads directory on the server
    $file = $_FILES['myfile']['tmp_name'];
    $size = $_FILES['myfile']['size'];

//Added others
    // $full_name =$_POST['full_name'];
    // $university = $_POST['university'];
    // $contact_details = $_POST['contact_details'];
    // $other_links = $_POST['other_links'];	



    if (!in_array($extension, ['pdf'])) {
        echo '<script type="text/javascript"> alert("You file extension must be .pdf") </script>';
    } elseif ($_FILES['myfile']['size'] > 1000000) { // file shouldn't be larger than 1MB
        // echo "File is large than 1MB !";
        echo '<script type="text/javascript"> alert("file size larger than 1 MB.. Try another file") </script>';

    } else {
        // move the uploaded (temporary) file to the specified destination
        if(move_uploaded_file($file, $destination)) {

            //I inserted values in a different special way
            $sql = "INSERT INTO camerareadycopypaper(name, size, downloads,title,abstract,button) VALUES ('$filename', $size, 0,'$_POST[title]','$_POST[abstract]',0)";
           
            if (mysqli_query($conn, $sql)) {
                // echo "File uploaded successfully";
                echo '<script type="text/javascript"> alert("Your paper was submitted successfully!!") </script>';

            }
        }
         else {
            echo '<script type="text/javascript"> alert("Failed to submit your file !!") </script>';
        }
    }
}
// Downloads files
if (isset($_GET['file_id'])) {
    $id = $_GET['file_id'];

    // fetch file to download from database
    $sql = "SELECT crc_id,name,size,downloads,title,abstract FROM camerareadycopypaper WHERE crc_id=$id";
    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = '../../cameraReadyUploads/' . $file['name'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('../../cameraReadyUploads/' . $file['name']));
        readfile('../../cameraReadyUploads/' . $file['name']);

        // Now update downloads count
        $newCount = $file['downloads'] + 1;
        $updateQuery = "UPDATE camerareadycopypaper SET downloads=$newCount WHERE crc_id=$id";
        mysqli_query($conn, $updateQuery);
        exit;
    }

}
// sql to delete a record



