<?php

declare(strict_types=1);

namespace Proget\PHPStan\PhpSpec\Type;

use PhpParser\Node\Expr\MethodCall;
use PhpSpec\Locator\PSR0\PSR0Locator;
use PhpSpec\Locator\PSR0\PSR0Resource;
use PhpSpec\Locator\Resource;
use PhpSpec\Locator\ResourceLocator;
use PhpSpec\ObjectBehavior;
use PhpSpec\Util\Filesystem;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\ShouldNotHappenException;
use PHPStan\Type\ArrayType;
use PHPStan\Type\DynamicMethodReturnTypeExtension;
use PHPStan\Type\ObjectType;
use PHPStan\Type\ResourceType;
use PHPStan\Type\Type;
use Proget\PHPStan\PhpSpec\Exception\SpecSourceClassNotFound;
use Proget\PHPStan\PhpSpec\Reflection\ObjectBehaviorMethodReflection;

final class ObjectBehaviorDynamicMethodReturnTypeExtension implements DynamicMethodReturnTypeExtension
{
    /**
     * @var ResourceLocator
     */
    private $locator;

    public function __construct()
    {
        $this->locator = new PSR0Locator(new Filesystem());
    }

    public function getClass(): string
    {
        return ObjectBehavior::class;
    }

    public function isMethodSupported(MethodReflection $methodReflection): bool
    {
        return $methodReflection instanceof ObjectBehaviorMethodReflection || $methodReflection->getName() === 'getWrappedObject';
    }

    public function getTypeFromMethodCall(MethodReflection $methodReflection, MethodCall $methodCall, Scope $scope): Type
    {
        if ($methodReflection->getName() === 'getWrappedObject') {
            return new ObjectType($this->getSourceClassName($scope->getClassReflection()));
        }

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

    // todo: looks like duplication from ObjectBehaviorMethodsClassReflectionExtension
    private function getSourceClassName(?ClassReflection $classReflection): string
    {
        if ($classReflection === null) {
            throw new ShouldNotHappenException();
        }

        /** @var PSR0Resource[] $resources */
        $resources = $this->locator->findResources((string) $classReflection->getFileName());

        if (count($resources) === 0) {
            throw new SpecSourceClassNotFound(sprintf('Source class from %s not found', $classReflection->getName()));
        }

        $className = $resources[0]->getSrcClassname();
        if (!class_exists($className)) {
            throw new SpecSourceClassNotFound(sprintf('Spec source class %s not found', $className));
        }

        return $className;
    }
}
