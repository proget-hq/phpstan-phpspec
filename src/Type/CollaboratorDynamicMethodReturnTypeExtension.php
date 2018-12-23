<?php

declare(strict_types=1);

namespace Proget\PHPStan\PhpSpec\Type;

use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\DynamicMethodReturnTypeExtension;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use Prophecy\Prophecy\MethodProphecy;

final class CollaboratorDynamicMethodReturnTypeExtension implements DynamicMethodReturnTypeExtension
{
    /**
     * @var string
     */
    private $className;

    public function __construct(string $className)
    {
        $this->className = $className;
    }

    public function getClass(): string
    {
        return $this->className;
    }

    public function isMethodSupported(MethodReflection $methodReflection): bool
    {
        return $methodReflection->getDeclaringClass()->getName() === $this->className;
    }

    public function getTypeFromMethodCall(MethodReflection $methodReflection, MethodCall $methodCall, Scope $scope): Type
    {
        if (0 === strpos((string) $scope->getNamespace(), 'spec')) {
            return new ObjectType(MethodProphecy::class);
        }

        return $methodReflection->getVariants()[0]->getReturnType();
    }
}
