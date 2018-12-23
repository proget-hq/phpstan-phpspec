<?php

declare(strict_types=1);

namespace Proget\PHPStan\PhpSpec\Reflection;

use PHPStan\Reflection\ClassMemberReflection;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\MethodReflection;

final class ObjectBehaviorMethodReflection implements MethodReflection
{
    /**
     * @var MethodReflection
     */
    private $wrappedReflection;

    public function __construct(MethodReflection $wrappedReflection)
    {
        $this->wrappedReflection = $wrappedReflection;
    }

    public function wrappedReflection(): MethodReflection
    {
        return $this->wrappedReflection;
    }

    public function getDeclaringClass(): ClassReflection
    {
        return $this->wrappedReflection->getDeclaringClass();
    }

    public function isStatic(): bool
    {
        return $this->wrappedReflection->isStatic();
    }

    public function isPrivate(): bool
    {
        return $this->wrappedReflection->isPrivate();
    }

    public function isPublic(): bool
    {
        return $this->wrappedReflection->isPublic();
    }

    public function getName(): string
    {
        return $this->wrappedReflection->getName();
    }

    public function getPrototype(): ClassMemberReflection
    {
        return $this->wrappedReflection->getPrototype();
    }

    public function getVariants(): array
    {
        return $this->wrappedReflection->getVariants();
    }
}
