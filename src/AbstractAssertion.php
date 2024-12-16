<?php

namespace esposimo\assert;

abstract class AbstractAssertion
{

    const string ASSERT_EQUALS = 'equals';

    const string ASSERT_EQUALS_CS = 'equalsCs';

    const array ASSERT_LIST = [
        self::ASSERT_EQUALS,
        self::ASSERT_EQUALS_CS,
    ];

    const array ASSERT_MAP = [
        self::ASSERT_EQUALS => Equals::class,
    ];

}