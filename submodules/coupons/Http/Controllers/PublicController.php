<?php

namespace TypiCMS\Modules\Coupons\Http\Controllers;

use TypiCMS\Modules\Core\Shells\Http\Controllers\BasePublicController;
use TypiCMS\Modules\Coupons\Shells\Repositories\CouponInterface;

class PublicController extends BasePublicController
{
    public function __construct(CouponInterface $coupon)
    {
        parent::__construct($coupon);
    }
}
