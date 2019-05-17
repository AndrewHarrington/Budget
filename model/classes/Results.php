<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 5/17/2019
 * Time: 11:06 AM
 */

class Results
{
    private $_pay;
    private $_expenses;

    /**
     * Results constructor.
     * @param $_pay
     * @param $_expenses
     */
    public function __construct($_pay, $_expenses)
    {
        $this->_pay = $_pay;
        $this->_expenses = $_expenses;
    }

    public function toHTML(){

    }
}