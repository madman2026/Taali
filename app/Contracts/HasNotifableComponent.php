<?php

namespace App\Contracts;

trait HasNotifableComponent
{
    public function success(string $title , mixed $message)
    {
        $this->notif('success' , $title , $message);
    }

    public function error(string $title , mixed $message)
    {
        $this->notif('error' , $title , $message);
    }

    public function warning(string $title , mixed $message)
    {
        $this->notif('warning' , $title , $message);
    }

    public function notif($status , $title , mixed $message = null)
    {
        $this->dispatch('toastMagic' , status: $status , title: $title , message: $message);
    }
}
