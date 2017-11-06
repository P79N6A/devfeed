<?php

namespace Fedn\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendSpecials extends Mailable
{
    use Queueable, SerializesModels;
    protected $special;
    protected $articles;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($special,$articles)
    {
        $this->special = $special;
        $this->articles = $articles;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.special-preview')
                    ->subject($this->special->title)
                    ->with([
                        'special'=>$this->special,
                        'articles'=>$this->articles
                    ]);
    }
}
