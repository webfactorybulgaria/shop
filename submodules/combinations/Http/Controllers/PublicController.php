<?php

namespace TypiCMS\Modules\Combinations\Http\Controllers;

use TypiCMS\Modules\Core\Shells\Http\Controllers\BasePublicController;
use TypiCMS\Modules\Combinations\Shells\Repositories\CombinationInterface;

class PublicController extends BasePublicController
{
    public function __construct(CombinationInterface $combination)
    {
        parent::__construct($combination);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $models = $this->repository->all();

        return view('combinations::public.index')
            ->with(compact('models'));
    }

    /**
     * Show news.
     *
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        $model = $this->repository->bySlug($slug);

        return view('combinations::public.show')
            ->with(compact('model'));
    }
}
