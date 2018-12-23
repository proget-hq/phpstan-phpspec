<?php

declare(strict_types=1);

namespace spec\PhpSpec\Util;

class ExampleObjectUsingTrait
{
    use ExampleTrait, AnotherExampleTrait;
}
