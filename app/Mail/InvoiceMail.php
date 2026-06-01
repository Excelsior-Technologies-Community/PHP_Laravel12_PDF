<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pdfPath;

    public function __construct($pdfPath)
    {
        $this->pdfPath = $pdfPath;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Invoice is Ready',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.invoice_mail',
        );
    }

    public function attachments(): array
    {
        return [
            Attachment::fromPath($this->pdfPath)->as('Invoice.pdf')->withMime('application/pdf'),
        ];
    }
}