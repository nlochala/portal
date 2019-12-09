<?php

namespace App\Http\Controllers;

use App\Helpers\DatabaseHelpers;
use App\Helpers\Helpers;
use App\Helpers\ViewHelpers;
use App\Position;
use App\PositionType;
use App\School;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PositionController extends Controller
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

    public function summary()
    {
    }

    /**
     * Display a table of all positions.
     *
     * @return Factory|View
     */
    public function index()
    {
        return view('position.index');
    }

    public function archived()
    {
    }

    /**
     * View the create form.
     *
     * @return Factory|View
     */
    public function create()
    {
        $type_dropdown = PositionType::getDropdown();
        $school_dropdown = School::getDropdown();
        $position_dropdown = Position::getDropdown();

        return view('position.create', compact(
            'type_dropdown',
            'school_dropdown',
            'position_dropdown'
        ));
    }

    /**
     * Save the submitted form.
     *
     * @return RedirectResponse
     */
    public function store()
    {
        $values = DatabaseHelpers::dbAddAudit(request()->all());

        /** @noinspection PhpUndefinedMethodInspection */
        $position = Position::create($values);
       ViewHelpers::flash($position, 'position', 'created');

        if ($position) {
            return redirect()->to("position/$position->uuid");
        }

        return redirect()->back()->withInput();
    }

    /**
     * View a single position.
     *
     * @param Position $position
     *
     * @return Factory|View
     */
    public function view(Position $position)
    {
        $position->load('type', 'school', 'supervisor');

        return view('position.view', compact('position'));
    }

    /**
     * Display the update form.
     *
     * @param Position $position
     *
     * @return Factory|View
     */
    public function updateForm(Position $position)
    {
        $position->load('type', 'school', 'supervisor');
        $type_dropdown = PositionType::getDropdown();
        $school_dropdown = School::getDropdown();
        $position_dropdown = Position::getDropdown();

        return view('position.edit', compact(
            'position',
            'type_dropdown',
            'school_dropdown',
            'position_dropdown'
            ));
    }

    /**
     * Update the given position.
     *
     * @param Position $position
     *
     * @return RedirectResponse
     */
    public function update(Position $position)
    {
        $values = request()->all();
        $position = DatabaseHelpers::dbAddAudit($position);

        $position->update($values);
       ViewHelpers::flash($position, 'position', 'updated');

        if ($position) {
            return redirect()->to("position/$position->uuid");
        }

        return redirect()->back()->withInput();
    }

    /**
     * Archive the position and return to index.
     *
     * @param Position $position
     *
     * @return RedirectResponse
     */
    public function archive(Position $position)
    {
        $position = DatabaseHelpers::dbAddAudit($position);
        $position->delete();
       ViewHelpers::flash($position, 'position', 'archived');

        return redirect()->to('position/index');
    }
}
