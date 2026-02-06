<?php

namespace App\Mail;

use App\Models\Product;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Email newsletter mingguan untuk customer.
 */
class WeeklyNewsletterMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public User $user
    ) {
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🎸 Katalog Gitar Terbaru Minggu Ini!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // Ambil 4 produk terbaru
        $latestProducts = Product::with('category')
            ->inStock()
            ->latest()
            ->take(4)
            ->get();

        return new Content(
            view: 'emails.weekly-newsletter',
            with: [
                'user' => $this->user,
                'products' => $latestProducts,
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
