<?php


class CouponType extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tbl_coupon_type';
	protected $fillable = ['discount', 'name',];
	public function coupon()
	{
	    return $this->hasMany('Coupon', 'coupon_type_id');
	}
	
}

