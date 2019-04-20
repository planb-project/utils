<?php

/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PlanB\Utils\Builtin\Text;

/**
 * Wrapper para cadenas de texto
 */
class Text implements Stringify
{

    public const EMPTY = '';
    public const SPACE = ' ';

    /**
     * @var string
     */
    private $text;
    /**
     * @var string
     */
    private $encoding;

    /**
     * Text constructor.
     *
     * @param string $text
     * @param \PlanB\Utils\Builtin\Text\Encoding|string|null $encoding
     */
    private function __construct(string $text, $encoding = null)
    {

        $this->text = $text;
        $this->encoding = Encoding::safeValue($encoding);
    }

    /**
     * Crea una instancia, con un encoding distinto al interno
     *
     * @param string $text
     * @param \PlanB\Utils\Builtin\Text\Encoding $encoding
     *
     * @return \PlanB\Utils\Builtin\Text\Text
     */
    public static function makeEncoded(string $text, Encoding $encoding): Text
    {
        return new self($text, $encoding);
    }

    /**
     * Crea una nueva instancia
     *
     * @param string $format
     * @param mixed ...$params
     *
     * @return \PlanB\Utils\Builtin\Text
     */
    public static function make(string $format, ...$params): Text
    {
        $text = sprintf($format, ...$params);

        return new self($text);
    }


    /**
     * @inheritdoc
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->text;
    }

    /**
     * Devuelve el encoding
     *
     * @return string
     */
    public function getEncoding(): string
    {
        return $this->encoding;
    }

    /**
     * Cambia el encoding del texto
     *
     * @param \PlanB\Utils\Builtin\Text\Encoding $newEncoding : El nuevo encoding
     *
     * @return \PlanB\Utils\Builtin\Text\Text
     */
    public function changeEncoding(Encoding $newEncoding): Text
    {
        $currentEncoding = Encoding::get($this->encoding);

        if ($newEncoding->is($currentEncoding)) {
            return new self($this->text, $currentEncoding);
        }

        $newText = mb_convert_encoding($this->text, (string) $newEncoding, (string) $currentEncoding);

        return new self($newText, $newEncoding);
    }

    /**
     * Devuelve la longitud del texto
     *
     * @return int
     */
    public function getLength(): int
    {
        return mb_strlen($this->text, $this->encoding);
    }

    /**
     * Indica si la cadena está vacia
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return self::EMPTY === $this->text;
    }

    /**
     * Indica si la cadena está vacia o compuesta sólo por espacios en blanco (saltos de linea, tabulaciones etc)
     *
     * @return bool
     */
    public function isBlank(): bool
    {
        return $this->trim()->isEmpty();
    }

    /**
     * Elimina caracteres del principio y del final de un texto
     *
     * @param string $charList : Los caracteres que serán eliminados
     *
     * @return \PlanB\Utils\Builtin\Text\Text
     */
    public function trim(string $charList = " \t\n\r\0\x0B"): self
    {

        $text = trim($this->text, $charList);

        return new self($text, $this->encoding);
    }

    /**
     * Elimina caracteres del principio de un texto
     *
     * @param string $charList : Los caracteres que serán eliminados
     *
     * @return \PlanB\Utils\Builtin\Text\Text
     */
    public function trimLeft(string $charList = " \t\n\r\0\x0B"): self
    {

        $text = ltrim($this->text, $charList);

        return new self($text, $this->encoding);
    }


    /**
     * Elimina caracteres del final de un texto
     *
     * @param string $charList : Los caracteres que serán eliminados
     *
     * @return \PlanB\Utils\Builtin\Text\Text
     */
    public function trimRight(string $charList = " \t\n\r\0\x0B"): self
    {

        $text = rtrim($this->text, $charList);

        return new self($text, $this->encoding);
    }

    /**
     * Devuelve las coincidencias con base a una expresión regular
     *
     * @param string $pattern
     *
     * @see https://www.php.net/manual/es/function.preg-match-all.php
     *
     * @return \PlanB\Utils\Builtin\Text\TextList
     */
    public function match(string $pattern): TextList
    {
        $words = [];
        preg_match_all($pattern, $this->text, $words);

        return TextList::make(...$words[1]);
    }

    /**
     * Devuelve un TextList con el resultado de dividir el texto con base a una expresión regular
     *
     * @param string $pattern
     *
     * @param int $limit
     * @param int $flags
     *
     * @return \PlanB\Utils\Builtin\Text\TextList
     *
     * @see https://www.php.net/manual/es/function.preg-split.php
     */
    public function split(string $pattern, int $limit = -1, int $flags = 0): TextList
    {
        $words = preg_split($pattern, $this->text, $limit, $flags);

        return TextList::make(...$words);
    }
}
