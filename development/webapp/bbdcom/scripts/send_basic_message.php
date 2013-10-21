<?php
//Code handles sending messages and uploading images for the birthday function on the web application side.
session_start();
<<<<<<< HEAD
include("upload_image.php"); // Includes upload_image.php to and evaluates the file.
=======
require("db/connectionScript.php");
require("db/UserScript.php");
require("db/NotificationScript.php");
require("db/DepartmentScript.php");
require("db/NomineeScript.php");
require("db/Note_DepartmentScript.php");
require("db/Department_UserScript.php");
require("db/Department_Note_UserScript.php");
include("upload_image.php");
>>>>>>> 3467d71e7101b083b28a93fa6d7b047f549121a0

$department = $_POST["department_list"]; //Posts department_list and handles messages
if(empty($department))
{
    $_SESSION['message_error']='<div class="alert alert-dismissable alert-danger">'
                                   .'<button id="test" type="button" class="close" data-dismiss="alert">&times;</button>'
                                   .'<strong>Sending message failed. Please try again.</strong>'
                                   .'</div>';  
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}

$subject = $_POST["subject"]; // Handles message sending.
if(empty($subject))
{
    $_SESSION['message_error']='<div class="alert alert-dismissable alert-danger">'
                                   .'<button id="test" type="button" class="close" data-dismiss="alert">&times;</button>'
                                   .'<strong>Sending message failed. Please try again.</strong>'
                                   .'</div>';  
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}

$message = $_POST["message"];
if(empty($message))
{
    $message = null;    
}
 // The function handles uploading images for sending birthday messages on the web application.
$image = $_FILES["image"];

if(!empty($image["errors"]))
{   
    $_SESSION['message_error']='<div class="alert alert-dismissable alert-danger">'
                                    .'<button id="test" type="button" class="close" data-dismiss="alert">&times;</button>'
                                    .'<strong>Sending message failed. Please try again.</strong>'
                                    .'</div>';  
    header('Location: ' . $_SERVER['HTTP_REFERER']); 
    exit;
}
 
else
{   
    if ($image["size"] == 0)
    {
    	$image_path = null;
    }
        
    else
    {
        $image_path = uploadImage($image);

        if(is_null($image_path))
        {        
            $_SESSION['message_error']='<div class="alert alert-dismissable alert-danger">'
                                        .'<button id="test" type="button" class="close" data-dismiss="alert">&times;</button>'
                                        .'<strong>Sending message failed. Please try again.</strong>'
                                        .'</div>';  
            header('Location: ' . $_SERVER['HTTP_REFERER']);        
            exit;
        } 
    }
}



//this code is handles sending event messages
$is_event = $_POST['is_event'];
if ($is_event)
{
    $rsvp = $_POST["rsvp"];
    if(empty($rsvp))
    {
        $rsvp = null;
        $_SESSION['message_error']='<div class="alert alert-dismissable alert-danger">'
                                    .'<button id="test" type="button" class="close" data-dismiss="alert">&times;</button>'
                                    .'<strong>Sending message failed. Please try again.</strong>'
                                    .'</div>';  
        header('Location: ' . $_SERVER['HTTP_REFERER']); 
        exit; 
    }
    
    $info = array(
    "partner" => false,
    "diet" => false,
    "driver"=> false
    );   
    
    if(!empty($_POST['check_list'])) {
        foreach($_POST['check_list'] as $check) {
            $info[$check] = true;           
        }
    }
    
}

$_SESSION['message_success']='<div class="alert alert-dismissable alert-success">'
                                .'<button id="test" type="button" class="close" data-dismiss="alert">&times;</button>'
                                .'<strong>Message sent.</strong>'
                                .'</div>';  

//echo $department."<br>";
//echo $subject."<br>";
//echo $message."<br>";
//echo $image_path."<br>";
//echo var_dump($rsvp)."<br>";
//var_dump($info);

$message_type = $_POST['message_type'];

//add to database
$output1 = addNotification($subject,$image_path,$message,0,"12/12/2013",$department, $message_type);
//echo $output1;


header('Location: /bbdcom/dashboard.php'); // The function is called to redirect to the dashboard page.
exit;
?>