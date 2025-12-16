<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentRescheduleMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subjectText;
    public $messageText;
    public $name;

    /**
     * Create a new message instance.
     */
    public function __construct($subjectText, $messageText, $name)
    {
        $this->subjectText = $subjectText;
        $this->messageText = $messageText;
        $this->name = $name;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject($this->subjectText)
                    ->view('emails.appointment_reschedule')
                    ->with([
                        'messageText' => $this->messageText,
                        'name' => $this->name,
                    ]);
    }
}
