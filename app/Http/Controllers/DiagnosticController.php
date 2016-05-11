<?php

namespace App\Http\Controllers;

// Model
use App\Emails;
// Request
use App\Http\Requests\DiagnosRequest;

/**
 * ======================================
 * EmailsController.
 * ======================================
 * This Controller is used to define below mentioned set of functions applied to the Emails in the system.
 *
 * @author Ladybird <info@ladybirdweb.com>
 */
class DiagnosticController extends Controller {

    /**
     * get the diagnostic page for email sending
     * @return type view
     */
    public function getDiag(Emails $email) {
        try {
            $emails = $email->all();
            return view('diagnostic.index', compact('emails'));
        } catch (Exception $ex) {
            return redirect()->back()->with('fail', $e);
        }
    }

    /**
     * post the diagnostic page to send email
     * @return type view
     */
    public function postDiag(DiagnosRequest $request) {
        try {
            $mail = new \PHPMailer;

            //$mail->SMTPDebug = 3;                               // Enable verbose debug output

            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp1.example.com;smtp2.example.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'user@example.com';                 // SMTP username
            $mail->Password = 'secret';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to

            $mail->setFrom('from@example.com', 'Mailer');
            $mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
            $mail->addAddress('ellen@example.com');               // Name is optional
            $mail->addReplyTo('info@example.com', 'Information');
            $mail->addCC('cc@example.com');
            $mail->addBCC('bcc@example.com');

            $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
            $mail->isHTML(true);                                  // Set email format to HTML

            $mail->Subject = 'Here is the subject';
            $mail->Body = 'This is the HTML message body <b>in bold!</b>';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            if (!$mail->send()) {
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                echo 'Message has been sent';
            }
        } catch (Exception $ex) {

        }
    }

}
