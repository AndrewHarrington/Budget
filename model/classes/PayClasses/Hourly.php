<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 5/17/2019
 * Time: 11:05 AM
 */

class Hourly extends Pay
{
    private $_hours;
    private $_rate;

    /**
     * Hourly constructor.
     * @param $_hours
     * @param $_rate
     * @param $_tax
     */
    public function __construct($_hours, $_rate, $_tax)
    {
        $this->_hours = $_hours;
        $this->_rate = $_rate;
        parent::__construct($this->calcPay(), $_tax);
    }

    /**
     * @return mixed
     */
    public function getHours()
    {
        return $this->_hours;
    }

    /**
     * @param mixed $hours
     */
    public function setHours($hours)
    {
        $this->_hours = $hours;
    }

    /**
     * @return mixed
     */
    public function getRate()
    {
        return $this->_rate;
    }

    /**
     * @param mixed $rate
     */
    public function setRate($rate)
    {
        $this->_rate = $rate;
    }

    private function calcPay(){
        return ($this->_hours * $this->_rate);
    }
}