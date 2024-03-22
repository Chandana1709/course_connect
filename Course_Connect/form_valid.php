<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$email_id = $_POST["email_id"];
$name = $_POST["name"];
$phone_number = $_POST["phone_number"];


$conn = new mysqli("localhost", "root", "Password123", "course_connect");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {

    $table_check_query = "SHOW TABLES LIKE 'users'";
    $table_check_result = $conn->query($table_check_query);
    
    if ($table_check_result->num_rows == 0) {
 
        $create_table_query = "CREATE TABLE users (
                                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                                email_id VARCHAR(255) NOT NULL,
                                name VARCHAR(255) NOT NULL,
                                phone_number VARCHAR(15) NOT NULL
                              )";
        
        if ($conn->query($create_table_query) === TRUE) {

            $insert_data_query = "INSERT INTO users (email_id, name, phone_number)
                                  VALUES ('$email_id', '$name', '$phone_number')";
            
            if ($conn->query($insert_data_query) === TRUE) {

                sendEmail($email_id, $name, 'user');
                echo '<script>alert("Enquiry successfully Submitted. Check your email for further instructions.");window.location="login.html";</script>';
            } else {
                echo "Error inserting data: " . $conn->error;
            }
        } else {
            echo "Error creating table: " . $conn->error;
        }
    } else {

        $insert_data_query = "INSERT INTO users (email_id, name, phone_number)
                              VALUES ('$email_id', '$name', '$phone_number')";
        
        if ($conn->query($insert_data_query) === TRUE) {
            // Send email to user
            sendEmail($email_id, $name, 'user');
            echo '<script>alert(" Data Stored successfully . Check your email for further instructions.");window.location="user_form.php";</script>';
        } else {
            echo "Error inserting data: " . $conn->error;
        }
    }

  
    $admin_email_query = "SELECT email FROM admin";
    $admin_email_result = $conn->query($admin_email_query);
    
    if ($admin_email_result->num_rows > 0) {
        while ($row = $admin_email_result->fetch_assoc()) {

            sendEmail($row["email"], 'Admin', 'admin', $name, $phone_number,$email_id);
        }
    }

    $conn->close();
}

function sendEmail($email, $name, $recipient_type, $user_name = '', $user_phone = '', $user_email = '') {
    $mail = new PHPMailer();

    // SMTP configuration
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'chandanamanjunath1986@gmail.com';
    $mail->Password = 'cfeb gwvb jnha eqvm';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('chandanamanjunath1986@gmail.com', 'Chandana M');
    $mail->addAddress($email, $name); 
    $mail->Subject = 'Welcome to Our Course Connect'; 
    $mail->isHTML(true); 

    // Body of the email
    if ($recipient_type === 'user') {
        $mail->Body = '<p>Hello ' . $name . ',</p><p>Thank you for enquiring with us!</p>';
    } elseif ($recipient_type === 'admin') {
        $mail->Body = '<p>A new user has enquired with the following details:</p>';
        $mail->Body .= '<p><strong>Name: </strong>' . $user_name . '</p>';
        $mail->Body .= '<p><strong>Email:</strong> ' . $user_email . '</p>';
        $mail->Body .= '<p><strong>Phone Number:</strong> ' . $user_phone . '</p>';
    }

 
    if (!$mail->send()) {
        echo 'Error sending email: ' . $mail->ErrorInfo;
    }
}
?>
