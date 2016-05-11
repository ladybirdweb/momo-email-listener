<?php

namespace App\Http\Controllers;

// controllers
// model
use App\Attachment;
use App\Emails;
use App\Thread;
// classes
use Crypt;
use ForceUTF8\Encoding;
use PhpImap\Mailbox as ImapMailbox;

/**
 * ======================================
 * MailController.
 * ======================================
 * This Controller is used to fetch all the mails of any email.
 *
 * @author Ladybird <info@ladybirdweb.com>
 */
class MailController extends Controller {

    public function readmails() {
        // get all the emails
        $emails = Emails::get();
        // fetch each mails by mails
        foreach ($emails as $email) {
            $email_id = $email->email_address;
            $password = Crypt::decrypt($email->password);
            $protocol = '/' . $email->fetching_protocol;
            $host = $email->fetching_host;
            $port = $email->fetching_port;
            $encryption = '/' . $email->fetching_encryption;
            if ($email->mailbox_protocol) {
                $protocol_value = $e_mail->mailbox_protocol;
                $get_mailboxprotocol = MailboxProtocol::where('id', '=', $protocol_value)->first();
                $protocol = $get_mailboxprotocol->value;
            } elseif ($email->fetching_encryption == '/none') {
                $fetching_encryption2 = '/novalidate-cert';
                $protocol = $fetching_encryption2;
            } else {
                if ($email->fetching_protocol) {
                    $fetching_protocol = '/' . $email->fetching_protocol;
                } else {
                    $fetching_protocol = '';
                }
                if ($email->fetching_encryption) {
                    $fetching_encryption = $email->fetching_encryption;
                } else {
                    $fetching_encryption = '';
                }
                $protocol = $fetching_protocol . $fetching_encryption;
            }
            $mailbox = new ImapMailbox('{' . $host . ':' . $port . $protocol . '}INBOX', $email_id, $password, __DIR__);
            // fetch mail by one day previous
            $mailsIds = $mailbox->searchMailBox('SINCE ' . date('d-M-Y', strtotime('-1 day')));
            if (!$mailsIds) {
                die('Mailbox is empty');
            }
            foreach ($mailsIds as $mailId) {
                // get overview of mails
                $overview = $mailbox->get_overview($mailId);
                // check if mails are unread
                $var = $overview[0]->seen ? 'read' : 'unread';
                // load only unread mails
                if ($var == 'unread') {
                    $mail = $mailbox->getMail($mailId);
                    $body = $mail->textHtml;
                    // if mail body has no messages fetch backup mail
                    if ($body == null) {
                        $body = $mailbox->backup_getmail($mailId);
                        $body = str_replace('\r\n', '<br/>', $body);
                    }
                    // check if mail has subject
                    if (isset($mail->subject)) {
                        $subject = $mail->subject;
                    } else {
                        $subject = 'No Subject';
                    }
                    // fetch mail from details
                    $fromname = $mail->fromName;
                    $fromaddress = $mail->fromAddress;
                    // store mail details id thread tables
                    $thread = new Thread();
                    $thread->name = $fromname;
                    $thread->email = $fromaddress;
                    $thread->title = $subject;
                    $thread->body = $body;
                    $thread->save();
                    // fetch mail attachments
                    foreach ($mail->getAttachments() as $attachment) {
                        $support = 'support';
                        $dir_img_paths = __DIR__;
                        $dir_img_path = explode('/code', $dir_img_paths);
                        $filepath = explode('..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'public', $attachment->filePath);
                        $path = public_path() . $filepath[1];
                        $filesize = filesize($path);
                        $file_data = file_get_contents($path);
                        $ext = pathinfo($attachment->filePath, PATHINFO_EXTENSION);
                        $imageid = $attachment->id;
                        $string = str_replace('-', '', $attachment->name);
                        $filename = explode('src', $attachment->filePath);
                        $filename = str_replace('\\', '', $filename);
                        $body = str_replace('cid:' . $imageid, $filepath[1], $body);
                        $pos = strpos($body, $filepath[1]);

                        if ($pos == false) {
                            $upload = new Attachment();
                            $upload->file = $file_data;
                            $upload->thread_id = $thread->id;
                            $upload->name = $filepath[1];
                            $upload->type = $ext;
                            $upload->size = $filesize;
                            $upload->poster = 'ATTACHMENT';
                            $upload->save();
                        } else {
                            $upload = new Attachment();
                            $upload->file = $file_data;
                            $upload->thread_id = $thread->id;
                            $upload->name = $filepath[1];
                            $upload->type = $ext;
                            $upload->size = $filesize;
                            $upload->poster = 'INLINE';
                            $upload->save();
                        }
                        unlink($path);
                    }
                    // run an encoding fix before saving mail details
                    $body = Encoding::fixUTF8($body);
                    $thread->body = $body;
                    $thread->save();
                } else {
                    
                }
            }
        }

        return redirect()->route('home');
    }

    /**
     * fetch_attachments.
     *
     * @return type
     */
    public function fetch_attachments() {
        $uploads = Upload::all();
        foreach ($uploads as $attachment) {
            $image = @imagecreatefromstring($attachment->file);
            ob_start();
            imagejpeg($image, null, 80);
            $data = ob_get_contents();
            ob_end_clean();
            $var = '<a href="" target="_blank"><img src="data:image/jpg;base64,' . base64_encode($data) . '"/></a>';
            echo '<br/><span class="mailbox-attachment-icon has-img">' . $var . '</span>';
        }
    }

    /**
     * function to load data.
     *
     * @param type $id
     *
     * @return type file
     */
    public function get_data($id) {
        $attachments = Attachment::where('id', '=', $id)->get();
        foreach ($attachments as $attachment) {
            header('Content-type: application/' . $attachment->type . '');
            header('Content-Disposition: inline; filename=' . $attachment->name . '');
            header('Content-Transfer-Encoding: binary');
            echo $attachment->file;
        }
    }

}
