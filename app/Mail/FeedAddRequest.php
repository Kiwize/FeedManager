<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Mailer\Envelope;
use Symfony\Component\Mime\Address;

class FeedAddRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $feedData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->feedData = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Demande d\'ajout d\'un flux d\'informations.')
                    ->view('testmail');
    }
}
