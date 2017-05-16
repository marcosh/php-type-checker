<?php

declare(strict_types=1);

namespace Marcosh\PhpTypeChecker\Anomaly;

use Marcosh\PhpTypeChecker\Check\Parameter;
use Roave\BetterReflection\Reflection\ReflectionParameter;

final class MissingMethodParamTypeWithDocBlock implements Anomaly
{
    /**
     * @var ReflectionParameter
     */
    private $parameter;

    public function __construct(ReflectionParameter $parameter)
    {
        $this->parameter = $parameter;
    }

    public static function param(ReflectionParameter $parameter): \Generator
    {
        if ((new Parameter($parameter))->typeIsMissingWithDocBlock()) {
            yield new self($parameter);
        }
    }

    public function message(): string
    {
        try {
            $docBlockTypes = $this->parameter->getDocBlockTypes();
        } catch (\InvalidArgumentException $e) {
            // we need this here to prevent reflection-bocblock errors on @see invalid Fqsen
        }

        return sprintf(
            'Parameter <info>%s</info> of method <info>%s</info> of the class <info>%s</info> ' .
            'defined in <comment>%s</comment> does not have a type hint but has a boc block type of ' .
            '<info>%s</info>.',
            $this->parameter->getName(),
            $this->parameter->getDeclaringFunction()->getName(),
            $this->parameter->getDeclaringFunction()->getDeclaringClass()->getName(),
            $this->parameter->getDeclaringFunction()->getFileName(),
            implode($docBlockTypes)
        );
    }
}
