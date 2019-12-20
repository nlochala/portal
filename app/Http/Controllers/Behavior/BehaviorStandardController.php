<?php

namespace App\Http\Controllers;

use App\BehaviorStandard;
use App\Helpers\DatabaseHelpers;
use App\Helpers\ViewHelpers;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BehaviorStandardController extends Controller
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
     * Return the index of standards.
     *
     * @return Factory|View
     */
    public function index()
    {
        return view('behavior.standard');
    }

    /**
     * Show the standard dashboard.
     *
     * @param BehaviorStandard $standard
     * @return Factory|View
     */
    public function showStandard(BehaviorStandard $standard)
    {
        return view('behavior.standard_dashboard', compact('standard'));
    }

    /**
     * Update the standard.
     *
     * @param BehaviorStandard $standard
     * @return Factory|View
     */
    public function update(BehaviorStandard $standard)
    {
        $values = DatabaseHelpers::dbAddAudit(request()->all());
        ViewHelpers::flash($standard->update($values), 'standard', 'updated');

        return view('behavior.standard_dashboard', compact('standard'));
    }
}
