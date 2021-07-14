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

    public function getDocComment(): ?string
    {
        return  $this->wrappedReflection->getDocComment();
    }

    public function getReadableType(): \PHPStan\Type\Type
    {
        return new CollaboratorPropertyType($this->wrappedReflection->getReadableType());
    }

    public function getWritableType(): \PHPStan\Type\Type
    {
        return new CollaboratorPropertyType($this->wrappedReflection->getWritableType());
    }

    public function isReadable(): bool
    {
        return $this->wrappedReflection->isReadable();
    }

    public function isWritable(): bool
    {
        return $this->wrappedReflection->isWritable();
    }

    public function canChangeTypeAfterAssignment(): bool
    {
        return $this->wrappedReflection->canChangeTypeAfterAssignment();
    }

    public function isInternal(): \PHPStan\TrinaryLogic
    {
        return $this->wrappedReflection->isInternal();
    }

    public function isDeprecated(): \PHPStan\TrinaryLogic
    {
        return $this->wrappedReflection->isDeprecated();
    }

    public function getDeprecatedDescription(): ?string
    {
        return $this->wrappedReflection->getDeprecatedDescription();
    }
}
