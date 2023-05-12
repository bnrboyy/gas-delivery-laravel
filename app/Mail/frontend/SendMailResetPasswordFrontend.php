<?php

namespace App\Mail\frontend;

use App\Models\MemberAccount;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailResetPasswordFrontend extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(MemberAccount $user, $reset_token)
    {
        $this->user = $user;
        $this->reset_token = $reset_token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = $this->user;
        $reset_token = $this->reset_token;
        return $this->subject('Reset Password ' . date('Y-m-d H:i:s'))
            ->markdown('email.resetpassword')
            ->with([
                'user' => $user,
                'reset_token' => $reset_token,
                'linkReset' => env("APP_URL", "") . '/auth-reset?token=' . $reset_token->token
            ]);
    }
}
