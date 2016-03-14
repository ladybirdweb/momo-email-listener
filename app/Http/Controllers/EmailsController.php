<?php

namespace App\Http\Controllers;

// controllers
use App\Http\Controllers\Controller;
// request
use App\Http\Requests\EmailsRequest;
use App\Http\Requests\EmailsEditRequest;
// model
use App\Emails;
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
     * @param type Emails $emails
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
     * @param Request $request
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
        $imap_check = $this->getImapStream($request);
        if ($imap_check == 0) {
            return 'Incoming email connection failed';
        }
        $need_to_check_imap = 1;

        $return = $this->store($request);

        return $return;
    }

    /**
     * Store a newly created resource in storage.
     * @param type $request
     * @return int
     */
    public function store($request) {
        //        dd($request);
        $email = new Emails();
        try {
            // saving all the fields to the database
            if ($email->fill($request->except('password'))->save() == true) {
                // password
                $email->password = Crypt::encrypt($request->input('password'));
                $email->save(); // run save
                // returns success message for successful email creation
                // return redirect('emails')->with('success', 'Email Created sucessfully');
                return 1;
            } else {
                // returns fail message for unsuccessful save execution
                // return redirect('emails')->with('fails', 'Email can not Create');
                return 0;
            }
        } catch (Exception $e) {
            // returns if try fails
            // return redirect()->back()->with('fails', $e->getMessage());
            return 0;
        }
    }

    public function show() {        
    }

    /**
     * Show the form for editing the specified resource.
     * @param type $id
     * @param Emails $email
     * @return type Response
     */
    public function edit($id, Emails $email) {
        try {
            // fetch the selected emails
            $emails = $email->whereId($id)->first();
            // return if the execution is succeeded
            return view('email.edit', compact('emails'));
        } catch (Exception $e) {
            // return if try fails
            return redirect()->back()->with('fails', $e->getMessage());
        }
    }

    /**
     * Check for email input validation.
     * @param EmailsRequest $request
     * @return int
     */
    public function validatingEmailSettingsUpdate($id, Request $request) {
        $validator = \Validator::make(
                        [
                    'email_address' => $request->email_address,
                    'email_name' => $request->email_name,
                    'password' => $request->password,
                        ], [
                    'email_address' => 'required|email',
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
        $imap_check = $this->getImapStream($request);
        if ($imap_check == 0) {
            return 'Incoming email connection failed';
        }
        $need_to_check_imap = 1;
        $return = $this->update($id, $request);
        return $return;
    }

    /**
     * Update the specified resource in storage.
     * @param type                   $id
     * @param type Emails            $email
     * @return type Response
     */
    public function update($id, $request) {
        try {
            // fetch the selected emails
            $emails = Emails::whereId($id)->first();
            // insert all the requested parameters with except
            $emails->fill($request->except('password'))->save();
            // inserting the encrypted value of password
            $emails->password = Crypt::encrypt($request->input('password'));
            $emails->save();
            // returns success message for successful email update
            // return redirect('emails')->with('success', 'Email Updated sucessfully');
            return 1;
        } catch (Exception $e) {
            // returns if try fails
            // return redirect()->back()->with('fails', $e->getMessage());
            return 0;
        }

        // return $return;
        return 0;
    }

    /**
     * Remove the specified resource from storage.
     * @param type $id
     * @param Emails $email
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
     * inbox page to fetch all mails
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
     * to fetch current mail details
     * @param type $id
     * @return type view
     */
    public function fetchmail($id) {
        return view('mailbox.readmail', compact('id'));
    }

    /**
     * Create imap connection.
     * @param type $request
     * @return int
     */
    public function getImapStream($request) {
        $fetching_status = $request->input('fetching_status');
        $username = $request->input('email_address');
        $password = $request->input('password');
        $protocol_id = $request->input('mailbox_protocol');
        $fetching_protocol = '/' . $request->input('fetching_protocol');
        $fetching_encryption = '/' . $request->input('fetching_encryption');
        if ($fetching_encryption == 'none') {
            $fetching_encryption = 'novalidate-cert';
        }
        $mailbox_protocol = $fetching_protocol . $fetching_encryption;
        $host = $request->input('fetching_host');
        $port = $request->input('fetching_port');
        $mailbox = '{' . $host . ':' . $port . $mailbox_protocol . '}INBOX';
        try {
            $imap_stream = imap_open($mailbox, $username, $password);
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
        $imap_stream = imap_open($mailbox, $username, $password);
        if ($imap_stream) {
            $return = 1;
        } else {
            $return = 0;
        }

        return $return;
    }

    /**
     * Check connection.
     * @param type $imap_stream
     * @return int
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

}
