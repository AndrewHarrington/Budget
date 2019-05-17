<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 5/17/2019
 * Time: 11:05 AM
 */

class Salary extends Pay
{
    public function __construct($_pay, $_tax)
    {
        parent::__construct($_pay, $_tax);
    }
}