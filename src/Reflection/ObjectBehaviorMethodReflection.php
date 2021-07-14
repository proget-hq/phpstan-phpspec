<?php

declare(strict_types=1);

namespace Proget\PHPStan\PhpSpec\Reflection;

use PHPStan\Reflection\ClassMemberReflection;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\FunctionVariant;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\Native\NativeParameterReflection;
use PHPStan\Reflection\ParameterReflection;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
use Proget\PHPStan\PhpSpec\Wrapper\SpoofedCollaborator;

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
        $variant = $this->wrappedReflection->getVariants()[0];

        $parameters = array_map(function (ParameterReflection $parameter) {
            return new NativeParameterReflection(
                $parameter->getName(),
                true,
                $this->mergeWithCollaborator($parameter->getType()),
                $parameter->passedByReference(),
                $parameter->isVariadic(),
                $parameter->getDefaultValue()
            );
        }, $variant->getParameters());

        return [
            new FunctionVariant(
                $variant->getTemplateTypeMap(),
                $variant->getResolvedTemplateTypeMap(),
                $parameters,
                $variant->isVariadic(),
                $variant->getReturnType()
            )
        ];
    }

    private function mergeWithCollaborator(Type $type): Type
    {
        $types = [
            new ObjectType(SpoofedCollaborator::class)
        ];

        if ($type instanceof UnionType) {
            foreach ($type->getTypes() as $unionType) {
                $types[] = $unionType;
            }
        } else {
            $types[] = $type;
        }

        return new UnionType($types);
    }

    public function getDocComment(): ?string
    {
        return $this->wrappedReflection->getDocComment();
    }

    public function isDeprecated(): \PHPStan\TrinaryLogic
    {
        return $this->wrappedReflection->isDeprecated();
    }

    public function getDeprecatedDescription(): ?string
    {
        return $this->wrappedReflection->getDeprecatedDescription();
    }

    public function isFinal(): \PHPStan\TrinaryLogic
    {
        return $this->wrappedReflection->isFinal();
    }

    public function isInternal(): \PHPStan\TrinaryLogic
    {
        return $this->wrappedReflection->isInternal();
    }

    public function getThrowType(): ?\PHPStan\Type\Type
    {
        return $this->wrappedReflection->getThrowType();
    }

    public function hasSideEffects(): \PHPStan\TrinaryLogic
    {
        return $this->wrappedReflection->hasSideEffects();
    }
}
