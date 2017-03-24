<?php

return [
    'name'     => 'Coupons',
    'coupons'  => 'coupon|coupons',
    'New'      => 'New coupon',
    'Edit'     => 'Edit coupon',
    'Back'     => 'Back to coupons',

    'attributes' => [
    	'code'                 =>  'Code',
        'sku'                  =>  'SKU',
        'value'                =>  'Fixed Value Discount',
        'discount'             =>  'Percentage Discount (Fixed Value Overrides Percent)',
        'name'                 =>  'Coupon Code Name',
        'description'          =>  'Coupon Code Description',
        'starts_at'            =>  'Start Date',
        'expires_at'           =>  'End Date',
        'total_available'      =>  'Total available',
        'total_available_user' =>  'Total available per user'
    ]
];
