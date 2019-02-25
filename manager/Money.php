<?php namespace manager;

use manager\exception\InvalidCurrencyException;

class Money {
    /**
     * @var int
     */
    protected $fractional;
    /**
     * @var Currency
     */
    protected $currency;
    
    /**
     * Money constructor.
     * @param $fractional
     * @param Currency $currency
     */
    public function __construct($fractional, Currency $currency) {
        $this->fractional = $fractional;
        $this->currency   = $currency;
    }
    
    /**
     * @param $value
     * @param $currency
     * @return Money
     * @throws InvalidCurrencyException
     */
    public static function init($value, $currency) {
        return new Money($value, new Currency($currency));
    }
    
    /**
     * @return int
     */
    public function getCentsParameter() {
        return $this->fractional;
    }
    
    /**
     * @return Currency
     */
    public function getCurrencyParameter() {
        return $this->currency;
    }
    
    /**
     * /**
     * @param Money $money
     * @return bool
     */
    public function isSameCurrency(Money $money) {
        return $this->currency->getIsoCode() == $money->currency->getIsoCode();
    }
    
    /**
     * @param Money $money
     * @return bool
     */
    public function equals(Money $money) {
        return $this->isSameCurrency($money) && $this->cents == $money->cents;
    }
    
    /**
     * @param Money $money
     * @return Money
     * @throws InvalidCurrencyException
     */
    public function add(Money $money) {
        if ($this->isSameCurrency($money)) {
            return Money::init($this->cents + $money->cents, $this->currency->getIsoCode());
        }
        throw new InvalidCurrencyException("You can't add two Money objects with different currencies");
    }
    
    /**
     * @param Money $money
     * @return Money
     * @throws InvalidCurrencyException
     */
    public function subtract(Money $money) {
        if ($this->isSameCurrency($money)) {
            return Money::init($this->cents - $money->cents, $this->currency->getIsoCode());
        }
        throw new InvalidCurrencyException("You can't subtract two Money objects with different currencies");
    }
    
    /**
     * @param $number
     * @return Money
     * @throws InvalidCurrencyException
     */
    public function multiply($number) {
        return Money::init((int)round($this->cents * $number, 0, PHP_ROUND_HALF_EVEN), $this->currency->getIsoCode());
    }
    
    /**
     * @param $number
     * @return Money
     * @throws InvalidCurrencyException
     */
    public function divide($number) {
        return Money::init((int)round($this->cents / $number, 0, PHP_ROUND_HALF_EVEN), $this->currency->getIsoCode());
    }
    
    /**
     * @param $param
     * @return mixed
     */
    public function __get($param) {
        $method = 'get' . ucfirst($param) . 'Parameter';
        if (method_exists($this, $method))
            return $this->{$method}();
    }
}