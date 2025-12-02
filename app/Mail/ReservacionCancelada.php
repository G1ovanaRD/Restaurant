<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservacionCancelada extends Mailable
{
    use Queueable, SerializesModels;

    public $reservacion;
    public $cliente;

    public function __construct($reservacion, $cliente = null)
    {
        $this->reservacion = $reservacion;
        $this->cliente = $cliente;
    }

    public function envelope(): Envelope
    {
        $subject = 'Cancelación de reservación';
        if ($this->reservacion && isset($this->reservacion->id)) {
            $subject .= ' #' . $this->reservacion->id;
        }

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.reservacion_cancelada',
            with: [
                'reservacion' => $this->reservacion,
                'cliente' => $this->cliente,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
