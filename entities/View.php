<?php

abstract class View
{
    public $storage;

    public function __construct(Storage $object)
    {
        $this->storage = $object;
    }

    abstract public function displayTextById(string $id): string;
    abstract public function displayTextByUrl(string $url): string;
}
