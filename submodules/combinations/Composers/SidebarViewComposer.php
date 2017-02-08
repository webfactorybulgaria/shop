<?php

namespace TypiCMS\Modules\Combinations\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;

class SidebarViewComposer
{
    public function compose(View $view)
    {
        // $view->sidebar->group(trans('global.menus.shop'), function (SidebarGroup $group) {
        //     $group->addItem(trans('combinations::global.name'), function (SidebarItem $item) {
        //         $item->icon = config('typicms.combinations.sidebar.icon');
        //         $item->weight = config('typicms.combinations.sidebar.weight');
        //         $item->route('admin::index-combinations');
        //         $item->append('admin::create-combination');
        //         $item->authorize(
        //             Gate::allows('index-combinations')
        //         );
        //     });
        // });
    }
}
