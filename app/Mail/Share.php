<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Share extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * QrCode
     * @var string
     */
    public $url;

    /**
     * Placed uuid
     * @var string
     */
    public $uuid;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $url, string $id)
    {
        $this->url = $url;
        $this->uuid = $id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.share', [
            'uuid' => $this->uuid,
        ]);
        // return $this->markdown('emails.share');
    }
}
