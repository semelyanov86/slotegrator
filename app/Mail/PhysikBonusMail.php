<?php

declare(strict_types=1);


namespace App\Mail;

use Illuminate\Mail\Mailable;

final class PhysikBonusMail extends Mailable
{
    public function __construct()
    {
        //
    }

    public function build()
    {
        return $this->markdown('emails.physik-bonus');
    }
}
