<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Competition;
use App\Models\Group;

class CompetitionController extends Controller
{
    // List Competitions
    public function index()
    {
        $competitions = Competition::all();
        // add operation column to each row
        foreach ($competitions as $key => $value) {
            $value->operation = '<button type="button" class="btn btn-primary btn-sm edit-btn" data-toggle="modal" data-target="#competition_modal" data-action="edit" data-id="'.$value->id.'"><i class="fas fa-edit"></i></button>';
        }
        return response ()->json ([ 'data' => $competitions ]);
    }

    // Get a Single Competition
    public function show($id)
    {
        $competition = Competition::getElementById($id);
        $groups = Group::getGroupByCid($id);
        return response ()->json ([
            'data' => $competition,
            'groups' => $groups
        ]);

    }

    // Create a New Competition
    public function store(Request $request)
    {
        return response ()->json ([
            'data' => Competition::create($request->all())
        ]);
    }

    // Update a Competition
    public function update(Request $request, $id)
    {
        $competition = Competition::findOrFail($id);
        $competition->update($request->all());
        return $competition;
    }

    // Delete a Competition
    public function destroy($id)
    {
        $competition = Competition::findOrFail($id);
        $competition->delete();
        return 204; // No content
    }
}
