<?php

declare(strict_types = 1);

namespace Marcosh\PhpReturnTypeChecker\Anomaly;

use Roave\BetterReflection\Reflection\ReflectionFunctionAbstract;
use Roave\BetterReflection\Reflection\ReflectionMethod;

final class MissingReturnType implements Anomaly
{
    /**
     * @var ReflectionFunctionAbstract
     */
    private $callable;

    public function __construct(ReflectionFunctionAbstract $callable)
    {
        $this->callable = $callable;
    }

    public static function callable(ReflectionFunctionAbstract $callable): \Iterator
    {
        try {
            if (null === $callable->getReturnType() && empty($callable->getDocBlockReturnTypes())) {
                yield new self($callable);
            }
        } catch (\InvalidArgumentException $e) {
        }
    }

    public function message(): string
    {
        if ($this->callable instanceof ReflectionMethod) {
            return sprintf(
                'Method <info>%s</info> of the class <info>%s</info> defined ' .
                'in <comment>%s</comment> does not have a return type.',
                $this->callable->getName(),
                $this->callable->getDeclaringClass()->getName(),
                $this->callable->getFileName()
            );
        }

        return sprintf(
            'Function <info>%s</info> defined in <comment>%s</comment> does ' .
            'not have a return type.',
            $this->callable->getName(),
            $this->callable->getFileName()
        );
    }
}
