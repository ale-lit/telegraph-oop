<?php

interface LoggerInterface
{
    function logMessage(string $error): void;
    function lastMessages(int $num): array;
}
