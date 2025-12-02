<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Reservacion extends Mailable
{
    use Queueable, SerializesModels;

    public $reservacion;
    public $cliente;

    /**
     * Create a new message instance.
     */
    public function __construct($reservacion, $cliente = null)
    {
        $this->reservacion = $reservacion;
        $this->cliente = $cliente;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = 'Confirmación de reservación';
        if ($this->reservacion && isset($this->reservacion->id)) {
            $subject .= ' #' . $this->reservacion->id;
        }

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.reservacion',
            with: [
                'reservacion' => $this->reservacion,
                'cliente' => $this->cliente,
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
