<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
/**
 * ======================================
 * Attchment Model
 * ======================================
 * This is a model representing the attachment table
 * @author Ladybird <info@ladybirdweb.com>
 */
class Attachment extends Model {

    protected $table = 'ticket_attachment';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'thread_id', 'size', 'type', 'poster', 'file',
    ];

}
