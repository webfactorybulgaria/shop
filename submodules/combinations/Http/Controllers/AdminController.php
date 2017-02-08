<?php

namespace TypiCMS\Modules\Combinations\Http\Controllers;

use TypiCMS\Modules\Core\Shells\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Combinations\Shells\Http\Requests\FormRequest;
use TypiCMS\Modules\Combinations\Shells\Models\Combination;
use TypiCMS\Modules\Combinations\Shells\Repositories\CombinationInterface;

class AdminController extends BaseAdminController
{
    public function __construct(CombinationInterface $combination)
    {
        parent::__construct($combination);
    }

    /**
     * List models.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $models = $this->repository->all([], true);
        app('JavaScript')->put('models', $models);

        return view('combinations::admin.index');
    }

    /**
     * Create form for a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $model = $this->repository->getModel();

        return view('combinations::admin.create')
            ->with(compact('model'));
    }

    /**
     * Edit form for the specified resource.
     *
     * @param \TypiCMS\Modules\Combinations\Shells\Models\Combination $combination
     *
     * @return \Illuminate\View\View
     */
    public function edit(Combination $combination)
    {
        return view('combinations::admin.edit')
            ->with(['model' => $combination]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \TypiCMS\Modules\Combinations\Shells\Http\Requests\FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FormRequest $request)
    {
        $combination = $this->repository->create($request->all());

        return $this->redirect($request, $combination);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \TypiCMS\Modules\Combinations\Shells\Models\Combination            $combination
     * @param \TypiCMS\Modules\Combinations\Shells\Http\Requests\FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Combination $combination, FormRequest $request)
    {
        $this->repository->update($request->all());

        return $this->redirect($request, $combination);
    }
}
