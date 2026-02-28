<?php

namespace {

    /**
     * Runs the given closure after each test in the current file.
     *
     * @param-closure-this \AceOfAces\LaravelImageTransformUrl\Tests\TestCase  $closure
     *
     * @return \Pest\Concerns\Expectable|\Pest\Support\HigherOrderTapProxy<\Pest\Concerns\Expectable|\Pest\PendingCalls\TestCall|\AceOfAces\LaravelImageTransformUrl\Tests\TestCase>|\Pest\PendingCalls\TestCall|mixed
     */
    function afterEach(?Closure $closure = null): \Pest\PendingCalls\AfterEachCall {}

    /**
     * Runs the given closure before each test in the current file.
     *
     * @param-closure-this \AceOfAces\LaravelImageTransformUrl\Tests\TestCase  $closure
     *
     * @return \Pest\Support\HigherOrderTapProxy<\Pest\Concerns\Expectable|\Pest\PendingCalls\TestCall|\AceOfAces\LaravelImageTransformUrl\Tests\TestCase|mixed
     */
    function beforeEach(?Closure $closure = null): \Pest\PendingCalls\BeforeEachCall {}

    /**
     * Adds the given closure as a test. The first argument
     * is the test description; the second argument is
     * a closure that contains the test expectations.
     *
     * @param-closure-this \AceOfAces\LaravelImageTransformUrl\Tests\TestCase  $closure
     *
     * @return \Pest\Concerns\Expectable|\Pest\PendingCalls\TestCall|\AceOfAces\LaravelImageTransformUrl\Tests\TestCase|mixed
     */
    function test(?string $description = null, ?Closure $closure = null): \Pest\Support\HigherOrderTapProxy|\Pest\PendingCalls\TestCall {}

    /**
     * Adds the given closure as a test. The first argument
     * is the test description; the second argument is
     * a closure that contains the test expectations.
     *
     * @param-closure-this \AceOfAces\LaravelImageTransformUrl\Tests\TestCase  $closure
     *
     * @return \Pest\Concerns\Expectable|\Pest\PendingCalls\TestCall|\AceOfAces\LaravelImageTransformUrl\Tests\TestCase|mixed
     */
    function it(string $description, ?Closure $closure = null): \Pest\PendingCalls\TestCall {}

}

namespace Pest {

    /**
     * @method self toBeImage()
     */
    class Expectation
    {
        /**
         * Asserts that two variables have the same type and
         * value. Used on objects, it asserts that two
         * variables reference the same object.
         *
         * @return self<TValue>
         */
        public function toBe(mixed $expected, string $message = ''): self {}

        /**
         * Asserts that the value is empty.
         *
         * @return self<TValue>
         */
        public function toBeEmpty(string $message = ''): self {}

        /**
         * Asserts that the value is true.
         *
         * @return self<TValue>
         */
        public function toBeTrue(string $message = ''): self {}

        /**
         * Asserts that the value is truthy.
         *
         * @return self<TValue>
         */
        public function toBeTruthy(string $message = ''): self {}

        /**
         * Asserts that the value is false.
         *
         * @return self<TValue>
         */
        public function toBeFalse(string $message = ''): self {}

        /**
         * Asserts that the value is falsy.
         *
         * @return self<TValue>
         */
        public function toBeFalsy(string $message = ''): self {}

        /**
         * Asserts that the value is greater than $expected.
         *
         * @return self<TValue>
         */
        public function toBeGreaterThan(int|float|string|\DateTimeInterface $expected, string $message = ''): self {}

        /**
         * Asserts that the value is greater than or equal to $expected.
         *
         * @return self<TValue>
         */
        public function toBeGreaterThanOrEqual(int|float|string|\DateTimeInterface $expected, string $message = ''): self {}

        /**
         * Asserts that the value is less than or equal to $expected.
         *
         * @return self<TValue>
         */
        public function toBeLessThan(int|float|string|\DateTimeInterface $expected, string $message = ''): self {}

        /**
         * Asserts that the value is less than $expected.
         *
         * @return self<TValue>
         */
        public function toBeLessThanOrEqual(int|float|string|\DateTimeInterface $expected, string $message = ''): self {}

        /**
         * Asserts that $needle is an element of the value.
         *
         * @return self<TValue>
         */
        public function toContain(mixed ...$needles): self {}

        /**
         * Asserts that $needle equal an element of the value.
         *
         * @return self<TValue>
         */
        public function toContainEqual(mixed ...$needles): self {}

        /**
         * Asserts that the value starts with $expected.
         *
         * @param  non-empty-string  $expected
         * @return self<TValue>
         */
        public function toStartWith(string $expected, string $message = ''): self {}

        /**
         * Asserts that the value ends with $expected.
         *
         * @param  non-empty-string  $expected
         * @return self<TValue>
         */
        public function toEndWith(string $expected, string $message = ''): self {}

        /**
         * Asserts that $number matches value's Length.
         *
         * @return self<TValue>
         */
        public function toHaveLength(int $number, string $message = ''): self {}

        /**
         * Asserts that $count matches the number of elements of the value.
         *
         * @return self<TValue>
         */
        public function toHaveCount(int $count, string $message = ''): self {}

        /**
         * Asserts that the size of the value and $expected are the same.
         *
         * @param  \Countable|iterable<mixed>  $expected
         * @return self<TValue>
         */
        public function toHaveSameSize(\Countable|iterable $expected, string $message = ''): self {}

        /**
         * Asserts that the value contains the property $name.
         *
         * @return self<TValue>
         */
        public function toHaveProperty(string $name, mixed $value = new \Pest\Matchers\Any, string $message = ''): self {}

        /**
         * Asserts that the value contains the provided properties $names.
         *
         * @param  iterable<string, mixed>|iterable<int, string>  $names
         * @return self<TValue>
         */
        public function toHaveProperties(iterable $names, string $message = ''): self {}

        /**
         * Asserts that two variables have the same value.
         *
         * @return self<TValue>
         */
        public function toEqual(mixed $expected, string $message = ''): self {}

        /**
         * Asserts that two variables have the same value.
         * The contents of $expected and the $this->value are
         * canonicalized before they are compared. For instance, when the two
         * variables $expected and $this->value are arrays, then these arrays
         * are sorted before they are compared. When $expected and $this->value
         * are objects, each object is converted to an array containing all
         * private, protected and public attributes.
         *
         * @return self<TValue>
         */
        public function toEqualCanonicalizing(mixed $expected, string $message = ''): self {}

        /**
         * Asserts that the absolute difference between the value and $expected
         * is lower than $delta.
         *
         * @return self<TValue>
         */
        public function toEqualWithDelta(mixed $expected, float $delta, string $message = ''): self {}

        /**
         * Asserts that the value is one of the given values.
         *
         * @param  iterable<int|string, mixed>  $values
         * @return self<TValue>
         */
        public function toBeIn(iterable $values, string $message = ''): self {}

        /**
         * Asserts that the value is infinite.
         *
         * @return self<TValue>
         */
        public function toBeInfinite(string $message = ''): self {}

        /**
         * Asserts that the value is an instance of $class.
         *
         * @param  class-string  $class
         * @return self<TValue>
         */
        public function toBeInstanceOf(string $class, string $message = ''): self {}

        /**
         * Asserts that the value is an array.
         *
         * @return self<TValue>
         */
        public function toBeArray(string $message = ''): self {}

        /**
         * Asserts that the value is a list.
         *
         * @return self<TValue>
         */
        public function toBeList(string $message = ''): self {}

        /**
         * Asserts that the value is of type bool.
         *
         * @return self<TValue>
         */
        public function toBeBool(string $message = ''): self {}

        /**
         * Asserts that the value is of type callable.
         *
         * @return self<TValue>
         */
        public function toBeCallable(string $message = ''): self {}

        /**
         * Asserts that the value is of type float.
         *
         * @return self<TValue>
         */
        public function toBeFloat(string $message = ''): self {}

        /**
         * Asserts that the value is of type int.
         *
         * @return self<TValue>
         */
        public function toBeInt(string $message = ''): self {}

        /**
         * Asserts that the value is of type iterable.
         *
         * @return self<TValue>
         */
        public function toBeIterable(string $message = ''): self {}

        /**
         * Asserts that the value is of type numeric.
         *
         * @return self<TValue>
         */
        public function toBeNumeric(string $message = ''): self {}

        /**
         * Asserts that the value contains only digits.
         *
         * @return self<TValue>
         */
        public function toBeDigits(string $message = ''): self {}

        /**
         * Asserts that the value is of type object.
         *
         * @return self<TValue>
         */
        public function toBeObject(string $message = ''): self {}

        /**
         * Asserts that the value is of type resource.
         *
         * @return self<TValue>
         */
        public function toBeResource(string $message = ''): self {}

        /**
         * Asserts that the value is of type scalar.
         *
         * @return self<TValue>
         */
        public function toBeScalar(string $message = ''): self {}

        /**
         * Asserts that the value is of type string.
         *
         * @return self<TValue>
         */
        public function toBeString(string $message = ''): self {}

        /**
         * Asserts that the value is a JSON string.
         *
         * @return self<TValue>
         */
        public function toBeJson(string $message = ''): self {}

        /**
         * Asserts that the value is NAN.
         *
         * @return self<TValue>
         */
        public function toBeNan(string $message = ''): self {}

        /**
         * Asserts that the value is null.
         *
         * @return self<TValue>
         */
        public function toBeNull(string $message = ''): self {}

        /**
         * Asserts that the value array has the provided $key.
         *
         * @return self<TValue>
         */
        public function toHaveKey(string|int $key, mixed $value = new \Pest\Matchers\Any, string $message = ''): self {}

        /**
         * Asserts that the value array has the provided $keys.
         *
         * @param  array<int, int|string|array<array-key, mixed>>  $keys
         * @return self<TValue>
         */
        public function toHaveKeys(array $keys, string $message = ''): self {}

        /**
         * Asserts that the value is a directory.
         *
         * @return self<TValue>
         */
        public function toBeDirectory(string $message = ''): self {}

        /**
         * Asserts that the value is a directory and is readable.
         *
         * @return self<TValue>
         */
        public function toBeReadableDirectory(string $message = ''): self {}

        /**
         * Asserts that the value is a directory and is writable.
         *
         * @return self<TValue>
         */
        public function toBeWritableDirectory(string $message = ''): self {}

        /**
         * Asserts that the value is a file.
         *
         * @return self<TValue>
         */
        public function toBeFile(string $message = ''): self {}

        /**
         * Asserts that the value is a file and is readable.
         *
         * @return self<TValue>
         */
        public function toBeReadableFile(string $message = ''): self {}

        /**
         * Asserts that the value is a file and is writable.
         *
         * @return self<TValue>
         */
        public function toBeWritableFile(string $message = ''): self {}

        /**
         * Asserts that the value array matches the given array subset.
         *
         * @param  iterable<int|string, mixed>  $array
         * @return self<TValue>
         */
        public function toMatchArray(iterable $array, string $message = ''): self {}

        /**
         * Asserts that the value object matches a subset
         * of the properties of an given object.
         *
         * @param  iterable<string, mixed>  $object
         * @return self<TValue>
         */
        public function toMatchObject(object|iterable $object, string $message = ''): self {}

        /**
         * Asserts that the value "stringable" matches the given snapshot..
         *
         * @return self<TValue>
         */
        public function toMatchSnapshot(string $message = ''): self {}

        /**
         * Asserts that the value matches a regular expression.
         *
         * @return self<TValue>
         */
        public function toMatch(string $expression, string $message = ''): self {}

        /**
         * Asserts that the value matches a constraint.
         *
         * @return self<TValue>
         */
        public function toMatchConstraint(\PHPUnit\Framework\Constraint\Constraint $constraint, string $message = ''): self {}

        /**
         * @param  class-string  $class
         * @return self<TValue>
         */
        public function toContainOnlyInstancesOf(string $class, string $message = ''): self {}

        /**
         * Asserts that executing value throws an exception.
         *
         * @param  (\Closure(\Throwable): mixed)|string  $exception
         * @return self<TValue>
         */
        public function toThrow(callable|string|\Throwable $exception, ?string $exceptionMessage = null, string $message = ''): self {}

        /**
         * Asserts that the value is uppercase.
         *
         * @return self<TValue>
         */
        public function toBeUppercase(string $message = ''): self {}

        /**
         * Asserts that the value is lowercase.
         *
         * @return self<TValue>
         */
        public function toBeLowercase(string $message = ''): self {}

        /**
         * Asserts that the value is alphanumeric.
         *
         * @return self<TValue>
         */
        public function toBeAlphaNumeric(string $message = ''): self {}

        /**
         * Asserts that the value is alpha.
         *
         * @return self<TValue>
         */
        public function toBeAlpha(string $message = ''): self {}

        /**
         * Asserts that the value is snake_case.
         *
         * @return self<TValue>
         */
        public function toBeSnakeCase(string $message = ''): self {}

        /**
         * Asserts that the value is kebab-case.
         *
         * @return self<TValue>
         */
        public function toBeKebabCase(string $message = ''): self {}

        /**
         * Asserts that the value is camelCase.
         *
         * @return self<TValue>
         */
        public function toBeCamelCase(string $message = ''): self {}

        /**
         * Asserts that the value is StudlyCase.
         *
         * @return self<TValue>
         */
        public function toBeStudlyCase(string $message = ''): self {}

        /**
         * Asserts that the value is UUID.
         *
         * @return self<TValue>
         */
        public function toBeUuid(string $message = ''): self {}

        /**
         * Asserts that the value is between 2 specified values
         *
         * @return self<TValue>
         */
        public function toBeBetween(int|float|\DateTimeInterface $lowestValue, int|float|\DateTimeInterface $highestValue, string $message = ''): self {}

        /**
         * Asserts that the value is a url
         *
         * @return self<TValue>
         */
        public function toBeUrl(string $message = ''): self {}

        /**
         * Asserts that the value can be converted to a slug
         *
         * @return self<TValue>
         */
        public function toBeSlug(string $message = ''): self {}
    }

}

namespace Pest\Expectations {

    /**
     * @method self toBeImage()
     */
    class OppositeExpectation
    {
        /**
         * Asserts that two variables have the same type and
         * value. Used on objects, it asserts that two
         * variables reference the same object.
         *
         * @return self<TValue>
         */
        public function toBe(mixed $expected, string $message = ''): self {}

        /**
         * Asserts that the value is empty.
         *
         * @return self<TValue>
         */
        public function toBeEmpty(string $message = ''): self {}

        /**
         * Asserts that the value is true.
         *
         * @return self<TValue>
         */
        public function toBeTrue(string $message = ''): self {}

        /**
         * Asserts that the value is truthy.
         *
         * @return self<TValue>
         */
        public function toBeTruthy(string $message = ''): self {}

        /**
         * Asserts that the value is false.
         *
         * @return self<TValue>
         */
        public function toBeFalse(string $message = ''): self {}

        /**
         * Asserts that the value is falsy.
         *
         * @return self<TValue>
         */
        public function toBeFalsy(string $message = ''): self {}

        /**
         * Asserts that the value is greater than $expected.
         *
         * @return self<TValue>
         */
        public function toBeGreaterThan(int|float|string|\DateTimeInterface $expected, string $message = ''): self {}

        /**
         * Asserts that the value is greater than or equal to $expected.
         *
         * @return self<TValue>
         */
        public function toBeGreaterThanOrEqual(int|float|string|\DateTimeInterface $expected, string $message = ''): self {}

        /**
         * Asserts that the value is less than or equal to $expected.
         *
         * @return self<TValue>
         */
        public function toBeLessThan(int|float|string|\DateTimeInterface $expected, string $message = ''): self {}

        /**
         * Asserts that the value is less than $expected.
         *
         * @return self<TValue>
         */
        public function toBeLessThanOrEqual(int|float|string|\DateTimeInterface $expected, string $message = ''): self {}

        /**
         * Asserts that $needle is an element of the value.
         *
         * @return self<TValue>
         */
        public function toContain(mixed ...$needles): self {}

        /**
         * Asserts that $needle equal an element of the value.
         *
         * @return self<TValue>
         */
        public function toContainEqual(mixed ...$needles): self {}

        /**
         * Asserts that the value starts with $expected.
         *
         * @param  non-empty-string  $expected
         * @return self<TValue>
         */
        public function toStartWith(string $expected, string $message = ''): self {}

        /**
         * Asserts that the value ends with $expected.
         *
         * @param  non-empty-string  $expected
         * @return self<TValue>
         */
        public function toEndWith(string $expected, string $message = ''): self {}

        /**
         * Asserts that $number matches value's Length.
         *
         * @return self<TValue>
         */
        public function toHaveLength(int $number, string $message = ''): self {}

        /**
         * Asserts that $count matches the number of elements of the value.
         *
         * @return self<TValue>
         */
        public function toHaveCount(int $count, string $message = ''): self {}

        /**
         * Asserts that the size of the value and $expected are the same.
         *
         * @param  \Countable|iterable<mixed>  $expected
         * @return self<TValue>
         */
        public function toHaveSameSize(\Countable|iterable $expected, string $message = ''): self {}

        /**
         * Asserts that the value contains the property $name.
         *
         * @return self<TValue>
         */
        public function toHaveProperty(string $name, mixed $value = new \Pest\Matchers\Any, string $message = ''): self {}

        /**
         * Asserts that the value contains the provided properties $names.
         *
         * @param  iterable<string, mixed>|iterable<int, string>  $names
         * @return self<TValue>
         */
        public function toHaveProperties(iterable $names, string $message = ''): self {}

        /**
         * Asserts that two variables have the same value.
         *
         * @return self<TValue>
         */
        public function toEqual(mixed $expected, string $message = ''): self {}

        /**
         * Asserts that two variables have the same value.
         * The contents of $expected and the $this->value are
         * canonicalized before they are compared. For instance, when the two
         * variables $expected and $this->value are arrays, then these arrays
         * are sorted before they are compared. When $expected and $this->value
         * are objects, each object is converted to an array containing all
         * private, protected and public attributes.
         *
         * @return self<TValue>
         */
        public function toEqualCanonicalizing(mixed $expected, string $message = ''): self {}

        /**
         * Asserts that the absolute difference between the value and $expected
         * is lower than $delta.
         *
         * @return self<TValue>
         */
        public function toEqualWithDelta(mixed $expected, float $delta, string $message = ''): self {}

        /**
         * Asserts that the value is one of the given values.
         *
         * @param  iterable<int|string, mixed>  $values
         * @return self<TValue>
         */
        public function toBeIn(iterable $values, string $message = ''): self {}

        /**
         * Asserts that the value is infinite.
         *
         * @return self<TValue>
         */
        public function toBeInfinite(string $message = ''): self {}

        /**
         * Asserts that the value is an instance of $class.
         *
         * @param  class-string  $class
         * @return self<TValue>
         */
        public function toBeInstanceOf(string $class, string $message = ''): self {}

        /**
         * Asserts that the value is an array.
         *
         * @return self<TValue>
         */
        public function toBeArray(string $message = ''): self {}

        /**
         * Asserts that the value is a list.
         *
         * @return self<TValue>
         */
        public function toBeList(string $message = ''): self {}

        /**
         * Asserts that the value is of type bool.
         *
         * @return self<TValue>
         */
        public function toBeBool(string $message = ''): self {}

        /**
         * Asserts that the value is of type callable.
         *
         * @return self<TValue>
         */
        public function toBeCallable(string $message = ''): self {}

        /**
         * Asserts that the value is of type float.
         *
         * @return self<TValue>
         */
        public function toBeFloat(string $message = ''): self {}

        /**
         * Asserts that the value is of type int.
         *
         * @return self<TValue>
         */
        public function toBeInt(string $message = ''): self {}

        /**
         * Asserts that the value is of type iterable.
         *
         * @return self<TValue>
         */
        public function toBeIterable(string $message = ''): self {}

        /**
         * Asserts that the value is of type numeric.
         *
         * @return self<TValue>
         */
        public function toBeNumeric(string $message = ''): self {}

        /**
         * Asserts that the value contains only digits.
         *
         * @return self<TValue>
         */
        public function toBeDigits(string $message = ''): self {}

        /**
         * Asserts that the value is of type object.
         *
         * @return self<TValue>
         */
        public function toBeObject(string $message = ''): self {}

        /**
         * Asserts that the value is of type resource.
         *
         * @return self<TValue>
         */
        public function toBeResource(string $message = ''): self {}

        /**
         * Asserts that the value is of type scalar.
         *
         * @return self<TValue>
         */
        public function toBeScalar(string $message = ''): self {}

        /**
         * Asserts that the value is of type string.
         *
         * @return self<TValue>
         */
        public function toBeString(string $message = ''): self {}

        /**
         * Asserts that the value is a JSON string.
         *
         * @return self<TValue>
         */
        public function toBeJson(string $message = ''): self {}

        /**
         * Asserts that the value is NAN.
         *
         * @return self<TValue>
         */
        public function toBeNan(string $message = ''): self {}

        /**
         * Asserts that the value is null.
         *
         * @return self<TValue>
         */
        public function toBeNull(string $message = ''): self {}

        /**
         * Asserts that the value array has the provided $key.
         *
         * @return self<TValue>
         */
        public function toHaveKey(string|int $key, mixed $value = new \Pest\Matchers\Any, string $message = ''): self {}

        /**
         * Asserts that the value array has the provided $keys.
         *
         * @param  array<int, int|string|array<array-key, mixed>>  $keys
         * @return self<TValue>
         */
        public function toHaveKeys(array $keys, string $message = ''): self {}

        /**
         * Asserts that the value is a directory.
         *
         * @return self<TValue>
         */
        public function toBeDirectory(string $message = ''): self {}

        /**
         * Asserts that the value is a directory and is readable.
         *
         * @return self<TValue>
         */
        public function toBeReadableDirectory(string $message = ''): self {}

        /**
         * Asserts that the value is a directory and is writable.
         *
         * @return self<TValue>
         */
        public function toBeWritableDirectory(string $message = ''): self {}

        /**
         * Asserts that the value is a file.
         *
         * @return self<TValue>
         */
        public function toBeFile(string $message = ''): self {}

        /**
         * Asserts that the value is a file and is readable.
         *
         * @return self<TValue>
         */
        public function toBeReadableFile(string $message = ''): self {}

        /**
         * Asserts that the value is a file and is writable.
         *
         * @return self<TValue>
         */
        public function toBeWritableFile(string $message = ''): self {}

        /**
         * Asserts that the value array matches the given array subset.
         *
         * @param  iterable<int|string, mixed>  $array
         * @return self<TValue>
         */
        public function toMatchArray(iterable $array, string $message = ''): self {}

        /**
         * Asserts that the value object matches a subset
         * of the properties of an given object.
         *
         * @param  iterable<string, mixed>  $object
         * @return self<TValue>
         */
        public function toMatchObject(object|iterable $object, string $message = ''): self {}

        /**
         * Asserts that the value "stringable" matches the given snapshot..
         *
         * @return self<TValue>
         */
        public function toMatchSnapshot(string $message = ''): self {}

        /**
         * Asserts that the value matches a regular expression.
         *
         * @return self<TValue>
         */
        public function toMatch(string $expression, string $message = ''): self {}

        /**
         * Asserts that the value matches a constraint.
         *
         * @return self<TValue>
         */
        public function toMatchConstraint(\PHPUnit\Framework\Constraint\Constraint $constraint, string $message = ''): self {}

        /**
         * @param  class-string  $class
         * @return self<TValue>
         */
        public function toContainOnlyInstancesOf(string $class, string $message = ''): self {}

        /**
         * Asserts that executing value throws an exception.
         *
         * @param  (\Closure(\Throwable): mixed)|string  $exception
         * @return self<TValue>
         */
        public function toThrow(callable|string|\Throwable $exception, ?string $exceptionMessage = null, string $message = ''): self {}

        /**
         * Asserts that the value is uppercase.
         *
         * @return self<TValue>
         */
        public function toBeUppercase(string $message = ''): self {}

        /**
         * Asserts that the value is lowercase.
         *
         * @return self<TValue>
         */
        public function toBeLowercase(string $message = ''): self {}

        /**
         * Asserts that the value is alphanumeric.
         *
         * @return self<TValue>
         */
        public function toBeAlphaNumeric(string $message = ''): self {}

        /**
         * Asserts that the value is alpha.
         *
         * @return self<TValue>
         */
        public function toBeAlpha(string $message = ''): self {}

        /**
         * Asserts that the value is snake_case.
         *
         * @return self<TValue>
         */
        public function toBeSnakeCase(string $message = ''): self {}

        /**
         * Asserts that the value is kebab-case.
         *
         * @return self<TValue>
         */
        public function toBeKebabCase(string $message = ''): self {}

        /**
         * Asserts that the value is camelCase.
         *
         * @return self<TValue>
         */
        public function toBeCamelCase(string $message = ''): self {}

        /**
         * Asserts that the value is StudlyCase.
         *
         * @return self<TValue>
         */
        public function toBeStudlyCase(string $message = ''): self {}

        /**
         * Asserts that the value is UUID.
         *
         * @return self<TValue>
         */
        public function toBeUuid(string $message = ''): self {}

        /**
         * Asserts that the value is between 2 specified values
         *
         * @return self<TValue>
         */
        public function toBeBetween(int|float|\DateTimeInterface $lowestValue, int|float|\DateTimeInterface $highestValue, string $message = ''): self {}

        /**
         * Asserts that the value is a url
         *
         * @return self<TValue>
         */
        public function toBeUrl(string $message = ''): self {}

        /**
         * Asserts that the value can be converted to a slug
         *
         * @return self<TValue>
         */
        public function toBeSlug(string $message = ''): self {}
    }

}
