<?php

namespace {

    /**
     * Runs the given closure after each test in the current file.
     *
     * @param-closure-this \AceOfAces\LaravelImageTransformUrl\Tests\TestCase  $closure
     */
    function afterEach(?Closure $closure = null): \Pest\PendingCalls\AfterEachCall {}

    /**
     * Runs the given closure before each test in the current file.
     *
     * @param-closure-this \AceOfAces\LaravelImageTransformUrl\Tests\TestCase  $closure
     */
    function beforeEach(?Closure $closure = null): \Pest\PendingCalls\BeforeEachCall {}

    /**
     * Adds the given closure as a test. The first argument
     * is the test description; the second argument is
     * a closure that contains the test expectations.
     *
     * @param-closure-this \AceOfAces\LaravelImageTransformUrl\Tests\TestCase  $closure
     *
     * @return ($description is string ? TestCall : HigherOrderTapProxy|TestCall)
     */
    function test(?string $description = null, ?Closure $closure = null): \Pest\Support\HigherOrderTapProxy|\Pest\PendingCalls\TestCall {}

    /**
     * Adds the given closure as a test. The first argument
     * is the test description; the second argument is
     * a closure that contains the test expectations.
     *
     * @param-closure-this \AceOfAces\LaravelImageTransformUrl\Tests\TestCase  $closure
     */
    function it(string $description, ?Closure $closure = null): \Pest\PendingCalls\TestCall {}

}

namespace Pest {

    class Expectation {
        public function toBeImage(array $options = []): self {}
    }

}

namespace Pest\Expectations {

    class OppositeExpectation {
        public function toBeImage(array $options = []): self {}
    }

}
