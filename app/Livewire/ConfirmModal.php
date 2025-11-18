<?php

namespace App\Livewire;

use Livewire\Component;

class ConfirmModal extends Component
{
    public bool $show = false;

    public array $data = [];

    protected $listeners = [
        'openConfirmModal' => 'openModal',
        'closeConfirmModal' => 'closeModal',
    ];

    public function openModal(array $data = []): void
    {
        if ($data === []) {
            return;
        }

        $this->data = $data;
        $this->show = true;
    }

    public function closeModal(): void
    {
        $this->show = false;
    }

    public function confirm(): void
    {
        if (! empty($this->data['confirmEvent'])) {
            $this->dispatch($this->data['confirmEvent']);
        }
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.confirm-modal');
    }
}
