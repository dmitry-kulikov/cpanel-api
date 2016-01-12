<?php

namespace kdn\cpanel\api\mocks;

use kdn\cpanel\api\Object;

/**
 * Class ObjectMock.
 * @package kdn\cpanel\api\mocks
 */
class ObjectMock extends Object
{
    protected $protectedProperty;

    public function getProtectedProperty()
    {
        return $this->protectedProperty;
    }
}
