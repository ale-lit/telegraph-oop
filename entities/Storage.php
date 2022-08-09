<?php

require_once './interfaces/EventListenerInterface.php';
require_once './interfaces/LoggerInterface.php';

abstract class Storage implements LoggerInterface, EventListenerInterface
{
    abstract public function create(TelegraphText $object): string;
    abstract public function read(string $slug): TelegraphText;
    abstract public function update(string $slug, TelegraphText $data): void;
    abstract public function delete(string $slug): void;
    abstract public function list(): array;
}
