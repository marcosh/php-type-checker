<?php

declare(strict_types = 1);

namespace Marcosh\PhpTypeChecker\Anomaly;

use Marcosh\PhpTypeChecker\Check\FunctionAbstract;
use Roave\BetterReflection\Reflection\ReflectionFunction;

final class MissingFunctionReturnTypeWithDocBlock implements Anomaly
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
        if ((new FunctionAbstract($function))->missingReturnTypeWithDocBlock()) {
            yield new self($function);
        }
    }

    public function message(): string
    {
        try {
            $docBlockReturnTypes = $this->function->getDocBlockReturnTypes();
        } catch (\InvalidArgumentException $e) {
            // we need this here to prevent reflection-bocblock errors on @see invalid Fqsen
        }

        return sprintf(
            'Function <info>%s</info> defined in <comment>%s</comment> ' .
            'does not have a return type but has a doc block return type of <info>%s</info>.',
            $this->function->getName(),
            $this->function->getFileName(),
            implode($docBlockReturnTypes)
        );
    }
}
