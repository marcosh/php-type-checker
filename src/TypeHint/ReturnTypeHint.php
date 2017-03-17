<?php

declare(strict_types = 1);

namespace Marcosh\PhpReturnTypeChecker\TypeHint;

use phpDocumentor\Reflection\Type;
use Roave\BetterReflection\Reflection\ReflectionMethod;

final class ReturnTypeHint
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
        if (
            !$method->isConstructor() &&
            !$method->isDestructor() &&
            null === $method->getReturnType()
        ) {
            yield new self($method);
        }
    }

    public function message(): string
    {
        $docBlockReturnTypes = $this->method->getDocBlockReturnTypes();

        if (empty($docBlockReturnTypes)) {
            return sprintf(
                'Method <info>%s</info> of the class <info>%s</info> defined in <comment>%s</comment> does not have a return type.',
                $this->method->getName(),
                $this->method->getDeclaringClass()->getName(),
                $this->method->getFileName()
            );
        }

        $docBlockReturnTypes = implode(array_map(function (Type $type) {
            return (string) $type;
        }, $docBlockReturnTypes));

        return sprintf(
            'Method <info>%s</info> of the class <info>%s</info> defined in <comment>%s</comment> does not have a return type but has a doc block return type of <info>%s</info>.',
            $this->method->getName(),
            $this->method->getDeclaringClass()->getName(),
            $this->method->getFileName(),
            $docBlockReturnTypes
        );
    }
}
