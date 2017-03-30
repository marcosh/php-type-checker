<?php

declare(strict_types = 1);

namespace Marcosh\PhpTypeChecker\Anomaly;

use Marcosh\PhpTypeChecker\Check\FunctionAbstract;
use Roave\BetterReflection\Reflection\ReflectionMethod;

final class MissingMethodReturnType implements Anomaly
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
        if ((new FunctionAbstract($method))->missingReturnType()) {
            yield new self($method);
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
