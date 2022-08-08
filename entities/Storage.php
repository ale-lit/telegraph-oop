<?php

require_once './interfaces/EventListenerInterface.php';
require_once './interfaces/LoggerInterface.php';

abstract class Storage implements LoggerInterface, EventListenerInterface
{
    abstract public function create(Text $object): string;
    abstract public function read(string $slug): Text;
    abstract public function update(string $slug, Text $data): void;
    abstract public function delete(string $slug): void;
    abstract public function list(): array;
}
