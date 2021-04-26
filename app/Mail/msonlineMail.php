<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class msonlineMail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    public function __construct($details)
    {
        $this->details = $details;
    }


    public function build()
    {
        return $this->subject('Recebido Novo Agendamento de Sepultamento')
                    ->to( address: 'nilsonserafim@gmail.com', name: 'Administração Cemitério do Catumbi')
                    ->view('view.name');
    }
}

