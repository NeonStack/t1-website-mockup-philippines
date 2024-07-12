<?php

session_start();

$curr_user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;

include('connection_db.php');



if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    if (isset($_FILES['new_profile_picture']) && $_FILES['new_profile_picture']['error'] === UPLOAD_ERR_OK) {


        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/bmp', 'image/tiff', 'image/webp'];



        $imageInfo = getimagesize($_FILES['new_profile_picture']['tmp_name']);

        $fileType = $imageInfo['mime'];



        if (!in_array($fileType, $allowedTypes)) {

            $_SESSION['profile-form-status-success'] = false;

            $_SESSION['profile_update_message'] = 'Invalid file type.<br>Please upload a valid image (.jpeg, .jpg, .png, .bmp, .tiff, .webp).';

        } else {


            $uploadDir = '../img/profile-picture/';



            if (!is_dir($uploadDir)) {

                mkdir($uploadDir, 0777, true);

            }



            $uniqueFilename = uniqid() . '_' . $_FILES['new_profile_picture']['name'];

            $imagePath = 'img/profile-picture/' . $uniqueFilename;

            $uploadFile = $uploadDir . $uniqueFilename;



            if (move_uploaded_file($_FILES['new_profile_picture']['tmp_name'], $uploadFile)) {


                $updateProfilePictureQuery = "UPDATE user_info SET image_path = ? WHERE id = ?";

                $stmt = $conn->prepare($updateProfilePictureQuery);



                if ($stmt) {

                    $stmt->bind_param('si', $imagePath, $curr_user_id);

                    $stmt->execute();



                    if ($stmt->affected_rows > 0) {

                        $_SESSION['profile-form-status-success'] = true;

                        $_SESSION['profile_update_message'] = 'Profile picture updated successfully.';

                    } else {

                        $_SESSION['profile-form-status-success'] = false;

                        $_SESSION['profile_update_message'] = 'Profile picture update failed.<br>Please try again later';

                    }



                    $stmt->close();

                } else {

                    $_SESSION['profile-form-status-success'] = false;

                    $_SESSION['profile_update_message'] = 'Something went wrong. <br>Please try again later.';

                }

            } else {

                $_SESSION['profile-form-status-success'] = false;

                $_SESSION['profile_update_message'] = 'Upload failed.<br>Please try again later';

            }

        }

    }




    foreach ($_POST as $field => $value) {


        if (strpos($field, 'new_') === 0) {


            $label = str_replace('new_', '', $field);




            $uppercaseValue = strtoupper($value);




            $updateFieldQuery = "UPDATE user_info SET $label = ? WHERE id = ?";

            $stmt = $conn->prepare($updateFieldQuery);



            if ($stmt) {

                $stmt->bind_param('si', $uppercaseValue, $curr_user_id);

                $stmt->execute();



                if ($stmt->affected_rows > 0) {

                    $_SESSION['profile-form-status-success'] = true;

                    $_SESSION['profile_update_message'] = ucfirst($label) . ' updated successfully.';

                } else {

                    $_SESSION['profile-form-status-success'] = false;

                    $_SESSION['profile_update_message'] = ucfirst($label) . ' update failed.<br>Please try again later.';

                }



                $stmt->close();

            } else {

                $_SESSION['profile-form-status-success'] = false;

                $_SESSION['profile_update_message'] = 'Something went wrong. <br>Please try again later.';

            }

        }

    }






    header('Location: profile.php');

    exit();

} else {

    $_SESSION['profile-form-status-success'] = false;

    $_SESSION['profile_update_message'] = 'Invalid request.';

}



$conn->close();

