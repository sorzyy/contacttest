<?php

    $array = array("firstname" => "", "name" => "", "email" => "", "phone" => "", "message" => "", "firstnameError" => "", "nameError" => "", "emailError" => "", "phoneError" => "", "messageError" => "", "isSuccess" => false);
    $emailTo = "brisssou07@gmail.com";

    if ($_SERVER["REQUEST_METHOD"] == "POST") { 
        $array["firstname"] = test_input($_POST["firstname"]);
        $array["name"] = test_input($_POST["name"]);
        $array["email"] = test_input($_POST["email"]);
        $array["phone"] = test_input($_POST["phone"]);
        $array["message"] = test_input($_POST["message"]);
        $array["isSuccess"] = true; 
        $emailText = "";
        
        if (empty($array["firstname"])) {
            $array["firstnameError"] = "Erreur ce n'est pas un prénom !";
            $array["isSuccess"] = false; 
        } else {
            $emailText .= "Firstname: {$array['firstname']}\n";
        }

        if (empty($array["name"])) {
            $array["nameError"] = "Erreur ce n'est pas un nom !";
            $array["isSuccess"] = false; 
        } else {
            $emailText .= "Name: {$array['name']}\n";
        }

        if(!isEmail($array["email"])) {
            $array["emailError"] = "Erreur ce n'est pas un e-mail !";
            $array["isSuccess"] = false; 
        } else {
            $emailText .= "Email: {$array['email']}\n";
        }

        if (!isPhone($array["phone"])) {
            $array["phoneError"] = "Erreur ceci n'est pas un numéro !";
            $array["isSuccess"] = false; 
        } else {
            $emailText .= "Phone: {$array['phone']}\n";
        }

        if (empty($array["message"])) {
            $array["messageError"] = "écrivez votre message.";
            $array["isSuccess"] = false; 
        } else {
            $emailText .= "Message: {$array['message']}\n";
        }
        
        if($array["isSuccess"]) {
            $headers = "From: {$array['firstname']} {$array['name']} <{$array['email']}>\r\nReply-To: {$array['email']}";
            mail($emailTo, "Un message de votre site", $emailText, $headers);
        }
        
        echo json_encode($array);    
    }

    function isEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    function isPhone($phone) {
        return preg_match("/^[0-9 ]*$/",$phone);
    }
    function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
 
?>


