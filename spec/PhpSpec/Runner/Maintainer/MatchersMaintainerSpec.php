<?php

declare(strict_types=1);

namespace spec\PhpSpec\Runner\Maintainer;

use PhpSpec\Formatter\Presenter\Presenter;
use PhpSpec\Loader\Node\ExampleNode;
use PhpSpec\Matcher\Matcher;
use PhpSpec\ObjectBehavior;
use PhpSpec\Runner\CollaboratorManager;
use PhpSpec\Runner\MatcherManager;
use PhpSpec\Specification;

class MatchersMaintainerSpec extends ObjectBehavior
{
    public function it_should_add_default_matchers_to_the_matcher_manager(
        Presenter $presenter,
        ExampleNode $example,
        Specification $context,
        MatcherManager $matchers,
        CollaboratorManager $collaborators,
        Matcher $matcher
    ) {
        $this->beConstructedWith($presenter, [$matcher]);
        $this->prepare($example, $context, $matchers, $collaborators);

        $matchers->replace([$matcher])->shouldHaveBeenCalled();
    }
}
