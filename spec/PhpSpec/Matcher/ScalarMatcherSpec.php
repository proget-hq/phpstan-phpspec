<?php

declare(strict_types=1);

namespace spec\PhpSpec\Matcher;

use PhpSpec\Formatter\Presenter\Presenter;
use PhpSpec\Matcher\Matcher;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ScalarMatcherSpec extends ObjectBehavior
{
    public function let(Presenter $presenter)
    {
        $presenter->presentValue(Argument::any())->willReturn('val1', 'val2');

        $this->beConstructedWith($presenter);
    }

    public function it_is_a_matcher()
    {
        $this->shouldBeAnInstanceOf(Matcher::class);
    }

    public function it_responds_to_be_array()
    {
        $this->supports('beArray', '', [''])->shouldReturn(true);
    }

    public function it_matches_array()
    {
        $this->shouldNotThrow()->duringPositiveMatch('beArray', [], ['']);
    }

    public function it_does_not_match_not_array_with_be_array_matcher()
    {
        $this->shouldThrow()->duringPositiveMatch('beArray', Argument::not([]), ['']);
    }

    public function it_mismatches_not_array()
    {
        $this->shouldNotThrow()->duringNegativeMatch('beArray', Argument::not([]), ['']);
    }

    public function it_does_not_mismatch_array()
    {
        $this->shouldThrow()->duringNegativeMatch('beArray', [], ['']);
    }

    public function it_responds_to_be_bool()
    {
        $this->supports('beBool', '', [''])->shouldReturn(true);
    }

    public function it_matches_bool()
    {
        $this->shouldNotThrow()->duringPositiveMatch('beBool', false, ['']);
    }

    public function it_does_not_match_not_bool_with_be_bool_matcher()
    {
        $this->shouldThrow()->duringPositiveMatch('beBool', Argument::not(false), ['']);
    }

    public function it_mismatches_not_bool()
    {
        $this->shouldNotThrow()->duringNegativeMatch('beBool', Argument::not(false), ['']);
    }

    public function it_does_not_mismatch_bool()
    {
        $this->shouldThrow()->duringNegativeMatch('beBool', false, ['']);
    }

    public function it_responds_to_be_boolean()
    {
        $this->supports('beBoolean', '', [''])->shouldReturn(true);
    }

    public function it_matches_boolean()
    {
        $this->shouldNotThrow()->duringPositiveMatch('beBoolean', false, ['']);
    }

    public function it_does_not_match_not_boolean()
    {
        $this->shouldThrow()->duringPositiveMatch('beBoolean', Argument::not(false), ['']);
    }

    public function it_mismatches_not_boolean()
    {
        $this->shouldNotThrow()->duringNegativeMatch('beBoolean', Argument::not(false), ['']);
    }

    public function it_does_not_mismatch_boolean()
    {
        $this->shouldThrow()->duringNegativeMatch('beBoolean', false, ['']);
    }

    public function it_responds_to_be_callable()
    {
        $this->supports('beCallable', '', [''])->shouldReturn(true);
    }

    public function it_matches_callable()
    {
        $this->shouldNotThrow()->duringPositiveMatch('beCallable', function () {
            return true;
        }, ['']);
    }

    public function it_does_not_match_not_callable()
    {
        $this->shouldThrow()->duringPositiveMatch('beCallable', Argument::not(function () {
            return true;
        }), ['']);
    }

    public function it_mismatches_not_callable()
    {
        $this->shouldNotThrow()->duringNegativeMatch('beCallable', Argument::not(function () {
            return true;
        }), ['']);
    }

    public function it_does_not_mismatch_callable()
    {
        $this->shouldThrow()->duringNegativeMatch('beCallable', function () {
            return true;
        }, ['']);
    }

//    FROM PHP 7.3 - Implement also positive match and negative match
//    function it_responds_to_be_countable()
//    {
//        $this->supports('beCountable', '', [''])->shouldReturn(true);
//    }

    public function it_responds_to_be_double()
    {
        $this->supports('beDouble', '', [''])->shouldReturn(true);
    }

    public function it_matches_double()
    {
        $this->shouldNotThrow()->duringPositiveMatch('beDouble', doubleval(10.5), ['']);
    }

    public function it_does_not_match_not_double()
    {
        $this->shouldThrow()->duringPositiveMatch('beDouble', Argument::not(doubleval(10.5)), ['']);
    }

    public function it_mismatches_not_double()
    {
        $this->shouldNotThrow()->duringNegativeMatch('beDouble', Argument::not(doubleval(10.5)), ['']);
    }

    public function it_does_not_mismatches_double()
    {
        $this->shouldThrow()->duringNegativeMatch('beDouble', doubleval(10.5), ['']);
    }

    public function it_responds_to_be_float()
    {
        $this->supports('beFloat', '', [''])->shouldReturn(true);
    }

    public function it_matches_float()
    {
        $this->shouldNotThrow()->duringPositiveMatch('beFloat', 10.5, ['']);
    }

    public function it_does_not_match_not_float()
    {
        $this->shouldThrow()->duringPositiveMatch('beFloat', Argument::not(10.5), ['']);
    }

    public function it_mismatches_not_float()
    {
        $this->shouldNotThrow()->duringNegativeMatch('beFloat', Argument::not(10.5), ['']);
    }

    public function it_does_not_mismatches_float()
    {
        $this->shouldThrow()->duringNegativeMatch('beFloat', 10.5, ['']);
    }

    public function it_responds_to_be_int()
    {
        $this->supports('beInt', '', [''])->shouldReturn(true);
    }

    public function it_matches_int()
    {
        $this->shouldNotThrow()->duringPositiveMatch('beInt', 1, ['']);
    }

    public function it_does_not_match_not_int()
    {
        $this->shouldThrow()->duringPositiveMatch('beInt', Argument::not(1), ['']);
    }

    public function it_mismatches_not_int()
    {
        $this->shouldNotThrow()->duringNegativeMatch('beInt', Argument::not(1), ['']);
    }

    public function it_does_not_mismatches_int()
    {
        $this->shouldThrow()->duringNegativeMatch('beInt', 1, ['']);
    }

    public function it_responds_to_be_integer()
    {
        $this->supports('beInteger', '', [''])->shouldReturn(true);
    }

    public function it_matches_int_with_integer_matcher()
    {
        $this->shouldNotThrow()->duringPositiveMatch('beInteger', 1, ['']);
    }

    public function it_does_not_match_not_integer_match()
    {
        $this->shouldThrow()->duringPositiveMatch('beInteger', Argument::not(1), ['']);
    }

    public function it_mismatches_not_integer()
    {
        $this->shouldNotThrow()->duringNegativeMatch('beInteger', Argument::not(1), ['']);
    }

    public function it_does_not_mismatches_integer()
    {
        $this->shouldThrow()->duringNegativeMatch('beInteger', 1, ['']);
    }

    public function it_responds_to_be_iterable()
    {
        $this->supports('beIterable', '', [''])->shouldReturn(true);
    }

    public function it_matches_iterable()
    {
        $this->shouldNotThrow()->duringPositiveMatch('beIterable', [], ['']);
    }

    public function it_does_not_match_not_iterable()
    {
        $this->shouldThrow()->duringPositiveMatch('beIterable', Argument::not([]), ['']);
    }

    public function it_mismatches_not_iterable()
    {
        $this->shouldNotThrow()->duringNegativeMatch('beIterable', Argument::not([]), ['']);
    }

    public function it_does_not_mismatches_iterable()
    {
        $this->shouldThrow()->duringNegativeMatch('beIterable', [], ['']);
    }

    public function it_responds_to_be_long()
    {
        $this->supports('beLong', '', [''])->shouldReturn(true);
    }

    public function it_matches_long()
    {
        $this->shouldNotThrow()->duringPositiveMatch('beLong', 4209531264, ['']);
    }

    public function it_does_not_match_not_long()
    {
        $this->shouldThrow()->duringPositiveMatch('beLong', Argument::not(4209531264), ['']);
    }

    public function it_mismatches_not_long()
    {
        $this->shouldNotThrow()->duringNegativeMatch('beLong', Argument::not(4209531264), ['']);
    }

    public function it_does_not_mismatches_long()
    {
        $this->shouldThrow()->duringNegativeMatch('beLong', 4209531264, ['']);
    }

    public function it_responds_to_be_null()
    {
        $this->supports('beNull', '', [''])->shouldReturn(true);
    }

    public function it_matches_null()
    {
        $this->shouldNotThrow()->duringPositiveMatch('beNull', null, ['']);
    }

    public function it_does_not_match_not_null()
    {
        $this->shouldThrow()->duringPositiveMatch('beNull', Argument::not(null), ['']);
    }

    public function it_mismatches_not_null()
    {
        $this->shouldNotThrow()->duringNegativeMatch('beNull', Argument::not(null), ['']);
    }

    public function it_does_not_mismatches_null()
    {
        $this->shouldThrow()->duringNegativeMatch('beNull', null, ['']);
    }

    public function it_responds_to_be_numeric()
    {
        $this->supports('beNumeric', '', [''])->shouldReturn(true);
    }

    public function it_matches_numeric_string()
    {
        $this->shouldNotThrow()->duringPositiveMatch('beNumeric', '123', ['']);
    }

    public function it_matches_numeric_number()
    {
        $this->shouldNotThrow()->duringPositiveMatch('beNumeric', 123, ['']);
    }

    public function it_does_not_match_not_numeric_string()
    {
        $this->shouldThrow()->duringPositiveMatch('beNumeric', Argument::not('123'), ['']);
    }

    public function it_does_not_match_not_numeric()
    {
        $this->shouldThrow()->duringPositiveMatch('beNumeric', Argument::not(123), ['']);
    }

    public function it_mismatches_not_number()
    {
        $this->shouldNotThrow()->duringNegativeMatch('beNumeric', Argument::not(123), ['']);
    }

    public function it_does_not_mismatches_number()
    {
        $this->shouldThrow()->duringNegativeMatch('beNumeric', 123, ['']);
    }

    public function it_responds_to_be_object()
    {
        $this->supports('beObject', '', [''])->shouldReturn(true);
    }

    public function it_matches_object()
    {
        $this->shouldNotThrow()->duringPositiveMatch('beObject', new \stdClass(), ['']);
    }

    public function it_does_not_match_not_object()
    {
        $this->shouldThrow()->duringPositiveMatch('beObject', null, ['']);
    }

    public function it_mismatches_not_object()
    {
        $this->shouldNotThrow()->duringNegativeMatch('beObject', null, ['']);
    }

    public function it_does_not_mismatches_object()
    {
        $this->shouldThrow()->duringNegativeMatch('beObject', new \stdClass(), ['']);
    }

    public function it_responds_to_be_real()
    {
        $this->supports('beReal', '', [''])->shouldReturn(true);
    }

    public function it_matches_real()
    {
        $this->shouldNotThrow()->duringPositiveMatch('beReal', 10.5, ['']);
    }

    public function it_does_not_match_not_real()
    {
        $this->shouldThrow()->duringPositiveMatch('beReal', Argument::not(10.5), ['']);
    }

    public function it_mismatches_not_real()
    {
        $this->shouldNotThrow()->duringNegativeMatch('beReal', Argument::not(10.5), ['']);
    }

    public function it_does_not_mismatches_real()
    {
        $this->shouldThrow()->duringNegativeMatch('beReal', 10.5, ['']);
    }

    public function it_responds_to_be_resource()
    {
        $this->supports('beResource', '', [''])->shouldReturn(true);
    }

    public function it_matches_a_resource()
    {
        $fp = fopen(__FILE__, 'r');
        $this->shouldNotThrow()->duringPositiveMatch('beResource', $fp, ['']);
        if (is_resource($fp)) {
            fclose($fp);
        }
    }

    public function it_does_not_match_not_resource()
    {
        $this->shouldThrow()->duringPositiveMatch('beResource', null, ['']);
    }

    public function it_mismatches_not_resource()
    {
        $this->shouldNotThrow()->duringNegativeMatch('beResource', null, ['']);
    }

    public function it_does_not_mismatches_resource()
    {
        $fp = fopen(__FILE__, 'r');
        $this->shouldThrow()->duringNegativeMatch('beResource', $fp, ['']);
        if (is_resource($fp)) {
            fclose($fp);
        }
    }

    public function it_responds_to_be_scalar()
    {
        $this->supports('beScalar', '', [''])->shouldReturn(true);
    }

    public function it_matches_scalar()
    {
        $this->shouldNotThrow()->duringPositiveMatch('beScalar', 'foo', ['']);
    }

    public function it_does_not_match_not_scalar()
    {
        $this->shouldThrow()->duringPositiveMatch('beResource', null, ['']);
    }

    public function it_mismatches_not_scalar()
    {
        $this->shouldNotThrow()->duringNegativeMatch('beResource', null, ['']);
    }

    public function it_does_not_mismatches_scalar()
    {
        $this->shouldThrow()->duringNegativeMatch('beScalar', 'foo', ['']);
    }

    public function it_responds_to_be_string()
    {
        $this->supports('beString', '', [''])->shouldReturn(true);
    }

    public function it_matches_string()
    {
        $this->shouldNotThrow()->duringPositiveMatch('beString', 'foo', ['']);
    }

    public function it_does_not_match_not_string()
    {
        $this->shouldThrow()->duringPositiveMatch('beString', Argument::not('foo'), ['']);
    }

    public function it_mismatches_not_stringt()
    {
        $this->shouldNotThrow()->duringNegativeMatch('beString', Argument::not('foo'), ['']);
    }

    public function it_does_not_mismatches_string()
    {
        $this->shouldThrow()->duringNegativeMatch('beString', 'foo', ['']);
    }
}
