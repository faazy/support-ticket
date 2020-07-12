<?php

namespace App\Entities\Tickets;

use App\Repositories\TicketRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * @property mixed created_at
 */
class Ticket extends Model
{
    use Notifiable;

    const STATUS_PENDING = 0;
    const STATUS_CLOSED = 1;

    protected $fillable = [
        'ticket_ref',
        'customer_name',
        'problem_description',
        'email',
        'phone_no',
        'agent_id',
        'status'
    ];

    protected $with = ['replies'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->ticket_ref = TicketRepository::generateRef();
        });
    }

    public function replies()
    {
        return $this->hasMany(TicketReply::class, 'ticket_id');
    }

    /**
     * @param Builder $query
     * @param $status
     */
    public function scopeStatus(Builder $query, $status)
    {
        $query->where('status', $status);
    }

}
