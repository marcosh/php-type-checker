<?php

declare(strict_types = 1);

namespace Marcosh\PhpReturnTypeChecker\TypeHint;

interface TypeHint
{
    public function message(): string;
}
