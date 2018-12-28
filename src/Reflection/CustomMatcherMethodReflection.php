<?php

declare(strict_types=1);

namespace Proget\PHPStan\PhpSpec\Reflection;

use PHPStan\Reflection\ClassMemberReflection;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\FunctionVariant;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\VoidType;

final class CustomMatcherMethodReflection implements MethodReflection
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var ClassReflection
     */
    private $classReflection;

    public function __construct(string $name, ClassReflection $classReflection)
    {
        $this->name = $name;
        $this->classReflection = $classReflection;
    }

    public function getDeclaringClass(): ClassReflection
    {
        return $this->classReflection;
    }

    public function isStatic(): bool
    {
        return false;
    }

    public function isPrivate(): bool
    {
        return false;
    }

    public function isPublic(): bool
    {
        return true;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrototype(): ClassMemberReflection
    {
        return $this;
    }

    public function getVariants(): array
    {
        return [
            new FunctionVariant([], true, new VoidType())
        ];
    }
}
