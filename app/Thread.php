<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * ======================================
 * Thread Model
 * ======================================
 * This is a model representing the thread table
 * @author Ladybird <info@ladybirdweb.com>
 */
class Thread extends Model {

    protected $table = 'thread';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'title', 'body'
    ];

}
