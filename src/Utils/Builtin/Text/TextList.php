<?php

/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PlanB\Utils\Builtin\Text;

/**
 * Lista de objetos tipo Text
 */
class TextList implements \IteratorAggregate, \Countable
{

    /**
     * @var \ArrayIterator
     */
    private $words;

    /**
     * TextList constructor.
     *
     * @param \PlanB\Utils\Builtin\Text\Text ...$words
     */
    private function __construct(Text ...$words)
    {
        $this->words = new \ArrayIterator($words);
    }

    /**
     * Crea una instancia a partir de varias cadenas de texto
     *
     * @param string ...$words
     *
     * @return \PlanB\Utils\Builtin\Text\TextList
     */
    public static function make(string ...$words): TextList
    {
        $words = array_map(static function ($word) {
            return Text::make($word);
        }, $words);

        return new self(...$words);
    }

    /**
     * @inheritdoc
     *
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     *
     * @return \ArrayIterator
     */
    public function getIterator(): \ArrayIterator
    {
        return $this->words;
    }

    /**
     * Devuelve el número de elementos de la lista
     *
     * @return int
     */
    public function count(): int
    {
        return \count($this->words);
    }

    /**
     * Indica si la lista está vacia
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return 0 === $this->count();
    }

    /**
     * Devuelve un array con los valores como cadenas de texto
     *
     * @return string[]
     */
    private function getArrayCopy(): array
    {
        return array_map(static function (Text $text) {
            return (string) $text;
        }, $this->words->getArrayCopy());
    }

    /**
     * Une los elementos en un único objeto Text
     *
     * @param string $delimiter
     *
     * @return \PlanB\Utils\Builtin\Text\Text
     */
    public function join(string $delimiter): Text
    {
        $words = $this->getArrayCopy();

        $newText = implode($delimiter, $words);

        return Text::make($newText);
    }

    /**
     * Aplica un callback a todos los elementos de la colección
     *
     * @param callable $callback
     *
     * @return \PlanB\Utils\Builtin\Text\TextList
     */
    public function map(callable $callback): TextList
    {
        $words = array_map($callback, $this->words->getArrayCopy());

        return self::make(...$words);
    }
}
