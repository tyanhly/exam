<?php

class CartException extends \Exception
{

    const MODEL_CART_ITEM_NOT_EXISTED                   = 0x001;
    const MODEL_CART_ITEM_QUANTITY_NOT_ENOUGH           = 0x002;
    const MODEL_CART_ITEM_PROPERTIES_CANT_NOT_TOARRAY   = 0x003;

    const ORDER_CART_DONT_HAVE_ITEM                     = 0x101;
    
    const AUTH_HAD_NOT_AUTHEN                           = 0x201;
    
    const APP_DONT_KNOW_ERROR                           = 0x901;

    public static $msgs = array(
        self::MODEL_CART_ITEM_NOT_EXISTED                   => 'MODEL_CART_ITEM_NOT_EXISTED',
        self::MODEL_CART_ITEM_QUANTITY_NOT_ENOUGH           => 'The number of this product is not enough to sell',
        self::MODEL_CART_ITEM_PROPERTIES_CANT_NOT_TOARRAY   => 'MODEL_CART_ITEM_PROPERTIES_CANT_NOT_TOARRAY',
        self::ORDER_CART_DONT_HAVE_ITEM                     => 'ORDER_CART_DONT_HAVE_ITEM',
        self::AUTH_HAD_NOT_AUTHEN                           => 'AUTH_HAD_NOT_AUTHEN',
        self::APP_DONT_KNOW_ERROR                           => 'APP_DONT_KNOW_ERROR',
    );

    public static function getMsg($code)
    {
        if (array_key_exists($code, self::$msgs)) {
            return self::$msgs[$code];
        } else {
            return self::$msgs[self::APP_DONT_KNOW_ERROR];
        }
    }
    
    public function CartException($code){
        parent::__construct(CartException::getMsg($code), $code);
    }
}