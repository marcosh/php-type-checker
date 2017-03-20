<?php

declare(strict_types = 1);

namespace Marcosh\PhpReturnTypeChecker\TypeHint;

use Marcosh\PhpReturnTypeChecker\Anomaly\MissingReturnType;
use Marcosh\PhpReturnTypeChecker\Anomaly\MissingReturnTypeWithDocBlock;
use Marcosh\PhpReturnTypeChecker\Anomaly\ReturnTypeDoesNotCoincideWithDocBlock;
use phpDocumentor\Reflection\Type;
use Roave\BetterReflection\Reflection\ReflectionFunction;
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
        if ($method->isConstructor() || $method->isDestructor()) {
            return;
        }

        yield from MissingReturnType::callable($method);
        //yield from MissingReturnTypeWithDocBlock::callable($method);
        //yield from ReturnTypeDoesNotCoincideWithDocBlock::callable($method);
    }

    public static function function(ReflectionFunction $function): \Iterator
    {
        yield from MissingReturnType::callable($function);
        //yield from MissingReturnTypeWithDocBlock::callable($function);
        //yield from ReturnTypeDoesNotCoincideWithDocBlock::callable($function);
    }

    /*private static function shouldNotify(ReflectionMethod $method): bool
    {
        return null === $method->getReturnType() ||
            self::returnTypeDoesNotCoincideWithDocBlock($method);
    }

    private static function returnTypeDoesNotCoincideWithDocBlock(ReflectionMethod $method): bool
    {
        $condition = !empty($method->getDocBlockReturnTypes()) &&
            !in_array($method->getReturnType()->getTypeObject(), $method->getDocBlockReturnTypes(), false);

        if ($condition) {
            var_dump(
                $method->getReturnType()->getTypeObject(),
                $method->getDocBlockReturnTypes(),
                in_array($method->getReturnType()->getTypeObject(), $method->getDocBlockReturnTypes(), true),
                in_array($method->getReturnType()->getTypeObject(), $method->getDocBlockReturnTypes(), false)
            );
        }

        return $condition;
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
    }*/
}
