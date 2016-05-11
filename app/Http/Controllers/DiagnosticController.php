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
class DiagnosticController extends Controller
{
    /**
     * get the diagnostic page for email sending.
     *
     * @return type view
     */
    public function getDiag(Emails $email)
    {
        try {
            $emails = $email->all();

            return view('diagnostic.index', compact('emails'));
        } catch (Exception $e) {
            return redirect()->back()->with('fails', $e);
        }
    }

    /**
     * post the diagnostic page to send email.
     *
     * @return type view
     */
    public function postDiag(DiagnosRequest $request)
    {
        try {
            $email_details = Emails::where('id', '=', $request->from)->first();
            if ($email_details->sending_protocol == 'mail') {
                $mail = new PHPMailer(); // defaults to using php "mail()"
                $mail->IsSendmail(); // telling the class to use SendMail transport
//                $body = file_get_contents('contents.html');
//                $body = eregi_replace("[\]", '', $request->message);
                $mail->AddReplyTo($request->from, '');
                $mail->SetFrom($request->from, '');
                $mail->AddReplyTo($request->from, '');
                $address = $request->to;
                $mail->AddAddress($address, '');
                $mail->Subject = $request->subject;
                $mail->MsgHTML($request->message);
                if (!$mail->Send()) {
                    $return = 'Mailer Error: '.$mail->ErrorInfo;
                } else {
                    $return = 'Message sent from Php-Mail';
                }
            } elseif ($email_details->sending_protocol == 'smtp') {
                $mail = new \PHPMailer();
                //$mail->SMTPDebug = 3;                                     // Enable verbose debug output
                $mail->isSMTP();                                            // Set mailer to use SMTP
                $mail->Host = $email_details->sending_host;                 // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                                     // Enable SMTP authentication
                $mail->Username = $email_details->email_address;                 // SMTP username
                $mail->Password = \Crypt::decrypt($email_details->password);                           // SMTP password
                $mail->SMTPSecure = $email_details->sending_encryption;                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = $email_details->sending_port;                                    // TCP port to connect to

                $mail->setFrom($email_details->email_address, $email_details->email_name);
                $mail->addAddress($request->to, '');     // Add a recipient
//                $mail->addCC('cc@example.com');
//                $mail->addBCC('bcc@example.com');
//                $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//                $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
                $mail->isHTML(true);                                  // Set email format to HTML

                $mail->Subject = $request->subject;
                $mail->Body = $request->message;
//dd($mail);
                if (!$mail->send()) {
                    $return = 'Mailer Error: '.$mail->ErrorInfo;
                } else {
                    $return = 'Message has been sent';
                }
            }

            return redirect()->back()->with('success', $return);
        } catch (Exception $e) {
            return redirect()->back()->with('fails', $e->getMessage());
        }
    }
}
