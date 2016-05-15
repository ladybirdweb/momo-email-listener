<?php

namespace App\Http\Controllers;

// controllers
// request
use App\Emails;
// model
use Crypt;
// classes
use Exception;
use Illuminate\Http\Request;

/**
 * ======================================
 * EmailsController.
 * ======================================
 * This Controller is used to define below mentioned set of functions applied to the Emails in the system.
 *
 * @author Ladybird <info@ladybirdweb.com>
 */
class EmailsController extends Controller {

    /**
     * Display a listing of the Emails.
     *
     * @param type Emails $emails
     *
     * @return type view
     */
    public function index(Emails $email) {
        try {
            // fetch all the emails from emails table
            $emails = $email->get();

            return view('email.index', compact('emails'));
        } catch (Exception $e) {
            return redirect()->back()->with('fails', $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return type Response
     */
    public function create() {
        try {
            return view('email.create');
        } catch (Exception $e) {
            // return error messages if any
            return redirect()->back()->with('fails', $e->getMessage());
        }
    }

    /**
     * Check for email input validation.
     *
     * @param EmailsRequest $request
     *
     * @return int
     */
    public function validatingEmailSettings(Request $request) {
        $validator = \Validator::make(
                        [
                    'email_address' => $request->email_address,
                    'email_name' => $request->email_name,
                    'password' => $request->password,
                        ], [
                    'email_address' => 'required|email|unique:emails',
                    'email_name' => 'required',
                    'password' => 'required',
                        ]
        );
        if ($validator->fails()) {
            $jsons = $validator->messages();
            $val = '';
            foreach ($jsons->all() as $key => $value) {
                $val .= $value;
            }
            $return_data = rtrim(str_replace('.', ',', $val), ',');

            return $return_data;
        }
        if ($request->input('imap_validate') == 'on') {
            $validate = '/validate-cert';
        } elseif (!$request->input('imap_validate')) {
            $validate = '/novalidate-cert';
        }
        if ($request->input('fetching_status') == 'on') {
            $imap_check = $this->getImapStream($request, $validate);
            if ($imap_check[0] == 0) {
                return 'Incoming email connection failed';
            }
            $need_to_check_imap = 1;
        } else {
            $imap_check = 0;
            $need_to_check_imap = 0;
        }
        if ($request->input('sending_status') == 'on') {
            $smtp_check = $this->getSmtp($request);
            if ($smtp_check == 0) {
                return 'Outgoing email connection failed';
            }
            $need_to_check_smtp = 1;
        } else {
            $smtp_check = 0;
            $need_to_check_smtp = 0;
        }
        if ($need_to_check_imap == 1 && $need_to_check_smtp == 1) {
            if ($imap_check != 0 && $smtp_check != 0) {
                $this->store($request, $imap_check[1]);
                $return = 1;
            }
        } elseif ($need_to_check_imap == 1 && $need_to_check_smtp == 0) {
            if ($imap_check != 0 && $smtp_check == 0) {
                $this->store($request, $imap_check[1]);
                $return = 1;
            }
        } elseif ($need_to_check_imap == 0 && $need_to_check_smtp == 1) {
            if ($imap_check == 0 && $smtp_check != 0) {
                $this->store($request, null);
                $return = 1;
            }
        } elseif ($need_to_check_imap == 0 && $need_to_check_smtp == 0) {
            if ($imap_check == 0 && $smtp_check == 0) {
                $this->store($request, null);
                $return = 1;
            }
        }

        return $return;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param type Emails        $email
     * @param type EmailsRequest $request
     *
     * @return type Redirect
     */
    public function store($request, $imap_check) {
//        dd($imap_check);
//        dd($request);
        $email = new Emails();
        try {
            // saving all the fields to the database
//            if ($email->fill($request->except('password', 'fetching_status', 'fetching_encryption', 'sending_status', 'auto_response'))->save() == true) {
            $email->email_address = $request->email_address;
            $email->email_name = $request->email_name;
            $email->fetching_host = $request->fetching_host;
            $email->fetching_port = $request->fetching_port;
            $email->fetching_protocol = $request->fetching_protocol;
            $email->sending_host = $request->sending_host;
            $email->sending_port = $request->sending_port;
            $email->sending_protocol = $request->sending_protocol;
            $email->sending_encryption = $request->sending_encryption;

            if ($request->smtp_validate == "on") {
                $email->smtp_validate = $request->smtp_validate;
            }

            if ($request->input('password')) {
                $email->password = Crypt::encrypt($request->input('password'));
            }
            if ($request->input('fetching_status') == 'on') {
                $email->fetching_status = 1;
            } else {
                $email->fetching_status = 0;
            }
            if ($request->input('sending_status') == 'on') {
                $email->sending_status = 1;
            } else {
                $email->sending_status = 0;
            }
            if ($request->input('auto_response') == 'on') {
                $email->auto_response = 1;
            } else {
                $email->auto_response = 0;
            }
            if ($imap_check !== null) {
                $email->fetching_encryption = $imap_check;
            } else {
                $email->fetching_encryption = $request->input('fetching_encryption');
            }
//                if ($request->input('smtp_authentication') == 'on') {
//                    $email->smtp_authentication = 1;
//                } else {
//                    $email->smtp_authentication = 0;
//                }
//            dd($email);
            // inserting the encrypted value of password
            $email->save(); // run save
            // returns success message for successful email creation
            return 1;
//            } else {
//                // returns fail message for unsuccessful save execution
//                return 0;
//            }
        } catch (Exception $e) {
            // returns if try fails
            return 0;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param type int             $id
     * @param type Department      $department
     * @param type Help_topic      $help
     * @param type Emails          $email
     * @param type Priority        $priority
     * @param type MailboxProtocol $mailbox_protocol
     *
     * @return type Response
     */
    public function edit($id, Emails $email) {
        try {
            // fetch the selected emails
            $emails = $email->whereId($id)->first();
            // get all the departments
//            $departments = $department->get();
            $departments = '';
            $priority = '';
            $helps = '';
            // get all the helptopic
//            $helps = $help->get();
            // get all the priority
//            $priority = $ticket_priority->get();
            // get all the mailbox protocols
//            $mailbox_protocols = $mailbox_protocol->get();
            // return if the execution is succeeded
            return view('email.edit', compact('mailbox_protocols', 'priority', 'departments', 'helps', 'emails'));
        } catch (Exception $e) {
            // return if try fails
            return redirect()->back()->with('fails', $e->getMessage());
        }
    }

    /**
     * Check for email input validation.
     *
     * @param EmailsRequest $request
     *
     * @return int
     */
    public function validatingEmailSettingsUpdate($id, Request $request) {
//        dd($request);
        $validator = \Validator::make(
                        [
                    'email_address' => $request->input('email_address'),
                    'email_name' => $request->input('email_name'),
                    'password' => $request->input('password'),
                        ], [
                    'email_address' => 'email',
                    'email_name' => 'required',
                    'password' => 'required',
                        ]
        );
        if ($validator->fails()) {
            $jsons = $validator->messages();
            $val = '';
            foreach ($jsons->all() as $key => $value) {
                $val .= $value;
            }
            $return_data = rtrim(str_replace('.', ',', $val), ',');

            return $return_data;
        }
//        return $request;
        if ($request->input('imap_validate') == 'on') {
            $validate = '/validate-cert';
        } elseif (!$request->input('imap_validate')) {
            $validate = '/novalidate-cert';
        }
        if ($request->input('fetching_status') == 'on') {
            $imap_check = $this->getImapStream($request, $validate);
            if ($imap_check[0] == 0) {
                return 'Incoming email connection failed';
            }
            $need_to_check_imap = 1;
        } else {
            $imap_check = 0;
            $need_to_check_imap = 0;
        }
        if ($request->input('sending_status') == 'on') {
            $smtp_check = $this->getSmtp($request);
            if ($smtp_check == 0) {
                return 'Outgoing email connection failed';
            }
            $need_to_check_smtp = 1;
        } else {
            $smtp_check = 0;
            $need_to_check_smtp = 0;
        }
        if ($need_to_check_imap == 1 && $need_to_check_smtp == 1) {
            if ($imap_check != 0 && $smtp_check != 0) {
                $this->update($id, $request, $imap_check[1]);
                $return = 1;
            }
        } elseif ($need_to_check_imap == 1 && $need_to_check_smtp == 0) {
            if ($imap_check != 0 && $smtp_check == 0) {
                $this->update($id, $request, $imap_check[1]);
                $return = 1;
            }
        } elseif ($need_to_check_imap == 0 && $need_to_check_smtp == 1) {
            if ($imap_check == 0 && $smtp_check != 0) {
                $this->update($id, $request, null);
                $return = 1;
            }
        } elseif ($need_to_check_imap == 0 && $need_to_check_smtp == 0) {
            if ($imap_check == 0 && $smtp_check == 0) {
                $this->update($id, $request, null);
                $return = 1;
            }
        }
        return $return;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param type                   $id
     * @param type Emails            $email
     * @param type EmailsEditRequest $request
     *
     * @return type Response
     */
    public function update($id, $request, $imap_check) {
//        dd($request);
        // try {
        // fetch the selected emails
        $emails = Emails::whereId($id)->first();
        // insert all the requested parameters with except
//        $emails->fill($request->except('password', 'department', 'priority', 'help_topic', 'fetching_status', 'fetching_encryption', 'sending_status', 'auto_response'))->save();
        $emails->email_address = $request->email_address;
        $emails->email_name = $request->email_name;
        $emails->fetching_host = $request->fetching_host;
        $emails->fetching_port = $request->fetching_port;
        $emails->fetching_protocol = $request->fetching_protocol;
        $emails->sending_host = $request->sending_host;
        $emails->sending_port = $request->sending_port;
        $emails->sending_protocol = $request->sending_protocol;
        $emails->sending_encryption = $request->sending_encryption;

        if ($request->smtp_validate == "on") {
            $emails->smtp_validate = $request->smtp_validate;
        }

        if ($request->input('fetching_status') == 'on') {
            $emails->fetching_status = 1;
        } else {
            $emails->fetching_status = 0;
        }
        if ($request->input('sending_status') == 'on') {
            $emails->sending_status = 1;
        } else {
            $emails->sending_status = 0;
        }
        if ($request->input('auto_response') == 'on') {
            $emails->auto_response = 1;
        } else {
            $emails->auto_response = 0;
        }
        if ($imap_check !== null) {
            $emails->fetching_encryption = $imap_check;
        } else {
            $emails->fetching_encryption = $request->fetching_encryption;
        }
//        if ($request->input('smtp_authentication') == 'on') {
//            $emails->smtp_authentication = 1;
//        } else {
//            $emails->smtp_authentication = 0;
//        }
        // inserting the encrypted value of password
        $emails->password = Crypt::encrypt($request->input('password'));
        $emails->save();
        // returns success message for successful email update
        $return = 1;
        return $return;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param type   $id
     * @param Emails $email
     *
     * @return type Redirect
     */
    public function destroy($id, Emails $email) {
        try {
            // fetching the database instance of the current email
            $emails = $email->whereId($id)->first();
            // checking if deleting the email is success or if it's carrying any dependencies
            if ($emails->delete() == true) {
                return redirect('emails')->with('success', 'Email Deleted sucessfully');
            } else {
                return redirect('emails')->with('fails', 'Email can not  Delete ');
            }
        } catch (Exception $e) {
            // returns if the try fails
            return redirect()->back()->with('fails', $e->getMessage());
        }
    }

    /**
     * inbox page to fetch all mails.
     *
     * @return type
     */
    public function inbox() {
        if (\Schema::hasTable('emails')) {
            return view('mailbox.inbox');
        } else {
            return view('welcome');
        }
    }

    /**
     * to fetch current mail details.
     *
     * @param type $id
     *
     * @return type view
     */
    public function fetchmail($id) {
        return view('mailbox.readmail', compact('id'));
    }

    /**
     * Create imap connection.
     *
     * @param type $request
     *
     * @return type int
     */
    public function getImapStream($request, $validate) {
        $fetching_status = $request->input('fetching_status');
        $username = $request->input('email_address');
        $password = $request->input('password');
        $protocol_id = $request->input('mailbox_protocol');
        $fetching_protocol = '/' . $request->input('fetching_protocol');
        $fetching_encryption = '/' . $request->input('fetching_encryption');
        if ($fetching_encryption == '/none') {
            $fetching_encryption2 = '/novalidate-cert';
            $mailbox_protocol = $fetching_encryption2;
            $host = $request->input('fetching_host');
            $port = $request->input('fetching_port');
            $mailbox = '{' . $host . ':' . $port . $mailbox_protocol . '}INBOX';
        } else {
            $mailbox_protocol = $fetching_protocol . $fetching_encryption;
            $host = $request->input('fetching_host');
            $port = $request->input('fetching_port');
            $mailbox = '{' . $host . ':' . $port . $mailbox_protocol . $validate . '}INBOX';
            $mailbox_protocol = $fetching_encryption . $validate;
        }
        try {
            $imap_stream = imap_open($mailbox, $username, $password);
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
        $imap_stream = imap_open($mailbox, $username, $password);
        if ($imap_stream) {
            $return = [0 => 1, 1 => $mailbox_protocol];
        } else {
            $return = [0 => 0];
        }
        return $return;
    }

    /**
     * Check connection.
     *
     * @param type $imap_stream
     *
     * @return type int
     */
    public function checkImapStream($imap_stream) {
        $check_imap_stream = imap_check($imap_stream);
        if ($check_imap_stream) {
            $imap_stream = 1;
        } else {
            $imap_stream = 0;
        }
        return $imap_stream;
    }

    /**
     * Get smtp connection.
     *
     * @param type $request
     *
     * @return int
     */
    public function getSmtp($request) {
//        dd($request);
        $sending_status = $request->input('sending_status');
        // cheking for the sending protocol
        if ($request->input('sending_protocol') == 'smtp') {
            $mail = new \PHPMailer();
            $mail->isSMTP();
            $mail->Host = $request->input('sending_host');            // Specify main and backup SMTP servers
            //$mail->SMTPAuth = true;                                   // Enable SMTP authentication
            $mail->Username = $request->input('email_address');       // SMTP username
            $mail->Password = $request->input('password');            // SMTP password
            $mail->SMTPSecure = $request->input('sending_encryption'); // Enable TLS encryption, `ssl` also accepted
            $mail->Port = $request->input('sending_port');            // TCP port to connect to            
            if (!$request->input('smtp_validate')) {
                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );
                if ($mail->smtpConnect($mail->SMTPOptions) == true) {
                    $mail->smtpClose();
                    $return = 1;
                } else {
                    $return = 0;
                }
            } else {
                if ($mail->smtpConnect() == true) {
                    $mail->smtpClose();
                    $return = 1;
                } else {
                    $return = 0;
                }
            }
        } elseif ($request->input('sending_protocol') == 'mail') {
            $return = 1;
        }
        return $return;
    }

}
