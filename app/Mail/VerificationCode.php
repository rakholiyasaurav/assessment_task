<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationCode extends Mailable
{
    use Queueable, SerializesModels;
private $username;
private $otp;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($username,$otp)
    {
        $this->username = $username;
        $this->otp = $otp;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Verification Otp")->view('verify')->from('admin@incred.io')->with([
            'username' => $this->username,
            'otp' => $this->otp
        ]);;
    }
}
