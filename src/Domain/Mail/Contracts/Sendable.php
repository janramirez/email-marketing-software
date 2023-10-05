<?php

namespace Domain\Mail\Contracts;

interface Sendable
{
    public function id(): int;
    public function type(): string;
}