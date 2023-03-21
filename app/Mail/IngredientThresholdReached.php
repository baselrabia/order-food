<?php

namespace App\Mail;

use App\Models\Ingredient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class IngredientThresholdReached extends Mailable
{
    use Queueable, SerializesModels;

    public Ingredient $ingredient;

    /**
     * Create a new message instance.
     *
     * @param Ingredient $ingredient
     */
    public function __construct(Ingredient $ingredient)
    {
        $this->ingredient = $ingredient;
     }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            to: "merchent@example.com",
            subject: 'Ingredient Threshold Reached',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.ingredient-threshold-reached',
            with: [
                'ingredient' => $this->ingredient,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
