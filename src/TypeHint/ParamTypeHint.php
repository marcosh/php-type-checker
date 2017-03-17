<?php

declare(strict_types = 1);

namespace Marcosh\PhpReturnTypeChecker\TypeHint;

use BetterReflection\Reflection\ReflectionParameter;

final class ParamTypeHint implements TypeHint
{
    /**
     * @var ReflectionParameter
     */
    private $parameter;

    public function __construct(ReflectionParameter $parameter)
    {
        $this->parameter = $parameter;
    }

    public static function param(ReflectionParameter $parameter): \Iterator
    {
        if (!$parameter->hasType()) {
            yield new self($parameter);
        }
    }

    public function message(): string
    {
        $docBlockTypes = $this->parameter->getDocBlockTypeStrings();

        if (empty($docBlockTypes)) {
            return sprintf(
                'Parameter <info>%s</info> of method <info>%s</info> of class <info>%s</info> defined in <comment>%s</comment> does not have a type',
                $this->parameter->getName(),
                $this->parameter->getDeclaringFunction()->getName(),
                $this->parameter->getDeclaringClass()->getName(),
                $this->parameter->getDeclaringClass()->getFileName()
            );
        }

        return sprintf(
            'Parameter <info>%s</info> of method <info>%s</info> of class <info>%s</info> defined in <comment>%s</comment> does not have a type, but has a doc clock type of <info>%s</info>',
            $this->parameter->getName(),
            $this->parameter->getDeclaringFunction()->getName(),
            $this->parameter->getDeclaringClass()->getName(),
            $this->parameter->getDeclaringClass()->getFileName(),
            implode($docBlockTypes)
        );
    }
}
