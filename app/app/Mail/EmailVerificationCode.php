<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use \App\Models\User;
use \App\Models\Request;

class EmailVerificationCode extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The content of the suggestion.
     *
     * @var string
     */
    private $code;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $code)
    {
        $this->code = $code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $template = $this->view('emails.email-verification', [
            'code' => $this->code
        ]);

        return $template;
    }
}
