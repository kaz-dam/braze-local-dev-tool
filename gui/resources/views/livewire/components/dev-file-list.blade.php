<?php

use Livewire\Volt\Component;
use App\Services\FileHandlingService;

new class extends Component {
    public $devFiles;

    public function mount(FileHandlingService $fileHandlingService)
    {
        $this->devFiles = $fileHandlingService->getDevFileList();
    }
}; ?>

<div class="flex flex-col">
    @foreach ($devFiles as $file)
        <a href="{{ url('/?file=' . urlencode($file->name)) }}">{{ $file->name }}</a>
    @endforeach
</div>
