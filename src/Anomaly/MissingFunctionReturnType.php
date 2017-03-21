<?php

declare(strict_types = 1);

namespace Marcosh\PhpReturnTypeChecker\Anomaly;

use Roave\BetterReflection\Reflection\ReflectionFunction;

final class MissingFunctionReturnType
{
    /**
     * @var ReflectionFunction
     */
    private $function;

    public function __construct(ReflectionFunction $function)
    {
        $this->function = $function;
    }

    public static function function(ReflectionFunction $function): \Iterator
    {
        try {
            if (null === $function->getReturnType() && empty($function->getDocBlockReturnTypes())) {
                yield new self($function);
            }
        } catch (\InvalidArgumentException $e) {
            // we need this here to prevent reflection-bocblock errors on @see invalid Fqsen
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
