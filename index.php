<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

include 'db.php';
$mail = new PHPMailer();

$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'tlc'; 
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->Username = 'example@gmail.com';
$mail->Password = 'mail password';
$mail->setFrom($mail->Username, 'My name');



$counter = 0;
$query = $db->query("SELECT * FROM mail_table", PDO::FETCH_ASSOC);
if ( $query->rowCount() ){
     foreach( $query as $row ){
      $counter++;
 
 
          $mail->addAddress($row['set_mail'], 'Name to send');     
          $mail->addAttachment('example.txt'); 
          $mail->CharSet = 'UTF-8';
          $mail->isHTML(true);                                  
          $mail->Subject = 'Hello';
          $mail->Body    = 'Message body';
          $mail->AltBody = 'www.example.com';

          
          if($mail->Send()) {
            echo "Name sent".$row['get_mail'];
            $query = $db->prepare("DELETE FROM mail_table WHERE id = :id");
            $delete = $query->execute(array(
               'id' => $row['id'],
            ));
           
          } else {
          echo $mail->ErrorInfo;
          break;
          }
          
          if($counter == 1){
          break;
          }
         
     }
}

?>

