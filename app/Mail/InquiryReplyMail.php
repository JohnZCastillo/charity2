<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
class InquiryReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subjectText;
    public $messageText;
    public $inquiry;

    public function __construct($subjectText, $messageText, $inquiry)
    {
        $this->subjectText = $subjectText;
        $this->messageText = $messageText;
        $this->inquiry = $inquiry;
    }

    public function build()
    {
        return $this->subject($this->subjectText)
                    ->view('emails.inquiry_reply')
                    ->with([
                        'messageText' => $this->messageText,
                        'inquiry' => $this->inquiry,
                    ]);
    }
}
