<?php

namespace App\Utils;

class File
{
    protected $filename;

    public function __construct(string $filename)
    {
        $this->filename = storage_path($filename);
    }

    public function toArray(): array
    {
        return file($this->filename, FILE_IGNORE_NEW_LINES);
    }
}