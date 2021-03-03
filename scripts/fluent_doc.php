<?php

/*
 * Auto generate doc comments for Fluent.php
 *
 * Process:
 * 1. Replace all @method with @auto-generate
 * 2. Run this script
 * 3. Check Fluent.php
 * 4. Enjoy!
 */

require_once __DIR__ . '/../src/Arr.php';
require_once __DIR__ . '/../src/Str.php';
require_once __DIR__ . '/../src/Obj.php';
require_once __DIR__ . '/../src/Php.php';

/** @var ReflectionMethod[] $methods */
$methods = array_merge(
    (new \ReflectionClass(\Spartan\Fluent\Arr::class))->getMethods(),
    (new \ReflectionClass(\Spartan\Fluent\Str::class))->getMethods(),
    (new \ReflectionClass(\Spartan\Fluent\Obj::class))->getMethods(),
    (new \ReflectionClass(\Spartan\Fluent\Php::class))->getMethods()
);

$fluentDocComment = [];

foreach ($methods as $method) {
    $desc        = trim(explode("\n", $method->getDocComment())[1], ' *');
    $paramCount  = $method->getNumberOfParameters();
    $paramString = [];

    if ($paramCount) {
        $params = $method->getParameters();
        foreach ($params as $index => $param) {
            if ($index == 0) {
                continue;
            }

            $hint = $param->getType()
                ? $param->getType()->getName()
                : '';

            $default = $param->isDefaultValueAvailable()
                ? $param->getDefaultValue()
                : '@@@';

            $constant = $param->isDefaultValueAvailable()
                ? ($param->isDefaultValueConstant() ? $param->getDefaultValueConstantName() : null)
                : null;

            $paramString[] = trim(
                sprintf(
                    '%s $%s = %s',
                    $hint,
                    $param->getName(),
                    $constant
                        ? $constant
                        : ($default === '@@@' ? '' : json_encode($default))
                ),
                ' ='
            );
        }
    }

    $return = $method->getReturnType();

    $fluentDocComment[] = sprintf(
        ' * @method %s %s(%s) %s',
        'self' . ($return ? '|' . $return->getName() : ''),
        $method->getName(),
        implode(', ', $paramString),
        $desc
    );
}

$fluentDocComment = array_merge(
    $fluentDocComment,
    [
        ' * @method self pad(int $size, mixed $value) Pad array to the specified length with a value',
        ' * @method self merge(array $array, ...$arrays) Merge one or more arrays',
        ' * @method self values() Return all the values of an array',
        ' * @method self keys() Return all the keys of an array',
        ' * @method self flip() Flip array',
        ' * @method self reverse(bool $preserve_keys = false) Return an array with elements in reverse order',
        ' * @method int count() Count array items',
    ]
);

$fluentDocComment = str_replace('Spartan\\Fluent\\', '', $fluentDocComment);

$contents = file_get_contents(__DIR__ . '/../src/Fluent.php');
$contents = str_replace(' * @auto-generate', implode("\n", $fluentDocComment), $contents);
file_put_contents(__DIR__ . '/../src/Fluent.php', $contents);
