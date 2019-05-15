<?php

declare(strict_types=1);

namespace Proget\PHPStan\PhpSpec\Type;

use PHPStan\Broker\Broker;
use PHPStan\Reflection\ClassMemberAccessAnswerer;
use PHPStan\Reflection\ConstantReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\PropertyReflection;
use PHPStan\TrinaryLogic;
use PHPStan\Type\BooleanType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use PHPStan\Type\VerbosityLevel;
use Proget\PHPStan\PhpSpec\Reflection\CollaboratorMethodReflection;
use Proget\PHPStan\PhpSpec\Wrapper\SpoofedCollaborator;

final class CollaboratorPropertyType implements Type
{
    /**
     * @var Type
     */
    private $wrappedType;

    public function __construct(Type $wrappedType)
    {
        $this->wrappedType = $wrappedType;
    }

    public function isIterableAtLeastOnce(): TrinaryLogic
    {
        return $this->wrappedType->isIterableAtLeastOnce();
    }

    public function getReferencedClasses(): array
    {
        return $this->wrappedType->getReferencedClasses();
    }

    public function accepts(Type $type, bool $strictTypes): TrinaryLogic
    {
        if ($type instanceof ObjectType && $type->isInstanceOf(SpoofedCollaborator::class)->yes()) {
            return TrinaryLogic::createYes();
        }

        return $this->wrappedType->accepts($type, $strictTypes);
    }

    public function isSuperTypeOf(Type $type): TrinaryLogic
    {
        return $this->wrappedType->isSuperTypeOf($type);
    }

    public function equals(Type $type): bool
    {
        return $this->wrappedType->equals($type);
    }

    public function describe(VerbosityLevel $level): string
    {
        return sprintf('%s<%s>', 'CollaboratorProperty', $this->wrappedType->describe($level));
    }

    public function canAccessProperties(): TrinaryLogic
    {
        return $this->wrappedType->canAccessProperties();
    }

    public function hasProperty(string $propertyName): TrinaryLogic
    {
        return $this->wrappedType->hasProperty($propertyName);
    }

    public function getProperty(string $propertyName, ClassMemberAccessAnswerer $scope): PropertyReflection
    {
        return $this->wrappedType->getProperty($propertyName, $scope);
    }

    public function canCallMethods(): TrinaryLogic
    {
        return TrinaryLogic::createYes();
    }

    public function hasMethod(string $methodName): TrinaryLogic
    {
        if (count($this->wrappedType->getReferencedClasses()) === 0) {
            return TrinaryLogic::createNo();
        }

        $broker = Broker::getInstance();

        return TrinaryLogic::createFromBoolean($broker->getClass($this->wrappedType->getReferencedClasses()[0])->hasMethod($methodName));
    }

    public function getMethod(string $methodName, ClassMemberAccessAnswerer $scope): MethodReflection
    {
        $broker = Broker::getInstance();

        return new CollaboratorMethodReflection($broker->getClass($this->wrappedType->getReferencedClasses()[0])->getMethod($methodName, $scope));
    }

    public function canAccessConstants(): TrinaryLogic
    {
        return $this->wrappedType->canAccessConstants();
    }

    public function hasConstant(string $constantName): TrinaryLogic
    {
        return $this->wrappedType->hasConstant($constantName);
    }

    public function getConstant(string $constantName): ConstantReflection
    {
        return $this->wrappedType->getConstant($constantName);
    }

    public function isIterable(): TrinaryLogic
    {
        return $this->wrappedType->isIterable();
    }

    public function getIterableKeyType(): Type
    {
        return $this->wrappedType->getIterableKeyType();
    }

    public function getIterableValueType(): Type
    {
        return $this->wrappedType->getIterableValueType();
    }

    public function isOffsetAccessible(): TrinaryLogic
    {
        return $this->wrappedType->isOffsetAccessible();
    }

    public function hasOffsetValueType(Type $offsetType): TrinaryLogic
    {
        return $this->wrappedType->hasOffsetValueType($offsetType);
    }

    public function getOffsetValueType(Type $offsetType): Type
    {
        return $this->wrappedType->getOffsetValueType($offsetType);
    }

    public function setOffsetValueType(?Type $offsetType, Type $valueType): Type
    {
        return $this->wrappedType->setOffsetValueType($offsetType, $valueType);
    }

    public function isCallable(): TrinaryLogic
    {
        return $this->wrappedType->isCallable();
    }

    public function getCallableParametersAcceptors(ClassMemberAccessAnswerer $scope): array
    {
        return $this->wrappedType->getCallableParametersAcceptors($scope);
    }

    public function isCloneable(): TrinaryLogic
    {
        return $this->wrappedType->isCloneable();
    }

    public function toBoolean(): BooleanType
    {
        return $this->wrappedType->toBoolean();
    }

    public function toNumber(): Type
    {
        return $this->wrappedType->toNumber();
    }

    public function toInteger(): Type
    {
        return $this->wrappedType->toInteger();
    }

    public function toFloat(): Type
    {
        return $this->wrappedType->toFloat();
    }

    public function toString(): Type
    {
        return $this->wrappedType->toString();
    }

    public function toArray(): Type
    {
        return $this->wrappedType->toArray();
    }

    public static function __set_state(array $properties): Type
    {
        return new self($properties['wrappedType']);
    }
}
