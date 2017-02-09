<?php

namespace TypiCMS\Modules\Coupons\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;

class SidebarViewComposer
{
    public function compose(View $view)
    {
        $view->sidebar->group(trans('global.menus.shop'), function (SidebarGroup $group) {
            $group->addItem(trans('coupons::global.name'), function (SidebarItem $item) {
                $item->id = 'coupons';
                $item->icon = config('typicms.coupons.sidebar.icon');
                $item->weight = config('typicms.coupons.sidebar.weight');
                $item->route('admin::index-coupons');
                $item->append('admin::create-coupon');
                $item->authorize(
                    Gate::allows('index-coupons')
                );
            });
        });
    }
}
