<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use App\Models\User;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\UserTokenAuth;
use Laravel\Telescope\IncomingExceptionEntry;

class UnexpectedErrorOccured extends Mailable
{
    use Queueable, SerializesModels;

    /**
     *
     * @var string
     */
    public $telescopeURL;

    /**
     *
     * @var array
     */
    public $incomingExceptionEntry;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(IncomingExceptionEntry $incomingExceptionEntry, User $recepient)
    {
        $this->incomingExceptionEntry = $incomingExceptionEntry->toArray();
        $this->telescopeURL = UserTokenAuth::getAuthLink($recepient,  url('telescope/exceptions/' . $incomingExceptionEntry->uuid));
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.unexpected-error');
    }
}
