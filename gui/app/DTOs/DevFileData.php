<?php

namespace App\DTOs;

use Spatie\DataTransferObject\DataTransferObject;
use Livewire\Wireable;

class DevFileData extends DataTransferObject implements Wireable
{
    public readonly string $name;
    public readonly string $path;

    public function toLivewire(): array
    {
        return [
            'name' => $this->name,
            'path' => $this->path,
        ];
    }

    public static function fromLivewire($payload): static
    {
        return new static([
            'name' => $payload['name'],
            'path' => $payload['path'],
        ]);
    }
}
