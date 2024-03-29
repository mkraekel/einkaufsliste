<?php
session_start();
require "../include/connect.php";

if(isset($_POST["reset-email"])) {
    $email = $_POST["reset-email"];
    $einkaufUsersDB = geteinkaufUsersDB();
    $bytes = random_bytes(40);
    $newpasswordToken = bin2hex($bytes);
    $stmt = $einkaufUsersDB->prepare("UPDATE users SET passwordToken = :newpasswordToken WHERE email = :email ");
    $stmt->execute([
        "newpasswordToken" => $newpasswordToken,
        "email" => $email,
    ]);


    ## Email zur password rücksetzung setzen

    $headers = "MIME-Version: 1.0" . "\r\n";$headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type: text/html; charset=utf-8" . "\r\n";
    $headers .= "From: no-reply@kraekel.com" . "\r\n" .
        "Reply-To: support@kraekel.com" . "\r\n" .
        "X-Mailer: PHP/" . phpversion();

    $link = "https://kraekel.com/projects/demos/einkaufsliste/reset-password.php?token=$newpasswordToken&email=$email";
    $msg = "Bitte klicke auf diesen Link um dein Passwort zurückzusetzen $link";
    mail($email, "Password Reset", $msg, $headers);
    echo "email versendet";
    header("Location: ../../index.php");
}
///
