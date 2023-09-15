<?php
namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
    {
        // Retrieve all Groups
        $Groups = Group::all();
        return response()->json(['success' => true, 'data' => $Groups], 200);
    }

    public function show($id)
    {
        // Retrieve a specific Group by ID
        $Group = Group::find($id);
        if (!$Group) {
            return response()->json(['success' => false, 'message' => 'Group not found.'], 404);
        }
        return response()->json(['success' => true, 'data' => $Group], 200);
    }

    public function store(Request $request)
    {
        // Create a new Group
        $Group = Group::create($request->all());
        return response()->json(['success' => true, 'data' => $Group], 201);
    }

    public function update(Request $request, $id)
    {
        // Update a Group by ID
        $Group = Group::find($id);
        if (!$Group) {
            return response()->json(['success' => false, 'message' => 'Group not found.'], 404);
        }
        $Group->update($request->all());
        return response()->json(['success' => true, 'data' => $Group], 200);
    }

    public function destroy($id)
    {
        // Delete a Group by ID
        $Group = Group::find($id);
        if (!$Group) {
            return response()->json(['success' => false, 'message' => 'Group not found.'], 404);
        }
        $Group->delete();
        return response()->json(['success' => true, 'message' => 'Group deleted successfully.'], 200);
    }
}
