<?php

namespace TypiCMS\Modules\Shop\Http\Controllers;

use Illuminate\Support\Facades\Request;
use TypiCMS\Modules\Core\Shells\Http\Controllers\BaseAdminController;

class AdminController extends BaseAdminController
{
    public function __construct()
    {
        $this->middleware('admin');
        $this->repository = app('TypiCMS\Modules\Settings\Shells\Repositories\SettingInterface');
    }

    /**
     * List preferences.
     *
     * @return \Illuminate\View\View
     */
    public function preferences()
    {
        $preferences = $this->repository->all();

        return view('shop::admin.preferences')
            ->with(compact('preferences'));
    }

    /**
     * List preferences.
     *
     * @return \Illuminate\View\View
     */
    public function storePreferences()
    {
        $data = Request::all();

        $this->repository->store($data);

        return redirect()->route('admin::preferences-shop');
    }

}
