<?php

namespace Spartan\Fluent;

/**
 * Arr Fluent
 *
 * @package Spartan\Fluent
 * @author  Iulian N. <iulian@spartanphp.com>
 * @license LICENSE MIT
 */
class Arr
{
    const SPREAD = true;

    /*
     *
     * GENERICS
     *
     */

    /**
     * Process default value for array functions
     *
     * @param mixed $default
     *
     * @return mixed
     */
    public static function default($default)
    {
        return $default instanceof \Closure ? $default() : $default;
    }

    /*
     *
     * MANIPULATION METHODS
     *
     */

    /**
     * Append an element to an array
     *
     * @param iterable|array $iterable
     * @param mixed          $value
     *
     * @return array
     */
    public static function append(iterable $iterable, $value): iterable
    {
        array_push($iterable, $value);

        return $iterable;
    }

    /**
     * Prepend a value to an array
     *
     * @param iterable|array $iterable
     * @param mixed          $value
     *
     * @return array
     */
    public static function prepend(iterable $iterable, $value): iterable
    {
        array_unshift($iterable, $value);

        return $iterable;
    }

    /**
     * Apply a function to all array values
     *
     * @param iterable $iterable
     * @param mixed    $callback
     *
     * @return array
     */
    public static function map(iterable $iterable, $callback): iterable
    {
        foreach ($iterable as $key => $value) {
            $iterable[$key] = $callback($value, $key);
        }

        return $iterable;
    }

    /**
     * Apply a function to all array keys
     *
     * @param iterable $iterable
     * @param callable $callback
     *
     * @return array
     */
    public static function keyMap(iterable $iterable, callable $callback)
    {
        $result = [];

        foreach ($iterable as $key => $value) {
            $result[$callback($key, $value)] = $value;
        }

        return $result;
    }

    /**
     * Safer method of combining keys and values
     *
     * @param iterable|array $iterable
     * @param mixed          $values
     * @param mixed          $default
     *
     * @return array
     */
    public static function combine(iterable $iterable, $values, $default = null): iterable
    {
        if (!is_array($values)) {
            return array_combine($iterable, array_fill(0, count($iterable), $values));
        }

        $valCnt = count($values);
        $keyCnt = count($iterable);

        if ($valCnt < $keyCnt) {
            $values = array_pad($values, $keyCnt, self::default($default));
        }

        return array_combine($iterable, array_slice($values, 0, $keyCnt));
    }

    /**
     * Shuffle an array and keep index association
     *
     * @param iterable|array $iterable
     *
     * @return array
     */
    public static function shuffle(iterable $iterable): iterable
    {
        $keys = array_keys($iterable);
        shuffle($keys);

        $result = [];
        foreach ($keys as $key) {
            $result[$key] = $iterable[$key];
        }

        return $result;
    }

    /**
     * Flatten array
     *
     * @param iterable $iterable
     * @param string   $prefix
     * @param int      $depth
     *
     * @return array
     * @example self::flatten({"one": {"two": 12}}) == {"one.two": 12}
     */
    public static function flatten(iterable $iterable, $depth = PHP_INT_MAX, $prefix = ''): iterable
    {
        $result = [];
        foreach ($iterable as $key => $value) {
            if (is_array($value) && $value && $depth) {
                $result = array_merge($result, self::flatten($value, --$depth, $prefix . $key . '.'));
            } else {
                $result[$prefix . $key] = $value;
            }
        }

        return $result;
    }

    /**
     * Un-flatten an array
     *
     * @param iterable $iterable
     * @param int      $depth
     *
     * @return array
     */
    public static function unflatten(iterable $iterable, $depth = PHP_INT_MAX): iterable
    {
        $result = [];
        foreach ($iterable as $key => $value) {
            if (strpos($key, '.') && $depth) {
                $segments             = explode('.', $key, 2);
                $result[$segments[0]] = array_replace_recursive(
                    $result[$segments[0]] ?? [],
                    self::unflatten([$segments[1] => $value], --$depth)
                );
            } else {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    /**
     * Set a value in a non-flatten array using flatten notation
     *
     * @param iterable $iterable
     * @param          $key
     * @param          $value
     *
     * @return array|null
     * @TODO: fix edge case
     */
    public static function set(iterable $iterable, $key, $value)
    {
        if (is_null($key)) {
            return null;
        }

        $subArray = &$iterable;
        foreach (explode('.', $key) as $segment) {
            if (!array_key_exists($segment, $subArray)) {
                $subArray[$segment] = [];
            }
            $subArray = $subArray[$segment];
        }
        $subArray[] = $value;

        return $iterable;
    }

    /**
     * Zip an array
     *
     * @param iterable $iterable
     * @param array    $zip
     * @param null     $default
     *
     * @return array
     * @example self::zip([["a", "b"], ["x", "y"]]) == [["a", "x"],["b", "y"]]
     */
    public static function zip(iterable $iterable, array $zip, $default = null): iterable
    {
        foreach ($iterable as $key => &$value) {
            $value = self::append((array)$value, $zip[$key] ?? self::default($default));
        }

        return $iterable;
    }

    /**
     * Unzip an array
     *
     * @param iterable $iterable
     *
     * @return array
     * @example self::unzip([["a", "x"],["b", "y"]]) == [["a", "b"], ["x", "y"]]
     */
    public static function unzip(iterable $iterable): iterable
    {
        $result = [];

        foreach ($iterable as $values) {
            foreach ((array)$values as $key => $value) {
                $result[$key][] = $value;
            }
        }

        return $result;
    }

    /**
     * Collapse array values to an indexed array
     *
     * @param iterable $iterable
     *
     * @return array
     * @example self::collapse({"data": {"name": 10, "age": 20}}) == [10, 20]
     */
    public static function collapse(iterable $iterable)
    {
        $result = [];
        foreach ($iterable as $datum) {
            if (!is_array($datum)) {
                $result[] = $datum;
            } else {
                $result = array_merge($result, self::collapse($datum));
            }
        }

        return $result;
    }

    /**
     * Group values by a column or callback
     *
     * @param iterable $iterable
     * @param          $groupBy
     *
     * @return array
     * @example self::group([{"country": "us"}], "country") == {"us": [{"country": "us"}]}
     */
    public static function group(iterable $iterable, $groupBy): iterable
    {
        $result = [];

        if (is_string($groupBy)) {
            foreach ($iterable as $data) {
                $result[$data[$groupBy]][] = $data;
            }
        } else {
            foreach ($iterable as $data) {
                $result[$groupBy($data)][] = $data;
            }
        }

        return $result;
    }

    /**
     * Spread an array
     *
     * @param iterable $iterable
     * @param array    $keys
     *
     * @return array
     * @example self::spread([["John", "Doe"]], ["fname", "lname"]) == [{"fname": "John", "lname": "Doe"}]
     */
    public static function spread(iterable $iterable, array $keys): iterable
    {
        $result = [];

        foreach ($iterable as $values) {
            $result[] = self::combine($keys, $values);
        }

        return $result;
    }

    /**
     * Reduce an array to a single value
     *
     * @param iterable $iterable
     * @param          $callback
     * @param null     $start
     *
     * @return mixed
     */
    public static function reduce(iterable $iterable, $callback, $start = null)
    {
        foreach ($iterable as $value) {
            $start = $callback($start, $value);
        }

        return $start;
    }

    /**
     * Add k/v to all elements of a multi-dim array
     *
     * @param iterable $iterable
     * @param array    $with
     *
     * @return array
     */
    public static function with(iterable $iterable, array $with): iterable
    {
        foreach ($iterable as &$datum) {
            $datum += $with;
        }

        return $iterable;
    }

    /**
     * Array combine same keys with values
     *
     * @param iterable|array $iterable
     *
     * @return array
     * @example self::mirror([1, 2, 3]) == {"1": 1, "2": 2, "3": 3}
     */
    public static function mirror(iterable $iterable): iterable
    {
        return array_combine($iterable, $iterable);
    }

    /**
     * Array pairing
     *
     * @param iterable $iterable
     * @param          $keyCol
     * @param          $valCol
     *
     * @return array
     * @example self::pair([{"id": 1, "name": "John"}], "id", "name") == {"1": "John"}
     */
    public static function pair(iterable $iterable, $keyCol, $valCol): iterable
    {
        $result = [];

        foreach ($iterable as $data) {
            $result[$data[$keyCol]] = $data[$valCol] ?? null;
        }

        return $result;
    }

    /**
     * Array un-pairing
     *
     * @param iterable $iterable
     * @param          $keyName
     * @param          $valName
     *
     * @return array
     * @example self::unpair({"1": "John"}, "id", "name") == [{"id": 1, "name": "John"}]
     */
    public static function unpair(iterable $iterable, $keyName, $valName): iterable
    {
        $result = [];

        foreach ($iterable as $key => $value) {
            $result[] = [$keyName => $key, $valName => $value];
        }

        return $result;
    }

    /**
     * Array sort
     *
     * @param iterable $iterable
     * @param int      $mode
     * @param int      $order
     *
     * @return array
     */
    public static function sort(iterable $iterable, $order = SORT_ASC, $mode = SORT_NATURAL): iterable
    {
        $function = isset($iterable[0]) ? '' : 'a';
        $function .= $order === SORT_DESC ? 'r' : '';
        $function .= 'sort';

        $function($iterable, $mode);

        return $iterable;
    }

    /**
     * Array key sort
     *
     * @param iterable|array $iterable
     * @param int            $mode
     * @param int            $order
     *
     * @return array
     */
    public static function keySort(iterable $iterable, $order = SORT_ASC, $mode = SORT_NATURAL): iterable
    {
        if ($order === SORT_ASC) {
            ksort($iterable, $mode);
        } else {
            krsort($iterable, $mode);
        }

        return $iterable;
    }

    /**
     * Apply a user function recursively to every member of an array
     *
     * @param iterable|array $iterable
     * @param mixed          $callback
     * @param mixed          $meta
     *
     * @return array
     */
    public static function mapRecursive(iterable $iterable, $callback, $meta = null): iterable
    {
        array_walk_recursive($iterable, $callback, $meta);

        return $iterable;
    }

    /**
     * Merge values together
     *
     * @param iterable $iterable
     *
     * @return array
     */
    public static function union(iterable $iterable): iterable
    {
        $result = [];

        foreach ($iterable as $value) {
            $result += $value;
        }

        return $result;
    }

    /**
     * Transpose array
     *
     * @param iterable $iterable
     *
     * @return array
     */
    public static function transpose(iterable $iterable): iterable
    {
        $result = [];

        foreach ($iterable as $values) {
            foreach ($values as $key => $value) {
                $result[$key][] = $value;
            }
        }

        return $result;
    }

    /*
     *
     * EXTRACTION METHODS
     *
     */

    /**
     * Paginate an array
     *
     * @param iterable|array $iterable
     * @param int            $page
     * @param int            $perPage
     *
     * @return array
     * @example self::paginate(["One", "After", "Another"], 0, 2) == ["One", "After"]
     */
    public static function paginate(iterable $iterable, $page = 0, $perPage = 5): iterable
    {
        return array_slice($iterable, $page * $perPage, $perPage);
    }

    /**
     * Split an array into chunks
     *
     * @param iterable|array $iterable
     * @param int            $size
     *
     * @return array
     * @example self::chunk(["10", "20", "30"], 2) == [["10", "20"], ["30"]]
     */
    public static function chunk(iterable $iterable, int $size = 10): iterable
    {
        return array_chunk($iterable, $size);
    }

    /**
     * Get the nth element from an array
     *
     * @param iterable|array $iterable
     * @param int            $index
     * @param null           $default
     *
     * @return mixed|null
     */
    public static function pick(iterable $iterable, int $index = 0, $default = null)
    {
        return current(array_slice($iterable, $index, 1)) ?? self::default($default);
    }

    /**
     * Partition an array by a callback
     *
     * @param iterable $iterable
     * @param          $callback
     *
     * @return array
     */
    public static function partition(iterable $iterable, $callback): iterable
    {
        $partitions = [];

        foreach ($iterable as $value) {
            $partitions[$callback($value)][] = $value;
        }

        return $partitions;
    }

    /**
     * Remove the key from array and return it's value
     *
     * @param iterable $iterable
     * @param          $key
     * @param null     $default
     *
     * @return mixed|null
     */
    public static function pull(iterable &$iterable, $key, $default = null)
    {
        $result = $iterable[$key] ?? self::default($default);

        unset($iterable[$key]);

        return $result;
    }

    /**
     * Filter with count
     *
     * @param iterable $iterable
     * @param mixed    $callback
     * @param int      $limit
     *
     * @return array
     */
    public static function filter(iterable $iterable, $callback, int $limit = PHP_INT_MAX): iterable
    {
        $result = [];

        foreach ($iterable as $key => $value) {
            if ($callback($value, $key)) {
                $result[$key] = $value;
                $limit--;
            } else {
                unset($iterable[$key]);
            }

            if ($limit < 1) {
                break;
            }
        }

        return $result;
    }

    /*
     *
     * TERMINATION METHODS
     *
     */

    /**
     * Get first element from an array
     *
     * @param iterable|array $iterable
     * @param mixed          $default
     *
     * @return mixed
     */
    public static function first(iterable $iterable, $default = null)
    {
        if ($iterable) {
            reset($iterable);

            return current($iterable);
        }

        return self::default($default);
    }

    /**
     * Get last element from an array
     *
     * @param iterable|array $iterable
     * @param mixed          $default
     *
     * @return mixed
     */
    public static function last(iterable $iterable, $default = null)
    {
        if ($iterable) {
            end($iterable);

            return current($iterable);
        }

        return self::default($default);
    }

    /**
     * Check if an array has 1 or more values
     *
     * @param iterable|array $iterable
     * @param                $values
     * @param bool           $strict
     *
     * @return bool
     */
    public static function has(iterable $iterable, $values, $strict = false): bool
    {
        if (is_array($values)) {
            return count(array_intersect($iterable, $values)) == count($values);
        }

        return array_search($values, $iterable, $strict) !== false;
    }

    /**
     * Check if an array has 1 or more keys
     *
     * @param iterable|array $iterable
     * @param mixed          $keys
     *
     * @return bool
     */
    public static function hasKey(iterable $iterable, $keys): bool
    {
        if (is_array($keys)) {
            return count(array_intersect_key($iterable, array_flip($keys))) == count($keys);
        }

        return array_key_exists($keys, $iterable);
    }

    /**
     * Get a value from a flatten array
     *
     * @param iterable $iterable
     * @param          $key
     * @param null     $default
     *
     * @return array|mixed|null
     */
    public static function get(iterable $iterable, $key, $default = null)
    {
        if (isset($iterable[$key])) {
            return $iterable[$key];
        }

        if (is_null($key)) {
            return self::default($default);
        }

        foreach (explode('.', $key) as $item) {
            if (array_key_exists($item, $iterable)) {
                $iterable = $iterable[$item];
            } else {
                return self::default($default);
            }
        }

        return $iterable;
    }

    /**
     * Compute the max of an array
     *
     * @param iterable $iterable
     * @param int      $max
     *
     * @return int|string
     */
    public static function max(iterable $iterable, $max = PHP_INT_MIN)
    {
        foreach ($iterable as $value) {
            if (is_numeric($value)) {
                if ($value > $max) {
                    $max = $value;
                }
            }
        }

        return $max;
    }

    /**
     * Compute the min of an array
     *
     * @param iterable $iterable
     * @param int      $min
     *
     * @return int|string
     */
    public static function min(iterable $iterable, $min = PHP_INT_MAX)
    {
        foreach ($iterable as $value) {
            if (is_numeric($value)) {
                if ($value < $min) {
                    $min = $value;
                }
            }
        }

        return $min;
    }

    /**
     * Array product with default on empty
     *
     * @param iterable|array $iterable
     * @param int            $default
     *
     * @return float|int|mixed
     */
    public static function product(iterable $iterable, $default = 1)
    {
        if (!$iterable) {
            return self::default($default);
        }

        return array_product($iterable);
    }

    /**
     * Array sum with default on empty
     *
     * @param iterable|array $iterable
     * @param int            $default
     *
     * @return float|int|mixed
     */
    public static function sum(iterable $iterable, $default = 0)
    {
        if (!$iterable) {
            return self::default($default);
        }

        return array_sum($iterable);
    }

    /**
     * Compute array average
     *
     * @param iterable|array $iterable
     * @param int            $default
     *
     * @return float|int
     */
    public static function average(iterable $iterable, $default = 0)
    {
        if (!$iterable) {
            return self::default($default);
        }

        return array_sum($iterable) / count($iterable);
    }

    /**
     * Validate array with callback
     *
     * @param iterable $iterable
     * @param          $callback
     *
     * @return bool
     */
    public static function validate(iterable $iterable, $callback): bool
    {
        foreach ($iterable as $key => $value) {
            if ($callback($value, $key) === false) {
                return false;
            }
        }

        return true;
    }

    /**
     * Array join
     *
     * @param iterable $iterable
     * @param          $glue
     *
     * @return string
     */
    public static function join(iterable $iterable, $glue = ','): string
    {
        return implode($glue, $iterable);
    }

    /**
     * Get a random value from an array
     *
     * @param iterable|array $iterable
     * @param int            $count
     * @param null           $default
     *
     * @return mixed|null
     */
    public static function random(iterable $iterable, $count = 1, $default = null)
    {
        if (!$iterable) {
            return self::default($default);
        }

        return array_rand($iterable, $count);
    }

    /**
     * Iterate through an iterable without changing the values
     *
     * @param iterable $iterable
     * @param callable $callback
     *
     * @return iterable
     */
    public static function forEach(iterable $iterable, callable $callback)
    {
        foreach ($iterable as $key => $value) {
            $result = $callback($value, $key, $iterable);
            if ($result === false) {
                break;
            }
        }

        return $iterable;
    }

    /**
     * Use a value key as index
     *
     * @param iterable $iterable
     * @param string   $colKey
     *
     * @return array
     */
    public static function indexed(iterable $iterable, string $colKey)
    {
        $result = [];

        foreach ($iterable as $value) {
            $result[$value[$colKey]] = $value;
        }

        return $result;
    }

    /**
     * Alias of forEach
     *
     * @param iterable $iterable
     * @param          $callback
     *
     * @return iterable
     */
    public static function each(iterable $iterable, $callback)
    {
        return static::forEach($iterable, $callback);
    }
}
