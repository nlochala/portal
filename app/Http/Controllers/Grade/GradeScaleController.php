<?php

namespace App\Http\Controllers;

use App\GradeScale;
use App\GradeScaleStandard;
use App\Helpers\DatabaseHelpers;
use App\Helpers\Helpers;
use App\Helpers\ViewHelpers;
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
        $type_radio = GradeScale::$typeRadio;
        return view('grade_scale.scale_index', compact('type_radio'));
    }

    /**
     * Create a new grade scale.
     *
     * @return RedirectResponse
     */
    public function store()
    {
        $values = DatabaseHelpers::dbAddAudit(request()->all());
        $values = GradeScale::setScaleType($values);

        $grade_scale = GradeScale::create($values);
       ViewHelpers::flash($grade_scale, 'grade scale', 'created');

        if (! $grade_scale) {
            return redirect()->to('grade_scale/index');
        }

        return redirect()->to("grade_scale/$grade_scale->uuid");
    }

    /**
     * Update the given model.
     *
     * @param GradeScale $grade_scale
     * @return RedirectResponse
     */
    public function update(GradeScale $grade_scale)
    {
        $values = request()->all();
        $grade_scale = DatabaseHelpers::dbAddAudit($grade_scale);

       ViewHelpers::flash($grade_scale->update($values), 'grade scale', 'updated');
        return redirect()->to('grade_scale/'.$grade_scale->uuid);
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

    /**
     * Delete the given model.
     *
     * @param GradeScale $grade_scale
     * @return RedirectResponse
     */
    public function delete(GradeScale $grade_scale)
    {
        if ($grade_scale->is_protected) {
            ViewHelpers::flashAlert(
                'danger',
                'Can not delete the grade scale. It is protected.',
                'fa fa-info-circle mr-1');
            return redirect()->back();
        }

        $grade_scale = DatabaseHelpers::dbAddAudit($grade_scale);
       ViewHelpers::flash($grade_scale->delete(), 'grade scale', 'deleted');

        return redirect()->back();
    }
}
