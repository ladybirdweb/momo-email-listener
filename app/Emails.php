<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * ======================================
 * Emails Model
 * ======================================
 * This is a model representing the emails table
 * @author Ladybird <info@ladybirdweb.com>
 */
class Emails extends Model {

    protected $table = 'emails';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email_address', 'email_name', 'department', 'priority', 'help_topic',
        'user_name', 'password', 'fetching_host', 'fetching_port', 'fetching_protocol', 'fetching_encryption', 'mailbox_protocol',
        'folder', 'sending_host', 'sending_port', 'sending_protocol', 'sending_encryption', 'internal_notes', 'auto_response',
        'fetching_status', 'move_to_folder', 'delete_email', 'do_nothing',
        'sending_status', 'authentication', 'header_spoofing', 'imap_config',
    ];

}
