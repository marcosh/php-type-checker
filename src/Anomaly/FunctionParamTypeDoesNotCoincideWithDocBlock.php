<?php

declare(strict_types=1);

namespace Marcosh\PhpReturnTypeChecker\Anomaly;

use phpDocumentor\Reflection\Type;
use Roave\BetterReflection\Reflection\ReflectionParameter;

final class FunctionParamTypeDoesNotCoincideWithDocBlock
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
        try {
            $docBlockTypes = $parameter->getDocBlockTypes();
        } catch (\InvalidArgumentException $e) {
            // we need this here to prevent reflection-bocblock errors on @see invalid Fqsen
        }

        if (
            !empty($docBlockTypes) &&
            $parameter->getTypeHint() instanceof Type &&
            !in_array($parameter->getTypeHint(), $docBlockTypes, false)
        ) {
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
            'Parameter <info>%s</info> of function <info>%s</info> ' .
            'defined in <comment>%s</comment>  has a <info>%s</info> type hint, ' .
            'but has a <info>%s</info> doc block type.',
            $this->parameter->getName(),
            $this->parameter->getDeclaringFunction()->getName(),
            $this->parameter->getDeclaringFunction()->getFileName(),
            $this->parameter->getTypeHint(),
            implode($docBlockTypes)
        );
    }
}
