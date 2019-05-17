<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 5/17/2019
 * Time: 11:05 AM
 */

class Pay
{
    private $_pay;
    private $_tax;

    /**
     * Pay constructor.
     * @param $_pay
     * @param $_tax
     */
    public function __construct($_pay, $_tax)
    {
        $this->_pay = $_pay;
        $this->_tax = $_tax;
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
     * @return mixed
     */
    public function getTax()
    {
        return $this->_tax;
    }

    /**
     * @param mixed $tax
     */
    public function setTax($tax)
    {
        $this->_tax = $tax;
    }


}