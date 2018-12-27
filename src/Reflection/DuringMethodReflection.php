<?php

declare(strict_types=1);

namespace Proget\PHPStan\PhpSpec\Reflection;

use PHPStan\Reflection\ClassMemberReflection;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\FunctionVariant;
use PHPStan\Reflection\MethodReflection;

final class DuringMethodReflection implements MethodReflection
{
    /**
     * @var MethodReflection
     */
    private $during;

    public function __construct(MethodReflection $during)
    {
        $this->during = $during;
    }

    public function getDeclaringClass(): ClassReflection
    {
        return $this->during->getDeclaringClass();
    }

    public function isStatic(): bool
    {
        return $this->during->isStatic();
    }

    public function isPrivate(): bool
    {
        return $this->during->isPrivate();
    }

    public function isPublic(): bool
    {
        return $this->during->isPublic();
    }

    public function getName(): string
    {
        return $this->during->getName();
    }

    public function getPrototype(): ClassMemberReflection
    {
        return $this->during->getPrototype();
    }

    public function getVariants(): array
    {
        $variants = $this->during->getVariants();
        if (count($variants) === 1 && $variants[0] instanceof FunctionVariant) {
            return [new FunctionVariant(
                [], // todo: maybe we can check if magic "during*" params count is correct?
                true,
                $variants[0]->getReturnType()
            )];
        }

        return $variants;
    }
}
