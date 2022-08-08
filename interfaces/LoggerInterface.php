<?php

interface LoggerInterface
{
    public function logMessage(string $error): void;
    public function lastMessages(int $num): array;
}
