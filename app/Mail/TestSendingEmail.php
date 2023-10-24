<?php

namespace App\Mail;

use session;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TestSendingEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //return $this->from('muchammad.faisal@unisba.ac.id', 'Fakultas Psikologi')
        $request->session()->flash('success', 'Password has been changed');
            return $this->view('emails.test-mail');
    }
}
