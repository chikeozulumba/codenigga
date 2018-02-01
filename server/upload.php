<?php 
 require_once $_SERVER['DOCUMENT_ROOT'].'/AC/server/core/init.php';
 require('./class/UploadService.php');

if ($_FILES['image']['name'] != '') 
{
    $filename = $_FILES['image']['name'];
    $extension = explode(".", $filename);
    $ext = array_pop($extension);
    $allowed = [
        "jpg", "gif", "png", "jpeg"
    ];
    if (in_array($ext, $allowed)) {
        $imageName = rand() . '.' . $ext;
        $filepath = "images/" . $imageName;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $filepath)) {
            echo "Image upload successful";
        } else {
            echo "Image upload failed";
        }
    } else {
        echo 'Invalid file format';
    }
} else {
    echo 'false';
}