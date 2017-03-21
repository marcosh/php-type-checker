<?php

declare(strict_types = 1);

namespace Marcosh\PhpReturnTypeChecker\Anomaly;

use Roave\BetterReflection\Reflection\ReflectionFunctionAbstract;
use Roave\BetterReflection\Reflection\ReflectionMethod;

final class MissingMethodReturnType implements Anomaly
{
    /**
     * @var ReflectionMethod
     */
    private $method;

    public function __construct(ReflectionMethod $method)
    {
        $this->method = $method;
    }

    public static function method(ReflectionMethod $method): \Iterator
    {
        try {
            if (null === $method->getReturnType() && empty($method->getDocBlockReturnTypes())) {
                yield new self($method);
            }
        } catch (\InvalidArgumentException $e) {
            // we need this here to prevent reflection-bocblock errors on @see invalid Fqsen
        }
    }

    public function message(): string
    {
        return sprintf(
            'Method <info>%s</info> of the class <info>%s</info> defined ' .
            'in <comment>%s</comment> does not have a return type.',
            $this->method->getName(),
            $this->method->getDeclaringClass()->getName(),
            $this->method->getFileName()
        );
    }
}
