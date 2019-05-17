<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 5/17/2019
 * Time: 11:06 AM
 */

class Expense
{
    private $_name;
    private $_type;
    private $_amount;

    /**
     * Expense constructor.
     * @param $_name
     * @param $_type
     * @param $_amount
     */
    public function __construct($_name, $_type, $_amount)
    {
        $this->_name = $_name;
        $this->_type = $_type;
        $this->_amount = $_amount;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->_name = $name;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->_type = $type;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->_amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->_amount = $amount;
    }

    public function expenseCalc(){

    }
}