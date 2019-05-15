<?php

declare(strict_types=1);

namespace Proget\PHPStan\PhpSpec\Type;

use PhpSpec\Wrapper\Subject;
use PHPStan\Broker\Broker;
use PHPStan\Reflection\ClassMemberAccessAnswerer;
use PHPStan\Reflection\MethodReflection;
use PHPStan\ShouldNotHappenException;
use PHPStan\TrinaryLogic;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use PHPStan\Type\VerbosityLevel;
use Proget\PHPStan\PhpSpec\Reflection\CustomMatcherMethodReflection;
use Proget\PHPStan\PhpSpec\Reflection\SubjectMethodReflection;
use Proget\PHPStan\PhpSpec\Registry\CustomMatchersRegistry;

final class SubjectType extends ObjectType
{
    /**
     * @var Type
     */
    private $wrappedType;

    public function __construct(Type $wrappedType)
    {
        parent::__construct(Subject::class);
        $this->wrappedType = $wrappedType;
    }

    public function hasMethod(string $methodName): TrinaryLogic
    {
        if ($this->wrappedType->hasMethod($methodName)->yes()) {
            return TrinaryLogic::createYes();
        }

        if (parent::hasMethod($methodName)->yes()) {
            return TrinaryLogic::createYes();
        }

        $broker = Broker::getInstance();
        $decorator = $broker->getClass(Subject\Expectation\Decorator::class);

        if ($decorator->hasMethod($methodName)) {
            return TrinaryLogic::createYes();
        }

        return TrinaryLogic::createFromBoolean(preg_match('/^should(.+)$/', $methodName) !== false);
    }

    public function getMethod(string $methodName, ClassMemberAccessAnswerer $scope): MethodReflection
    {
        if ($this->wrappedType->hasMethod($methodName)->yes()) {
            return new SubjectMethodReflection($this->wrappedType->getMethod($methodName, $scope));
        }

        if (parent::hasMethod($methodName)->yes()) {
            return parent::getMethod($methodName, $scope);
        }

        $classReflection = $scope->getClassReflection();
        if ($classReflection && CustomMatchersRegistry::hasMatcher($classReflection->getName(), $this->getCustomMatcherName($methodName))) {
            return new CustomMatcherMethodReflection($methodName, $classReflection);
        }

        $broker = Broker::getInstance();
        $decorator = $broker->getClass(Subject\Expectation\Decorator::class);

        if ($decorator->hasMethod($methodName)) {
            return new SubjectMethodReflection($decorator->getMethod($methodName, $scope));
        }

        if ($this->wrappedType->hasMethod($methodName)->maybe()) {
            return new SubjectMethodReflection($this->wrappedType->getMethod($methodName, $scope));
        }

        throw new ShouldNotHappenException();
    }

    public function describe(VerbosityLevel $level): string
    {
        return sprintf('%s<%s>', parent::describe($level), $this->wrappedType->describe($level));
    }

    private function getCustomMatcherName(string $methodName):string
    {
        return lcfirst((string) preg_replace('/^should/', '', $methodName));
    }
}
