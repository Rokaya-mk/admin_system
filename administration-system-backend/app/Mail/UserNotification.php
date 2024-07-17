<?php

namespace App\Mail;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Termwind\Components\Dd;

class UserNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;


    /**
     * Create a new message instance.
     */
    public function __construct( protected Project $project, protected string $title)
    {
       
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'User Notification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail',
            with: [
                'projectName' => $this->project->name,
                'projectStatus' => $this->project->status,
                'projectDate' => $this->project->created_at,
                'projectDescription' => $this->project->description,
                'title' => $this->title
                
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
