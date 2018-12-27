<?php

declare(strict_types=1);

namespace Proget\PHPStan\PhpSpec\Type;

use PhpParser\Node\Expr\StaticCall;
use PhpSpec\Locator\PSR0\PSR0Locator;
use PhpSpec\Locator\Resource;
use PhpSpec\ObjectBehavior;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\ShouldNotHappenException;
use PHPStan\Type\ArrayType;
use PHPStan\Type\DynamicStaticMethodReturnTypeExtension;
use PHPStan\Type\ObjectType;
use PHPStan\Type\ResourceType;
use PHPStan\Type\Type;
use Proget\PHPStan\PhpSpec\Reflection\ObjectBehaviorMethodReflection;

final class ObjectBehaviorDynamicStaticMethodReturnTypeExtension implements DynamicStaticMethodReturnTypeExtension
{
    public function getClass(): string
    {
        return ObjectBehavior::class;
    }

    public function isStaticMethodSupported(MethodReflection $methodReflection): bool
    {
        return $methodReflection instanceof ObjectBehaviorMethodReflection;
    }

    public function getTypeFromStaticMethodCall(MethodReflection $methodReflection, StaticCall $methodCall, Scope $scope): Type
    {
        if (!$methodReflection instanceof ObjectBehaviorMethodReflection) {
            throw new ShouldNotHappenException();
        }

        $returnType = $methodReflection->wrappedReflection()->getVariants()[0]->getReturnType();

        if ($returnType instanceof ArrayType) {
            $itemType = $returnType->getItemType();
            // nasty hack for PhpStan bug with wrong Resource class identification
            if ($itemType instanceof ResourceType && $methodReflection->getDeclaringClass()->getName() === PSR0Locator::class) {
                $itemType = new ObjectType(Resource::class);
            }

            return new SubjectArrayType($returnType->getKeyType(), $itemType);
        }

        return new SubjectType($returnType);
    }
}
