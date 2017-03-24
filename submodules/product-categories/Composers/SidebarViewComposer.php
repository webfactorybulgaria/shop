<?php

namespace TypiCMS\Modules\ProductCategories\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;

class SidebarViewComposer
{
    public function compose(View $view)
    {
        $view->sidebar->group(trans('global.menus.shop'), function (SidebarGroup $group) {
            $group->addItem(trans('product-categories::global.name'), function (SidebarItem $item) {
                $item->icon = config('typicms.product-categories.sidebar.icon');
                $item->weight = config('typicms.product-categories.sidebar.weight');
                $item->route('admin::index-product-categories');
                $item->append('admin::create-product-category');
                $item->authorize(
                    Gate::allows('index-product-categories')
                );
            });
        });
    }
}
