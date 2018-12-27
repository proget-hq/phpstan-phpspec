<?php

declare(strict_types=1);

namespace Proget\PHPStan\PhpSpec\Reflection;

use PHPStan\Reflection\ClassMemberReflection;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\FunctionVariant;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\Native\NativeParameterReflection;
use PHPStan\Reflection\ParameterReflection;
use PHPStan\Reflection\PassedByReference;
use PHPStan\Type\ArrayType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
use Proget\PHPStan\PhpSpec\Wrapper\SpoofedCollaborator;
use Prophecy\Argument\Token\AnyValuesToken;
use Prophecy\Argument\Token\AnyValueToken;
use Prophecy\Argument\Token\TokenInterface;
use Prophecy\Prophecy\MethodProphecy;

final class CollaboratorMethodReflection implements MethodReflection
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
        $parameters = array_map(function (ParameterReflection $parameter) {
            return new NativeParameterReflection(
                $parameter->getName(),
                true,
                $this->mergeWithAnyValueTokens($parameter->getType()),
                $parameter->passedByReference(),
                $parameter->isVariadic()
            );
        }, $this->wrappedReflection->getVariants()[0]->getParameters());

        return [
            new FunctionVariant(
                count($parameters) > 0 ? $parameters : [$this->createAnyParameter()],
                $this->wrappedReflection->getVariants()[0]->isVariadic(),
                new ObjectType(MethodProphecy::class)
            )
        ];
    }

    private function mergeWithAnyValueTokens(Type $type): Type
    {
        $types = [
            new ObjectType(TokenInterface::class),
            new ObjectType(SpoofedCollaborator::class)
        ];

        if ($type instanceof UnionType) {
            foreach ($type->getTypes() as $unionType) {
                $types[] = $unionType;
            }
        } elseif ($type instanceof ArrayType) {
            $types[] = $type->getItemType();

            return new UnionType([
                new ArrayType($type->getKeyType(), new UnionType($types)),
                new ObjectType(TokenInterface::class)
            ]);
        } else {
            $types[] = $type;
        }

        return new UnionType($types);
    }

    private function createAnyParameter(): NativeParameterReflection
    {
        return new NativeParameterReflection(
            'any',
            true,
            new UnionType([
                new ObjectType(AnyValueToken::class),
                new ObjectType(AnyValuesToken::class)
            ]),
            PassedByReference::createNo(),
            true
        );
    }
}
