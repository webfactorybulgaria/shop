<?php

namespace TypiCMS\Modules\Orders\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;

class SidebarViewComposer
{
    public function compose(View $view)
    {
        $view->sidebar->group(trans('global.menus.shop'), function (SidebarGroup $group) {
            $group->addItem(trans('orders::global.name'), function (SidebarItem $item) {
                $item->id = 'orders';
                $item->icon = config('typicms.orders.sidebar.icon');
                $item->weight = config('typicms.orders.sidebar.weight');
                $item->route('admin::index-orders');
                $item->authorize(
                    Gate::allows('index-orders')
                );
            });
        });
    }
}
