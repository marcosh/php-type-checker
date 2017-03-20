<?php

declare(strict_types = 1);

namespace Marcosh\PhpReturnTypeChecker\Anomaly;

interface Anomaly
{
    public function message(): string;
}
