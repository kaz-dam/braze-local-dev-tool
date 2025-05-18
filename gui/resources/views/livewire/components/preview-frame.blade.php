<?php

use Livewire\Volt\Component;
use Illuminate\Support\Facades\Log;
use App\Enums\FrameSize;

new class extends Component {
    public $src = '';

    public $fileName = '';

    public $scale = 1;

    public function mount(string $fileName)
    {
        $this->fileName = $fileName;
        $this->src = route('preview.render', ['fileName' => $fileName]);
    }

    public function getListeners()
    {
        return [
            'echo:file.watcher,.App\\Events\\FileUpdatedEvent' => 'onRefresh',
        ];
    }

    public function onRefresh($event)
    {
        Log::info($event);
    }
}; ?>

<div class="flex justify-center items-center w-full h-screen">
    <div class="h-[630px] overflow-hidden border-2 border-slate-400 grid" style="width: {{ FrameSize::MOBILE->value }}px;">
        <iframe
            src="{{ $src }}"
            style="width: {{ $scale * 100}}%; height: {{ $scale * 100 }}%; transform: scale({{ 1 / $scale }}); transformOrigin: 0 0;"
            class="bg-slate-100"
        ></iframe>
    </div>
</div>
