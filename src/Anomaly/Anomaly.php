<?php

declare(strict_types = 1);

namespace Marcosh\PhpTypeChecker\Anomaly;

interface Anomaly
{
    public function message(): string;
}
