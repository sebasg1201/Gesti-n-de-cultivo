<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

use Illuminate\Mail\Mailables\Attachment;

class AdminCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $adminName;
    public $email;
    public $password;
    public $empresaName;
    public $planName;
    public $pdfContent;

    /**
     * Create a new message instance.
     */
    public function __construct($adminName, $email, $password, $empresaName, $planName, $pdfContent)
    {
        $this->adminName = $adminName;
        $this->email = $email;
        $this->password = $password;
        $this->empresaName = $empresaName;
        $this->planName = $planName;
        $this->pdfContent = $pdfContent;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Credenciales de Administrador - ' . $this->empresaName,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.admin.created',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromData(fn() => $this->pdfContent, 'Credenciales_Administrador.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
