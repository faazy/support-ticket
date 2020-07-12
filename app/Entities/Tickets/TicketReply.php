<?php

namespace App\Entities\Tickets;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed created_at
 */
class TicketReply extends Model
{
    protected $fillable = ['ticket_id', 'agent_id', 'reply_text'];

    protected $appends = ['date'];

    protected $with = ['agent'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->agent_id = auth()->id();
        });
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }


    public function getDateAttribute()
    {
        return $this->created_at->format('Y-m-d');
    }
}
