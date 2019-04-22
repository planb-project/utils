<?php

namespace Spec\PlanB\Utils\Builtin\Text;

use PlanB\Utils\Builtin\Text\Encoding;
use PlanB\Utils\Builtin\Text\Text;
use PlanB\Utils\Builtin\Text\Stringify;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TextSpec extends ObjectBehavior
{

    const A_NAME = 'josé botika';
    const A_UTF_7_NAME = 'jos+AOk botika';

    const GREETING_FORMAT = 'hello, my name is %s';
    const GREETING = 'hello, my name is josé botika';
    const GREETING_LENGTH = 29;


    /**
     * @param $format
     * @param array $params
     * @return TextSpec
     */
    private function make($format, ...$params): self
    {

        array_unshift($params, $format);
        $this->beConstructedThrough('make', $params);
        return $this;
    }

    /**
     * @param $text
     * @return TextSpec
     */
    private function makeEncoded($text, $encoding): self
    {
        $this->beConstructedThrough('makeEncoded', [$text, $encoding]);

        return $this;
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Text::class);
        $this->shouldImplement(Stringify::class);
    }

    public function it_is_initializable_from_a_simple_string()
    {
        $this->make(self::A_NAME);
        $this->shouldHaveType(Text::class);

        $this->__toString()->shouldReturn(self::A_NAME);
    }

    public function it_is_initializable_from_a_format_string()
    {

        $this->make(self::GREETING_FORMAT, self::A_NAME);

        $this->shouldHaveType(Text::class);

        $this->__toString()->shouldReturn(self::GREETING);
    }

    public function it_has_the_internal_encoding_by_default()
    {
        $this->make(self::GREETING_FORMAT, self::A_NAME);
        $this->getEncoding()->shouldReturn(mb_internal_encoding());
    }

    public function it_is_initializable_with_a_specific_encoding()
    {

        $this->makeEncoded(self::A_UTF_7_NAME, Encoding::UTF_7());
        $this->shouldHaveType(Text::class);

        $this->__toString()->shouldReturn(self::A_UTF_7_NAME);
    }

    public function it_can_change_the_encoding()
    {
        $this->makeEncoded(self::A_UTF_7_NAME, Encoding::UTF_7());

        $this->changeEncoding(Encoding::UTF_8())
            ->__toString()->shouldReturn(self::A_NAME);
    }

    public function it_do_nothing_if_the_new_encoding_if_the_equal_to_current()
    {
        $this->makeEncoded(self::A_UTF_7_NAME, Encoding::UTF_7());

        $this->changeEncoding(Encoding::UTF_7())
            ->__toString()->shouldReturn(self::A_UTF_7_NAME);
    }


    public function it_can_retrieve_the_length_of_a_text()
    {
        $this->make(self::GREETING_FORMAT, self::A_NAME);

        $this->getLength()->shouldReturn(self::GREETING_LENGTH);
    }

    public function it_can_retrieve_the_length_of_an_encoded_text()
    {

        $text = sprintf(self::GREETING_FORMAT, self::A_UTF_7_NAME);
        $this->beConstructedThrough('makeEncoded', [$text, Encoding::UTF_7()]);

        $this->getLength()->shouldReturn(self::GREETING_LENGTH);
    }

    public function it_identifies_an_empty_text()
    {
        $this->make(Text::EMPTY);
        $this->isEmpty()->shouldReturn(true);
        $this->isBlank()->shouldReturn(true);
    }

    public function it_identifies_a_blank_text()
    {
        $this->make(Text::SPACE);
        $this->isEmpty()->shouldReturn(false);
        $this->isBlank()->shouldReturn(true);
    }

    public function it_identifies_a_printable_text()
    {
        $this->make(self::GREETING);
        $this->isEmpty()->shouldReturn(false);
        $this->isBlank()->shouldReturn(false);
    }

    public function it_identifies_a_tab_char()
    {
        $this->make("\t");
        $this->isEmpty()->shouldReturn(false);
        $this->isBlank()->shouldReturn(true);
    }

    public function it_identifies_a_new_line_char()
    {
        $this->make("\n");
        $this->isEmpty()->shouldReturn(false);
        $this->isBlank()->shouldReturn(true);
    }


    public function it_removes_characters_from_the_beginning_and_end_of_a_string()
    {
        $this->make('     ホホRANDOM_TEXTホホ     ');

        $this->trim()->__toString()->shouldReturn('ホホRANDOM_TEXTホホ');
        $this->trim(' ホ')->__toString()->shouldReturn('RANDOM_TEXT');

    }

    public function it_removes_characters_from_the_beginning_of_a_string()
    {
        $this->make('     ホホRANDOM_TEXTホホ     ');

        $this->trimLeft()->__toString()->shouldReturn('ホホRANDOM_TEXTホホ     ');
        $this->trimLeft(' ホ')->__toString()->shouldReturn('RANDOM_TEXTホホ     ');
    }

    public function it_removes_characters_from_the_end_of_a_string()
    {
        $this->make('     ホホRANDOM_TEXTホホ     ');

        $this->trimRight()->__toString()->shouldReturn('     ホホRANDOM_TEXTホホ');
        $this->trimRight(' ホ')->__toString()->shouldReturn('     ホホRANDOM_TEXT');
    }


    public function it_can_extract_pieces_from_a_text_according_to_a_regex()
    {
        $this->make('hola|esto/es-una-frase con caracteres utf8 como este: ホ');

        $this->match('/(\w+)/u')
            ->shouldIterateLike([
                Text::make('hola'),
                Text::make('esto'),
                Text::make('es'),
                Text::make('una'),
                Text::make('frase'),
                Text::make('con'),
                Text::make('caracteres'),
                Text::make('utf8'),
                Text::make('como'),
                Text::make('este'),
                Text::make('ホ'),
            ]);
    }

    public function it_can_split_a_text_according_to_a_regex()
    {
        $this->make('hola|esto/es-una-frase con caracteres utf8 como este: ホ');

        $this->split('/(\W+)/u')
            ->shouldIterateLike([
                Text::make('hola'),
                Text::make('esto'),
                Text::make('es'),
                Text::make('una'),
                Text::make('frase'),
                Text::make('con'),
                Text::make('caracteres'),
                Text::make('utf8'),
                Text::make('como'),
                Text::make('este'),
                Text::make('ホ'),
            ]);
    }

    public function it_can_converts_to_upper_case()
    {
        $this->make('hola ホ')
            ->toUpperCase()
            ->__toString()
            ->shouldReturn('HOLA ホ');
    }

    public function it_can_converts_the_first_letter_to_upper_case()
    {
        $this->make('hola ホ')
            ->toUpperCaseFirst()
            ->__toString()
            ->shouldReturn('Hola ホ');
    }

    public function it_can_converts_to_lower_case()
    {
        $this->make('HOLA ホ')
            ->toLowerCase()
            ->__toString()
            ->shouldReturn('hola ホ');
    }


    public function it_can_converts_the_first_letter_to_lower_case()
    {
        $this->make('HOLA ホ')
            ->toLowerCaseFirst()
            ->__toString()
            ->shouldReturn('hOLA ホ');
    }


    public function it_can_converts_to_title_case()
    {
        $this->make('HOLA MI NOMBRE ES PEPE')
            ->toTitleCase()
            ->__toString()
            ->shouldReturn('Hola Mi Nombre Es Pepe');
    }

    public function it_can_converts_to_pascal_case()
    {
        $this->make('HOLA_MI-NOMBRE-ES-ホ')
            ->toPascalCase()
            ->__toString()
            ->shouldReturn('HolaMiNombreEsホ');
    }

    public function it_can_converts_to_pascal_with_a_delimiter()
    {
        $this->make('HOLA____MI-NOMBRE-ES--ホ')
            ->toPascalCase(' = ')
            ->__toString()
            ->shouldReturn('Hola = Mi = Nombre = Es = ホ');
    }

}
