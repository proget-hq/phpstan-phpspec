<?php

declare(strict_types=1);

namespace Proget\PHPStan\PhpSpec\Reflection;

use PhpSpec\Wrapper\Collaborator;
use PHPStan\Analyser\OutOfClassScope;
use PHPStan\Broker\Broker;
use PHPStan\Reflection\BrokerAwareExtension;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\MethodsClassReflectionExtension;
use Proget\PHPStan\PhpSpec\Registry\SpoofedCollaboratorRegistry;
use Proget\PHPStan\PhpSpec\Wrapper\SpoofedCollaborator;

final class SpoofedCollaboratorMethodsClassReflectionExtension implements MethodsClassReflectionExtension, BrokerAwareExtension
{
    /**
     * @var Broker
     */
    private $broker;

    public function setBroker(Broker $broker): void
    {
        $this->broker = $broker;
    }

    public function hasMethod(ClassReflection $classReflection, string $methodName): bool
    {
        return in_array(SpoofedCollaborator::class, array_map(function (ClassReflection $interface):string {
            return $interface->getName();
        }, $classReflection->getInterfaces()), true);
    }

    public function getMethod(ClassReflection $classReflection, string $methodName): MethodReflection
    {
        $collaboratorClassName = (string) preg_replace('/Collaborator$/', '', SpoofedCollaboratorRegistry::getAlias($classReflection->getName()));
        $collaboratorReflection = $this->broker->getClass(Collaborator::class);

        if ($methodName === 'getWrappedObject') {
            return new GetWrappedObjectMethodReflection($collaboratorReflection->getMethod($methodName, new OutOfClassScope()), $collaboratorClassName);
        }

        if ($collaboratorReflection->hasMethod($methodName)) {
            return $collaboratorReflection->getMethod($methodName, new OutOfClassScope());
        }

        return new CollaboratorMethodReflection($this->broker->getClass($collaboratorClassName)->getMethod($methodName, new OutOfClassScope()));
    }
}
