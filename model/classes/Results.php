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
    private $_total;

    /**
     * Results constructor.
     * @param $_pay
     * @param $_expenses - Array of Expense objects
     */
    public function __construct($_pay, array $_expenses)
    {
        $this->_pay = $_pay;
        $this->_expenses = $_expenses;
        $this->_total = $_pay;
    }

    /**
     * @return mixed
     */
    public function getPay()
    {
        return $this->_pay;
    }

    /**
     * @param mixed $pay
     */
    public function setPay($pay)
    {
        $this->_pay = $pay;
    }

    /**
     * @return array
     */
    public function getExpenses()
    {
        return $this->_expenses;
    }

    /**
     * @param array $expenses
     */
    public function setExpenses($expenses)
    {
        $this->_expenses = $expenses;
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->_total;
    }

    /**
     * @param $total
     * @return mixed
     */
    public function setTotal($total)
    {
        $this->_total = $total;
        return $this->_total;
    }
}