<?php

namespace App\Notifications;

use App\Entities\Tickets\Ticket;
use App\Entities\Tickets\TicketReply as TicketReplyEntity;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class TicketReply extends Notification
{
    use Queueable;

    /**
     * @var TicketReplyEntity
     */
    private $ticket_reply;


    /**
     * Create a new notification instance.
     *
     * @param TicketReplyEntity $ticket_reply
     */
    public function __construct(TicketReplyEntity $ticket_reply)
    {
        $this->ticket_reply = $ticket_reply;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting(sprintf("Hello %s!", $notifiable->customer_name))
            ->subject(sprintf("Ticket #%s", $notifiable->ticket_ref))
            ->line(new HtmlString(sprintf('Agent replied to this ticket <strong>#%s.</strong>', $notifiable->ticket_ref)))
            ->line(new HtmlString($this->ticket_reply->reply_text))
            ->action('View Ticket Status', url('/'))
            ->line('Thank you for using our application!');
//            ->withSwiftMessage(function ($message) {
//                $message->getHeaders()
//                    ->addTextHeader('In-Reply-To', '3a05464fb2eda5b9d509948ffc98c27d@127.0.0.1');
//                $message->getHeaders()
//                    ->addTextHeader('References', '3a05464fb2eda5b9d509948ffc98c27d@127.0.0.1');
//                $message
//                    ->setSender('hello@example.com')
//                    ->setReplyTo('3a05464fb2eda5b9d509948ffc98c27d@127.0.0.1');
//            });
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
