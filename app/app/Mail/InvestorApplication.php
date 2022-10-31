<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use App\Models\User;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\InvestorApplication as InvestorApplicationModel;
use App\UserTokenAuth;

class InvestorApplication extends Mailable
{
    use Queueable, SerializesModels;

    /**
     *
     * @var App\Models\InvestorApplication
     */
    public $investorApplication;

    /**
     *
     * @var string
     */
    public $redirectURL;

    /**
     *
     * @var string
     */
    public $subject = '*** WD INVESTOR LEAD *** ';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(InvestorApplicationModel $investorApplication, User $recepient)
    {
        $this->investorApplication = $investorApplication;
        $this->redirectURL = UserTokenAuth::getAuthLink($recepient, route('dashboard.user', [ 'id' => $investorApplication->user_id ]));
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.investor-application');
    }
}
