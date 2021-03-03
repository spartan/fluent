<?php

namespace Spartan\Fluent;

/**
 * Fluent Fluent
 *
 * @method self default() Process default value for array functions
 * @method self|iterable append($value) Append an element to an array
 * @method self|iterable prepend($value) Prepend a value to an array
 * @method self|iterable map($callback) Apply a function to all array values
 * @method self keyMap(callable $callback) Apply a function to all array keys
 * @method self|iterable combine($values, $default = null) Safer method of combining keys and values
 * @method self|iterable shuffle() Shuffle an array and keep index association
 * @method self|iterable flatten($depth = PHP_INT_MAX, $prefix = "") Flatten array
 * @method self|iterable unflatten($depth = PHP_INT_MAX) Un-flatten an array
 * @method self set($key, $value) Set a value in a non-flatten array using flatten notation
 * @method self|iterable zip(array $zip, $default = null) Zip an array
 * @method self|iterable unzip() Unzip an array
 * @method self collapse() Collapse array values to an indexed array
 * @method self|iterable group($groupBy) Group values by a column or callback
 * @method self|iterable spread(array $keys) Spread an array
 * @method self reduce($callback, $start = null) Reduce an array to a single value
 * @method self|iterable with(array $with) Add k/v to all elements of a multi-dim array
 * @method self|iterable mirror() Array combine same keys with values
 * @method self|iterable pair($keyCol, $valCol) Array pairing
 * @method self|iterable unpair($keyName, $valName) Array un-pairing
 * @method self|iterable sort($order = SORT_ASC, $mode = SORT_NATURAL) Array sort
 * @method self|iterable keySort($order = SORT_ASC, $mode = SORT_NATURAL) Array key sort
 * @method self|iterable mapRecursive($callback, $meta = null) Apply a user function recursively to every member of an array
 * @method self|iterable union() Merge values together
 * @method self|iterable transpose() Transpose array
 * @method self|iterable paginate($page = 0, $perPage = 5) Paginate an array
 * @method self|iterable chunk(int $size = 10) Split an array into chunks
 * @method self pick(int $index = 0, $default = null) Get the nth element from an array
 * @method self|iterable partition($callback) Partition an array by a callback
 * @method self pull($key, $default = null) Remove the key from array and return it's value
 * @method self|iterable filter($callback, int $limit = PHP_INT_MAX) Filter with count
 * @method self first($default = null) Get first element from an array
 * @method self last($default = null) Get last element from an array
 * @method self|bool has($values, $strict = false) Check if an array has 1 or more values
 * @method self|bool hasKey($keys) Check if an array has 1 or more keys
 * @method self get($key, $default = null) Get a value from a flatten array
 * @method self max($max = PHP_INT_MIN) Compute the max of an array
 * @method self min($min = PHP_INT_MAX) Compute the min of an array
 * @method self product($default = 1) Array product with default on empty
 * @method self sum($default = 0) Array sum with default on empty
 * @method self average($default = 0) Compute array average
 * @method self|bool validate($callback) Validate array with callback
 * @method self|string join($glue = ",") Array join
 * @method self random($count = 1, $default = null) Get a random value from an array
 * @method self forEach(callable $callback) Iterate through an iterable without changing the values
 * @method self indexed(string $colKey) Use a value key as index
 * @method self each($callback) Alias of forEach
 * @method self|string lowerCase(string $encoding = "UTF-8") Convert a string to lowercase
 * @method self|string upperCase(string $encoding = "UTF-8") Convert a string to uppercase
 * @method self|string titleCase(string $encoding = "UTF-8") Capitalize words
 * @method self|string lowerFirst(string $encoding = "UTF-8") Converts first letter of a string to lowercase
 * @method self|string upperFirst(string $encoding = "UTF-8") Converts first letter of a string to uppercase
 * @method self|string escapeHtml() Escape HTML
 * @method self|string slice(int $start = 0, int $length = null, string $encoding = "UTF-8") Get a slice from a string
 * @method self|string truncate(int $length = 16, string $separator = "", string $omission = "...") Truncate string
 * @method self|array words(int $limit = -1) Convert a string into an array of words
 * @method self|int length() Unicode strlen
 * @method self|string replace(array $substitutions) Alias of strtr
 * @method self|array chunks(int $length = 1) Alias of str_split
 * @method self|array divide(string $pattern = "", int $limit = -1) Safe split a string by a delimiter/pattern
 * @method self|string uuid() Generate a UUIDv4
 * @method self|string ascii() Strip all characters that are non-ascii
 * @method self|string slug() Convert a string into a slug
 * @method self|string latin() Convert characters to latin
 * @method self|string encrypt(string $salt = null, string $nonce = null, string $key = null) Encrypt text using sodium extension
 * @method self|string decrypt(string $salt = null, string $nonce = null, string $key = null) Decrypt text using sodium extension
 * @method self|string script() Detect writing script for the string.
 * @method self xpath(string $xpath, $useDomFallback = true) Run xpath on xml string
 * @method self split(string $separator = ",", int $limit = PHP_INT_MAX) Use javascript notation
 * @method self generate(string $values = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789") Generate a random string.
 * @method self|array fromCsvFile(bool $withHeader = self::WITH_HEADER) Load from csv file into an array
 * @method self|array toCsvFile(array $data, bool $withHeader = self::WITH_HEADER) Save string to a csv file
 * @method self|array constants($visibility = null) @param mixed $subject
 * @method self|array properties($visibility = null) @param      $subject
 * @method self|array methods($visibility = null) @param      $subject
 * @method self safe() @param $subject
 * @method self|string classBaseName() @param object|string $className
 * @method self|string classNameSpace() @param object|string $className
 * @method self encode(int $options = 0) JSON encode
 * @method self decode(bool $assoc = true) JSON decode
 * @method self serialize() Safe serialization of closures
 * @method self unserialize(array $options = []) Safe unserialization of closures
 * @method self read() Read from file
 * @method self write(string $file) Write to file
 * @method self pad(int $size, mixed $value) Pad array to the specified length with a value
 * @method self merge(array $array, ...$arrays) Merge one or more arrays
 * @method self values() Return all the values of an array
 * @method self keys() Return all the keys of an array
 * @method self flip() Flip array
 * @method self reverse(bool $preserve_keys = false) Return an array with elements in reverse order
 * @method int count() Count array items
 *
 * @property mixed $data
 *
 * @package Spartan\Fluent
 * @author  Iulian N. <iulian@spartanphp.com>
 * @license LICENSE MIT
 */
class Fluent implements \ArrayAccess, \Iterator
{
    /**
     * @var array|mixed
     */
    protected $data;

    protected int $options;

    protected int $position = 0;

    /**
     * Fluent constructor.
     *
     * @param     $data
     * @param int $options
     */
    public function __construct($data = null, int $options = 0)
    {
        $this->data    = $data;
        $this->options = $options;
    }

    public function toArray(): array
    {
        return (array)$this->data;
    }

    /**
     * @return string|mixed
     */
    public function toJson()
    {
        return json_encode($this->data);
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        if (is_array($this->data)) {
            return implode('', $this->data);
        }

        return (string)$this->toJson();
    }

    /**
     * Overwrite collection
     *
     * @param mixed $callback
     *
     * @return Fluent
     */
    public function overwrite($callback)
    {
        $this->data = $callback instanceof \Closure
            ? $callback($this->data)
            : $callback;

        return $this;
    }

    /**
     * Magic get data|result
     *
     * @param string $name
     *
     * @return array|mixed
     */
    public function __get(string $name)
    {
        return $this->data;
    }

    /**
     * @param $name
     * @param $args
     *
     * @return Fluent|mixed
     * @throws \InvalidArgumentException
     */
    public function __call($name, $args)
    {
        $clone = clone $this;

        if (method_exists(Arr::class, $name)) {
            $clone->data = Arr::{$name}($this->data, ...$args);
        } elseif (function_exists("array_{$name}")) {
            $function    = "array_{$name}";
            $clone->data = $function($this->data, ...$args);
        } elseif (method_exists(Str::class, $name)) {
            // apply Str function recursively if $data is array
            if (is_array($clone->data)) {
                foreach ($this->data as &$datum) {
                    $datum = Str::{$name}($datum, ...$args);
                }
            } else {
                $clone->data = Str::{$name}($this->data, ...$args);
            }
        } elseif (function_exists("str_{$name}")) {
            $function    = "str_{$name}";
            $clone->data = $function($this->data, ...$args);
        } elseif (method_exists(Obj::class, $name)) {
            $clone->data = Obj::{$name}($this->data, ...$args);
        } elseif (method_exists(Php::class, $name)) {
            $clone->data = Php::{$name}($this->data, ...$args);
        } elseif (function_exists($name)) {
            $clone->data = $name($this->data, ...$args);
        } else {
            throw new \InvalidArgumentException('Fluent method not supported: ' . $name);
        }

        return $clone;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

    /*
     * Interfaces
     */

    /**
     * @inheritDoc
     */
    public function offsetExists($offset)
    {
        return is_array($this->data)
            && array_key_exists($offset, $this->data);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        return is_array($this->data)
            ? $this->data[$offset] ?? null
            : null;
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value)
    {
        is_array($this->data)
            ? $this->data[$offset] = $value
            : $this->data = [$offset => $value];
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset)
    {
        if (is_array($this->data)) {
            unset($this->data[$offset]);
        }
    }

    /**
     * @inheritDoc
     */
    public function current()
    {
        return $this->data[$this->position];
    }

    /**
     * @inheritDoc
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * @inheritDoc
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * @inheritDoc
     */
    public function valid()
    {
        return isset($this->data[$this->position]);
    }

    /**
     * @inheritDoc
     */
    public function rewind()
    {
        $this->position = 0;
    }
}
