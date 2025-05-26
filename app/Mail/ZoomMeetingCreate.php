<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ZoomMeetingCreate extends Mailable
{
    use Queueable, SerializesModels;
    
    public $data;  
    public $user;  
    public $isProfessional; 
 
    public function __construct($data, $user, $isProfessional = false)
    {
        $this->data = $data;
        $this->user = $user;
        $this->isProfessional = $isProfessional;
    }
 
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Zoom Meeting Invitation: ' . $this->data['topic'],
        );
    }
 
    public function content(): Content
    {
        return new Content(
            view: 'emails.zoom_meeting_create',  
        );
    }

   
    public function attachments(): array
    {
        return [];
    }
}
