<?php

declare(strict_types = 1);

namespace Marcosh\PhpTypeChecker\Anomaly;

use Marcosh\PhpTypeChecker\Check\Parameter;
use Roave\BetterReflection\Reflection\ReflectionParameter;

final class MissingFunctionParamType implements Anomaly
{
    /**
     * @var ReflectionParameter
     */
    private $parameter;

    private function __construct(ReflectionParameter $parameter)
    {
        $this->parameter = $parameter;
    }

    public static function param(ReflectionParameter $parameter): \Iterator
    {
        if ((new Parameter($parameter))->typeIsMissing()) {
            yield new self($parameter);
        }
    }

    public function message(): string
    {
        return sprintf(
            'Parameter <info>%s</info> of function <info>%s</info> defined in <comment>%s</comment> ' .
            'does not have a type hint.',
            $this->parameter->getName(),
            $this->parameter->getDeclaringFunction()->getName(),
            $this->parameter->getDeclaringFunction()->getFileName()
        );
    }
}
