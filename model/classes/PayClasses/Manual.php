<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 5/17/2019
 * Time: 11:06 AM
 */

class Manual extends Pay
{

    /**
     * Manual constructor.
     */
    public function __construct($_pay)
    {
        parent::__construct($_pay, 0);
    }
}