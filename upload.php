<?php
    $target_dir = "../../cloud/";
    $acceptedFileTypes = array("txt", "doc", "docx", "xls", "xlsx", "ppt", "pptx", "pdf", "jpg", "jpeg", "png", "mp3", "mp4", "mov");
    //var_dump($_FILES['filesToUpload']);


    $files = array_filter($_FILES['filesToUpload']['name']); 
    $total_count = count($_FILES['filesToUpload']['name']);
    for($i=0 ; $i < $total_count ; $i++ ) {
        $target_file = $target_dir . basename($_FILES["filesToUpload"]["name"][$i]);
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
        if(!in_array($fileType, $acceptedFileTypes)) {
            echo "file_type_error";
            $uploadOk = 0;
        }

        $check = mime_content_type($_FILES["filesToUpload"]["tmp_name"][$i]);
        switch($fileType) {
            case "jpg" || "jpeg" || "png":
                if (!str_contains($check, "image")) {
                    echo "file_content_error1";
                    $uploadOk = 1;
                }
                break;
            case "pdf":
                if (!str_contains($check, "pdf")) {
                    echo "file_content_error2";
                    $uploadOk = 1;
                }
                break;
            case "doc" || "docx" || "xls" || "xlsx" || "ppt" || "pptx":
                if (!str_contains($check, "vnd.ms-")) {
                    echo "file_content_error3";
                    $uploadOk = 1;
                }
                break;
            case "mp4" || "mov":
                if (!str_contains($check, "audio/mpeg")) {
                    echo "file_content_error4";
                    $uploadOk = 1;
                }
                break;
        }

        if (file_exists($target_file)) {
            echo "file_exists";
            $uploadOk = 0;
        }
        /*if ($_FILES["filesToUpload"]["size"][$i] > 500000) {
            echo "file_size";
            $uploadOk = 0;
        }*/

        if ($uploadOk == 0) {
            echo "";
        } else {
            if (move_uploaded_file($_FILES["filesToUpload"]["tmp_name"][$i], $target_file)) {
                echo "upload_done";
            } else {
                echo "upload_error";
            }
        }
    }
?>