<?php

declare(strict_types=1);

namespace Proget\PHPStan\PhpSpec\Reflection;

use PHPStan\Reflection\ClassMemberReflection;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\FunctionVariant;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\ObjectType;

final class GetWrappedObjectMethodReflection implements MethodReflection
{
    /**
     * @var MethodReflection
     */
    private $methodReflection;

    /**
     * @var string
     */
    private $wrappedClass;

    public function __construct(MethodReflection $methodReflection, string $wrappedClass)
    {
        $this->methodReflection = $methodReflection;
        $this->wrappedClass = $wrappedClass;
    }

    public function getDeclaringClass(): ClassReflection
    {
        return $this->methodReflection->getDeclaringClass();
    }

    public function isStatic(): bool
    {
        return $this->methodReflection->isStatic();
    }

    public function isPrivate(): bool
    {
        return $this->methodReflection->isPrivate();
    }

    public function isPublic(): bool
    {
        return $this->methodReflection->isPublic();
    }

    public function getName(): string
    {
        return $this->methodReflection->getName();
    }

    public function getPrototype(): ClassMemberReflection
    {
        return $this->methodReflection->getPrototype();
    }

    public function getVariants(): array
    {
        $variant = $this->methodReflection->getVariants()[0];

        return [
            new FunctionVariant(
                $variant->getParameters(),
                $variant->isVariadic(),
                new ObjectType($this->wrappedClass)
            )
        ];
    }
}
