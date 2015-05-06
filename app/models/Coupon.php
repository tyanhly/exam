<?php

class Coupon extends Eloquent
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tbl_coupon';

    protected $fillable = [
        'code',
        'name',
        'start_date',
        'expired_date',
        'status'
    ];

    public function couponType () {
        return $this->belongsTo('CouponType');
    }

}

