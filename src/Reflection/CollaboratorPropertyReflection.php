<?php

declare(strict_types=1);

namespace Proget\PHPStan\PhpSpec\Reflection;

use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\PropertyReflection;
use PHPStan\Type\Type;
use Proget\PHPStan\PhpSpec\Type\CollaboratorPropertyType;

final class CollaboratorPropertyReflection implements PropertyReflection
{
    /**
     * @var PropertyReflection
     */
    private $wrappedReflection;

    public function __construct(PropertyReflection $wrappedReflection)
    {
        $this->wrappedReflection = $wrappedReflection;
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

    public function getType(): Type
    {
        return new CollaboratorPropertyType($this->wrappedReflection->getType());
    }

    public function isReadable(): bool
    {
        return $this->wrappedReflection->isReadable();
    }

    public function isWritable(): bool
    {
        return $this->wrappedReflection->isWritable();
    }
}
