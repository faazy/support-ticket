<?php

namespace App\Repositories;


use App\Entities\Tickets\Ticket;
use App\Repositories\Core\BaseRepository;
use Closure;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class TicketRepository extends BaseRepository
{

    const MAX_RECURSIVE = 5;

    protected $searchable = [
        'ticket_ref',
        'customer_name' => 'OR',
        'problem_description' => 'OR',
        'email' => 'OR',
        'phone_no' => 'OR',
        'status'
    ];

    /**
     * UserRepository constructor.
     *
     * @param Ticket $model
     */
    public function __construct(Ticket $model)
    {
        parent::__construct($model);
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->all();
    }


    /**
     * Generate Unique reference number
     *
     * @return int
     * @throws Exception
     */
    public static function generateRef()
    {
        $random_number = null;

        for ($i = 0; $i < self::MAX_RECURSIVE; $i++) {
            $random_number = mt_rand(100000000, 999999999);
            $isExists = Ticket::where('ticket_ref', $random_number)->exists();

            if (!$isExists)
                return $random_number;
        }

        throw new Exception('Ticket Unique reference couldn\'t generate.');
    }
}
