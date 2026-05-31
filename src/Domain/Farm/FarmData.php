<?php

namespace App\Domain\Farm;

class FarmData
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly ?string $description
    ) {}

    public static function fromModel(Farm $farm): self
    {
        return new self(
            $farm->id,
            $farm->name,
            $farm->description
        );
    }
}
