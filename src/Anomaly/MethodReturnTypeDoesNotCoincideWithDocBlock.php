<?php

declare(strict_types = 1);

namespace Marcosh\PhpReturnTypeChecker\Anomaly;

use Roave\BetterReflection\Reflection\ReflectionMethod;
use Roave\BetterReflection\Reflection\ReflectionType;

final class MethodReturnTypeDoesNotCoincideWithDocBlock implements Anomaly
{
    /**
     * @var ReflectionMethod
     */
    private $method;

    private function __construct(ReflectionMethod $method)
    {
        $this->method = $method;
    }

    public static function method(ReflectionMethod $method): \Iterator
    {
        try {
            $docBlockReturnTypes = $method->getDocBlockReturnTypes();
        } catch (\InvalidArgumentException $e) {
            // we need this here to prevent reflection-bocblock errors on @see invalid Fqsen
        }

        if (
            !empty($docBlockReturnTypes) &&
            $method->getReturnType() instanceof ReflectionType &&
            !in_array($method->getReturnType()->getTypeObject(), $docBlockReturnTypes, false)
        ) {
            yield new self($method);
        }
    }

    public function message(): string
    {
        try {
            $docBlockReturnTypes = $this->method->getDocBlockReturnTypes();
        } catch (\InvalidArgumentException $e) {
            // we need this here to prevent reflection-bocblock errors on @see invalid Fqsen
        }

        return sprintf(
            'Method <info>%s</info> of the class <info>%s</info> defined ' .
            'in <comment>%s</comment> has a <info>%s</info> return type, ' .
            'but has a <info>%s</info> return doc block.',
            $this->method->getName(),
            $this->method->getDeclaringClass()->getName(),
            $this->method->getFileName(),
            $this->method->getReturnType(),
            implode($docBlockReturnTypes)
        );
    }
}
