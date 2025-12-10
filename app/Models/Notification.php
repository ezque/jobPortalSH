<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'type',
        'data_id',
        'status',
        'message',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }


    public function scopeUnread($query)
    {
        return $query->where('status', 'unread');
    }


    public function markAsRead()
    {
        $this->update(['status' => 'read']);
    }


    public function markAsUnread()
    {
        $this->update(['status' => 'unread']);
    }
}
