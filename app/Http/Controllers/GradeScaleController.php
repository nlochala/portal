<?php

namespace App\Http\Controllers;

use App\GradeScale;
use App\GradeScaleStandard;
use App\Helpers\Helpers;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;

class GradeScaleController extends Controller
{
    /**
     * Require users to have been authenticated before reaching this page.
     *
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the grade scales.
     *
     * @return Factory|View
     */
    public function index()
    {
        $grade_scales = Helpers::parseCsv('database/seeds/data/grade_scales.csv', false);
        // Can not delete a pre-populated grade_scale.
        $protected_uuids = GradeScale::where('id', '<=', count($grade_scales))->pluck('uuid')->toArray();

        return view('grade_scale.scale_index', compact('protected_uuids'));
    }

    /**
     * Create a new grade scale.
     *
     * @return RedirectResponse
     */
    public function create()
    {
        $values = Helpers::dbAddAudit(request()->all());
        $grade_scale = GradeScale::create($values);

        return redirect()->to("grade_scale/$grade_scale->uuid/show");
    }

    /**
     * Display a grade scale.
     *
     * @param GradeScale $grade_scale
     * @return Factory|View
     */
    public function show(GradeScale $grade_scale)
    {
        // ->load('items') won't work because we can't access the attributes of the model
        // to determine which table to get the items from.
        $grade_scale->items();
        $equivalent_standards = GradeScaleStandard::getEquivalentStandardsDropdown();

        return view('grade_scale.show_'.$grade_scale->getScaleType(), compact('grade_scale', 'equivalent_standards'));
    }
}
