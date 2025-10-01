<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactResponseMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;
    public $responseMessage;

    public function __construct(Contact $contact, string $responseMessage)
    {
        $this->contact = $contact;
        $this->responseMessage = $responseMessage;
    }

    public function build()
    {
        return $this->markdown('emails.contact.response')
                    ->subject('Réponse à votre message - ' . config('app.name'));
    }
}
