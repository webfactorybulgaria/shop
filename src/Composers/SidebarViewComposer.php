<?php

namespace TypiCMS\Modules\Shop\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;

class SidebarViewComposer
{
    public function compose(View $view)
    {
        $view->sidebar->group(trans('global.menus.shop'), function (SidebarGroup $group) {
            $group->id = 'shop';
            $group->addItem(trans('shop::global.preferences'), function (SidebarItem $item) {
                $item->id = 'preferences';
                $item->icon = config('typicms.shop.sidebar.icon');
                $item->weight = config('typicms.shop.sidebar.weight');
                $item->route('admin::preferences-shop');
                $item->authorize(
                    Gate::allows('preferences-shop')
                );
            });
        });
    }
}
