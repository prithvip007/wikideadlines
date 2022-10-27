<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\UserTokenAuth;

class NewUserRequest extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The content of the suggestion.
     *
     * @var \App\Models\User
     */
    private $user;

    /**
     * The content of the suggestion.
     *
     * @var \App\Models\Request
     */
    private $request;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(\App\Models\Request $request, $user)
    {
        $this->request = $request;
        $this->user = $user;
    }

    private function getURL(): string
    {
        $redirectURL = '';

        switch ($this->request->type)
        {
            case 'edit_deadline':
            case 'add_deadline':
                $redirectURL = route('dashboard.deadline-rules.request', ['id' => $this->request->id]) . '#edit';
            break;
            case 'document_type':
            case 'edit_document_type':
                $redirectURL = route('dashboard.documents.request', ['id' => $this->request->id]) . '#edit';
            break;
            case 'feedback':
                $redirectURL = route('dashboard.feedback', ['id' => $this->request->id]);
            break;
            default:
                $redirectURL = '';
        }

        return UserTokenAuth::getAuthLink($this->user, $redirectURL);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        // dd($this->request);

        if (
            $this->request->type === 'edit_deadline' ||
            $this->request->type === 'add_deadline' ||
            $this->request->type === 'document_type' ||
            $this->request->type === 'edit_document_type' ||
            $this->request->type === 'feedback'
        ) {
            $template = $this->view('emails.edit-deadline', [
                'request' => $this->request,
                'url' => $this->getURL()
            ]);
        } else {
            $template = $this->view('emails.request');

            $template->attachData(json_encode($this->request->data, JSON_PRETTY_PRINT), $this->request->type . '.json', [
                'mime' => 'application/json',
            ]);
        }

        return $template;
    }
}
