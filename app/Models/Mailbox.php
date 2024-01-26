<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mailbox extends Model
{
    use HasFactory;

    protected $table = 'mailboxes';

    protected $fillable = [
        'mail_title',
        'mail_des',
        'sender_id',
        'sender',
        'recevier_id',
        'recevier',
    ];
}
