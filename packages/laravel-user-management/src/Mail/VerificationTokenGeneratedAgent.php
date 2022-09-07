<?php

namespace Deyji\Manage\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Auth\Authenticatable;

class VerificationTokenGeneratedAgent extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user;
    public $subject;
    public $address;
    public $name;
    public $role;
    public function __construct(Authenticatable $user, $subject = null, $address = null, $name = null, $role = null)
    {
        //
        $this->user = $user;
        $this->subject = $subject;
        $this->address = $address;
        $this->name = $name;
        $this->role = $role;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('manage::emails');
    }
}
