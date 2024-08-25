<?php

namespace App\Mail;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class HighPriorityTaskNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function build()
    {
        return $this->subject('Notificación de Tarea de Alta Prioridad')
                    ->view('emails.high_priority_task')
                    ->with([
                        'task' => $this->task,
                    ]);
    }
}
