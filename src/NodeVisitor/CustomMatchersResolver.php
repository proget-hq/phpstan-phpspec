<?php

declare(strict_types=1);

namespace Proget\PHPStan\PhpSpec\NodeVisitor;

use PhpParser\Node;
use PhpParser\NodeVisitor;
use Proget\PHPStan\PhpSpec\Registry\CustomMatchersRegistry;

final class CustomMatchersResolver implements NodeVisitor
{
    /**
     * @var string
     */
    private $currentSpec = null;

    public function beforeTraverse(array $nodes)
    {
        return null;
    }

    public function enterNode(Node $node)
    {
        if ($node instanceof Node\Stmt\Class_ && $node->name !== null) {
            $this->currentSpec = $node->namespacedName->toString();
        }

        return null;
    }

    public function leaveNode(Node $node)
    {
        if (!$node instanceof Node\Stmt\ClassMethod || $node->name->name !== 'getMatchers') {
            return null;
        }

        if ($node->stmts === null) {
            return null;
        }

        foreach ($node->stmts as $stmt) {
            if (!$stmt instanceof Node\Stmt\Return_) {
                continue;
            }

            if (!$stmt->expr instanceof Node\Expr\Array_) {
                continue;
            }

            $this->resolveMatchers($stmt->expr->items);
        }

        return null;
    }

    public function afterTraverse(array $nodes)
    {
        return null;
    }

    /**
     * @param Node\Expr\ArrayItem[] $items
     */
    private function resolveMatchers(array $items): void
    {
        // todo: maybe we can resolve custom matcher parameters count?
        foreach ($items as $item) {
            if ($item->key instanceof Node\Scalar\String_) {
                CustomMatchersRegistry::addMatcher($this->currentSpec, $item->key->value);
            }
        }
    }
}
