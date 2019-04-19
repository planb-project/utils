<?php

namespace Spec\PlanB\Utils\Builtin\Text;

use PlanB\Utils\Builtin\Text\Encoding;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EncodingSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedThrough('get', [Encoding::UTF_8]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Encoding::class);
    }

    public function it_retrieve_the_value_if_argument_is_an_object()
    {
        $this::safeValue(Encoding::UTF_7())->shouldReturn(Encoding::UTF_7);
    }

    public function it_retrieve_the_internal_encoding_if_argument_is_null()
    {
        $this::safeValue()->shouldReturn(mb_internal_encoding());
    }

    public function it_retrieve_value_when_cast_to_string()
    {
        $this->__toString()->shouldReturn(Encoding::UTF_8);
    }
}
