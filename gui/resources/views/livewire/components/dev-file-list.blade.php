<?php

use Livewire\Volt\Component;
use App\Services\FileHandlingService;

new class extends Component {
    public $devFiles = [];

    public function mount()
    {
        $this->devFiles = (new FileHandlingService)->getDevFileList();
    }
}; ?>

<div class="flex flex-col">
    @foreach ($devFiles as $file)
        <a href="{{ url('/?file=' . urlencode($file['name'])) }}">{{ $file['name'] }}</a>
    @endforeach
</div>
