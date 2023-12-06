<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Header\UnstructuredHeader;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;
    protected string $password;
    protected string $rescipientMail;
    protected string $email_verified_token;
    /**
     * Create a new message instance.
     */
    public function __construct(string $rescipientMail, string $password, string $email_verified_token)
    {
        $this->password = $password;
        $this->rescipientMail = $rescipientMail;
        $this->email_verified_token = $email_verified_token;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            replyTo: [
                new Address($this->rescipientMail, 'Trung Dinh'),
            ],
            subject: 'Register Mail',
            using: [
                function (Email $email) {
                    // Headers
                    $email->getHeaders()
                        ->addTextHeader('X-Message-Source', 'example.com')
                        ->add(new UnstructuredHeader('X-Mailer', 'Mailtrap PHP Client'))
                    ;
                },
            ]
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.registerMail',
            with:
            [
            'password' => $this->password,
            'email_verified_token' => $this->email_verified_token,
            'email'=>$this->rescipientMail
            ],
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
