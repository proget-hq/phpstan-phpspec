<?php

declare(strict_types=1);

namespace Proget\PHPStan\PhpSpec\Type;

use PHPStan\Reflection\ClassMemberAccessAnswerer;
use PHPStan\Reflection\MethodReflection;
use PHPStan\TrinaryLogic;
use PHPStan\Type\ArrayType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use PHPStan\Type\VerbosityLevel;

final class SubjectArrayType extends ArrayType
{
    /**
     * @var ObjectType
     */
    private $subjectType;

    public function __construct(Type $keyType, Type $itemType)
    {
        $this->subjectType = new SubjectType($itemType);
        parent::__construct($keyType, $this->subjectType);
    }

    public function canCallMethods(): TrinaryLogic
    {
        return TrinaryLogic::createYes();
    }

    public function hasMethod(string $methodName): TrinaryLogic
    {
        if ($this->subjectType->hasMethod($methodName)->yes()) {
            return TrinaryLogic::createYes();
        }

        return parent::hasMethod($methodName);
    }

    public function getMethod(string $methodName, ClassMemberAccessAnswerer $scope): MethodReflection
    {
        if ($this->subjectType->hasMethod($methodName)->yes()) {
            return $this->subjectType->getMethod($methodName, $scope);
        }

        return parent::getMethod($methodName, $scope);
    }

    public function describe(VerbosityLevel $level): string
    {
        return sprintf('%s<%s>', parent::describe($level), $this->subjectType->describe($level));
    }
}
