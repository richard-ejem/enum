#!/usr/bin/env php
<?php
require_once __DIR__ . '/vendor/autoload.php';

function assertTrue(bool $condition, string $message = 'Assertion failed'): void {
    if (!$condition) {
        throw new \AssertionError($message);
    }
}
function assertThrows(
    callable $callback,
    string $throwableInstance = \Throwable::class,
    $message = 'Expected throwable was not thrown'
): void {
    try {
        $callback();
        throw new \AssertionError($message);
    } catch (\Throwable $e) {
        if (!$e instanceof $throwableInstance) {
            throw new \AssertionError(sprintf('%s, but %s thrown instead', $message, get_class($e)));
        }
    }
}

class Zero
{
    use \Ejem\Enum\EnumTrait;
}

class Enum
{
    const A = 'x';
    const B = 2;

    use \Ejem\Enum\EnumTrait;
}

assertTrue(count(Zero::getPossibleValues()) === 0, 'Empty class has no enum values');
assertTrue(Enum::getPossibleValues() === ['x', 2], 'EnumTrait::getPossibleValues returns possible values');
assertTrue(Enum::isValidValue('x'), '"x" is valid value of Enum');
assertTrue(Enum::isValidValue(2), '2 as integer is valid value of Enum');
assertTrue(!Enum::isValidValue('2'), '"2" as string is not valid value of Enum');
assertTrue(!Enum::isValidValue('3'), '"3" as string is not valid value of Enum');

assertThrows(function () {
    Enum::assertValidValue('3');
}, \Ejem\Enum\InvalidEnumValueException::class);

Enum::assertValidValue('x'); // we do not expect exception there

echo 'All tests passed.' . PHP_EOL;
