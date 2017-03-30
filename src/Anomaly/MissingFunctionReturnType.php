<?php

declare(strict_types = 1);

namespace Marcosh\PhpTypeChecker\Anomaly;

use Marcosh\PhpTypeChecker\Check\FunctionAbstract;
use Roave\BetterReflection\Reflection\ReflectionFunction;

final class MissingFunctionReturnType implements Anomaly
{
    /**
     * @var ReflectionFunction
     */
    private $function;

    private function __construct(ReflectionFunction $function)
    {
        $this->function = $function;
    }

    public static function function(ReflectionFunction $function): \Iterator
    {
        if ((new FunctionAbstract($function))->missingReturnType()) {
            yield new self($function);
        }
    }

    public function message(): string
    {
        return sprintf(
            'Function <info>%s</info> defined in <comment>%s</comment> does ' .
            'not have a return type.',
            $this->function->getName(),
            $this->function->getFileName()
        );
    }
}
