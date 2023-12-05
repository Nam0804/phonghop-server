<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Symfony\Component\Mime\Header\UnstructuredHeader;
use Symfony\Component\Mime\Email;
use Illuminate\Queue\SerializesModels;

class SendCreateMail extends Mailable
{
    use Queueable, SerializesModels;
    protected string $password;
    protected string $recipientMail;
    protected string $name;
    /**
     * Create a new message instance.
     */
    public function __construct(string $recipientMail, string $password, string $name)
    {
        $this->recipientMail = $recipientMail;
        $this->password = $password;
        $this->name = $name;
    }


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Send Create Mail',
            replyTo: [
                new Address($this->recipientMail, 'Trung Dinh'),
            ],
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
            view: 'email.createNewStaff',
            with:
            [
            'password' => $this->password,
            'name' => $this->name,
            'email'=>$this->recipientMail
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
