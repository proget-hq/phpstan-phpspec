<?php

declare(strict_types=1);

namespace Proget\PHPStan\PhpSpec\Type;

use PhpParser\Node\Expr\MethodCall;
use PhpSpec\ObjectBehavior;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\ShouldNotHappenException;
use PHPStan\Type\DynamicMethodReturnTypeExtension;
use PHPStan\Type\Type;
use Proget\PHPStan\PhpSpec\Reflection\ObjectBehaviorMethodReflection;

final class ObjectBehaviorDynamicMethodReturnTypeExtension implements DynamicMethodReturnTypeExtension
{
    public function getClass(): string
    {
        return ObjectBehavior::class;
    }

    public function isMethodSupported(MethodReflection $methodReflection): bool
    {
        return $methodReflection instanceof ObjectBehaviorMethodReflection;
    }

    public function getTypeFromMethodCall(MethodReflection $methodReflection, MethodCall $methodCall, Scope $scope): Type
    {
        if (!$methodReflection instanceof ObjectBehaviorMethodReflection) {
            throw new ShouldNotHappenException();
        }

        return new SubjectType($methodReflection->wrappedReflection()->getVariants()[0]->getReturnType());
    }
}
