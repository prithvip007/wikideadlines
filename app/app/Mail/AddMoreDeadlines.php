<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use \App\Models\User;
use \App\Models\Request;

class AddMoreDeadlines extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The content of the suggestion.
     *
     * @var \App\Models\Request
     */
    private $request;

    /**
     * The content of the suggestion.
     *
     * @var \App\Models\User
     */
    private $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Request $request)
    {
        $this->request = $request;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $template = $this->view('emails.add-deadlines', [
            'request' => $this->request,
            'user' => $this->user,
        ]);

        return $template;
    }
}
