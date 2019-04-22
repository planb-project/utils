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
     * @see https://www.php.net/manual/es/function.preg-split.php
     *
     * @return \PlanB\Utils\Builtin\Text\TextList
     */
    public function split(string $pattern, int $limit = -1, int $flags = 0): TextList
    {
        $words = preg_split($pattern, $this->text, $limit, $flags);

        return TextList::make(...$words);
    }


    /**
     * Devuelve un TextList con las palabras del texto
     * Es un alias de split con la expresión regular '/[\W_]/' como delimitador
     * (se trocea por cualquier caracter que no sea una letra o un número)
     *
     * @return \PlanB\Utils\Builtin\Text\TextList
     */
    public function getWords(): TextList
    {
        return $this->split('/[\W_]+/u');
    }

    /**
     * Convierte el texto a mayusculas
     *
     * @see https://www.php.net/manual/es/function.mb-strtoupper.php
     *
     * @return \PlanB\Utils\Builtin\Text\Text
     */
    public function toUpperCase(): Text
    {
        $newText = mb_strtoupper($this->text, $this->encoding);

        return Text::make($newText);
    }


    /**
     * Convierte a mayusculas la letra inicial
     *
     * @see https://www.php.net/manual/es/function.ucfirst.php
     *
     * @return \PlanB\Utils\Builtin\Text\Text
     */
    public function toUpperCaseFirst(): Text
    {
        $first = mb_substr($this->text, 0, 1, $this->encoding);
        $theRest = mb_substr($this->text, 1, null, $this->encoding);
        $newText = mb_strtoupper($first, $this->encoding).$theRest;

        return Text::make($newText);
    }

    /**
     * Convierte el texto a minusculas
     *
     * @see https://www.php.net/manual/es/function.mb-strtolower.php
     *
     * @return \PlanB\Utils\Builtin\Text\Text
     */
    public function toLowerCase(): \PlanB\Utils\Builtin\Text\Text
    {
        $newText = mb_strtolower($this->text, $this->encoding);

        return Text::make($newText);
    }

    /**
     * Convierte a minusculas la letra inicial
     *
     * @see https://www.php.net/manual/es/function.lcfirst.php
     *
     * @return \PlanB\Utils\Builtin\Text\Text
     */
    public function toLowerCaseFirst(): \PlanB\Utils\Builtin\Text\Text
    {
        $first = mb_substr($this->text, 0, 1, $this->encoding);
        $theRest = mb_substr($this->text, 1, null, $this->encoding);
        $newText = mb_strtolower($first, $this->encoding).$theRest;

        return Text::make($newText);
    }

    /**
     * Convierte el texto a formato Title
     * la letra inicial de cada palabra el mayusculas, y el resto en minusculas
     *
     * @example texto de ejemplo => Texto De Ejemplo
     *
     * @return \PlanB\Utils\Builtin\Text|\PlanB\Utils\Builtin\Text\Text
     */
    public function toTitleCase()
    {
        $newText = mb_convert_case($this->text, MB_CASE_TITLE, $this->encoding);

        return Text::make($newText);
    }

    /**
     * Convierte el texto a Pascal Case
     * la letra inicial de cada palabra el mayusculas, y el resto en minusculas
     *
     * @param string|null $delimiter
     *
     * @return \PlanB\Utils\Builtin\Text\Text
     */
    public function toPascalCase(?string $delimiter = null): Text
    {
        $delimiter = $delimiter ?? Text::EMPTY;

        return $this->getWords()
            ->map(static function (Text $text) {
                return $text->toTitleCase();
            })
            ->join($delimiter);
    }
}
