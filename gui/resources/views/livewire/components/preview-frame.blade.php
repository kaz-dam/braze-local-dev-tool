<?php

use Livewire\Volt\Component;
use App\Enums\FrameSize;

new class extends Component {
    public $src = '';

    public $scale = 1;

    public function getListeners()
    {
        return [
            'echo-private:file.watcher,FileUpdatedEvent' => 'onRefresh',
        ];
    }

    public function onRefresh($event)
    {
        dd($event);
        $this->src = $event['path'];
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
