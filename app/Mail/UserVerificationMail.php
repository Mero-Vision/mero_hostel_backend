<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    private $user,$token;
    /**
     * Create a new message instance.
     */
    public function __construct($user,$token)
    {
            $this->user=$user;
            $this->token=$token;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'User Verification Mail',
        );
    }

    /**
     * Get the message content definition.
     */



    public function build()
    {

        $data['user']=$this->user;
        $data['token']=$this->token;
        $data['url'] = url("/email-verified?token=$this->token");
        return $this->markdown('mail.user-verification-mail')->with($data);
    }
    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
