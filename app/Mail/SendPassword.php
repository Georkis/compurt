<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use League\CommonMark\Environment\Environment;

class SendPassword extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected string $password;


    /**
     * @param string $password
     */
    public function __construct(string $password)
    {
        $this->password = $password;
        $this->afterCommit;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {

        return new Envelope(
            from: new Address(env(key: 'MAIL_FROM_ADDRESS'), name: env('MAIL_USERNAME')),
            subject: 'Contraseña enviada por el sitio web '.env(key: 'MAIL_FROM_NAME'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.send_password',
            with: [
                'password' => $this->password
            ]
        );
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
