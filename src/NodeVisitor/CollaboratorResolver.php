<?php
declare(strict_types=1);

namespace Proget\PHPStan\PhpSpec\NodeVisitor;


use PhpParser\Node;
use PhpParser\NodeVisitor;

final class CollaboratorResolver implements NodeVisitor
{
    /**
     * @var bool
     */
    private $isInExampleMethod = false;

    public function beforeTraverse(array $nodes)
    {
        return null;
    }

    public function enterNode(Node $node)
    {
        if($node instanceof Node\Stmt\ClassMethod && preg_match('/^(it|its)[^a-zA-Z]/', $node->name->name)) {
            $this->isInExampleMethod = true;
        }
    }

    public function leaveNode(Node $node)
    {
        if($this->isInExampleMethod && $node instanceof Node\Param && $node->type instanceof Node\Name\FullyQualified) {
            return new Node\Param(
                $node->var,
                $node->default,
                new Node\Name\FullyQualified('My\Special\Class'),
                $node->byRef,
                $node->variadic,
                $node->getAttributes()
            );
        }

        if($node instanceof Node\Stmt\ClassMethod && preg_match('/^(it|its)[^a-zA-Z]/', $node->name->name)) {
            $this->isInExampleMethod = false;
        }

        return null;
    }

    public function afterTraverse(array $nodes)
    {
        return null;
    }

}
