<?php
namespace App\Http\Controllers;

use App\Models\Round;
use Illuminate\Http\Request;

class RoundController extends Controller
{
    public function index()
    {
        // Retrieve all rounds
        $rounds = Round::all();
        return response()->json(['success' => true, 'data' => $rounds], 200);
    }

    public function show($id)
    {
        // Retrieve a specific round by ID
        $round = Round::find($id);
        if (!$round) {
            return response()->json(['success' => false, 'message' => 'Round not found.'], 404);
        }
        return response()->json(['success' => true, 'data' => $round], 200);
    }

    public function store(Request $request)
    {
        // Create a new round
        $round = Round::create($request->all());
        return response()->json(['success' => true, 'data' => $round], 201);
    }

    public function update(Request $request, $id)
    {
        // Update a round by ID
        $round = Round::find($id);
        if (!$round) {
            return response()->json(['success' => false, 'message' => 'Round not found.'], 404);
        }
        $round->update($request->all());
        return response()->json(['success' => true, 'data' => $round], 200);
    }

    public function destroy($id)
    {
        // Delete a round by ID
        $round = Round::find($id);
        if (!$round) {
            return response()->json(['success' => false, 'message' => 'Round not found.'], 404);
        }
        $round->delete();
        return response()->json(['success' => true, 'message' => 'Round deleted successfully.'], 200);
    }

    // shuffle by session id
    public function shuffle(Request $request, $session_id)
    {
        $i = 1;
        $data = Round::where('session_id', $session_id) ->inRandomOrder() ->get();
        foreach ($data as $key => $value) {
            $value->update(['round_number' => $i / 2]);
            $i++;
        }
        
        return response()->json(['success' => true, 'data' => $data], 200);
    }

    // end all round by session id
    public function endAllRound(Request $request, $session_id)
    {
        $data = Round::where('session_id', $session_id) ->get();
        foreach ($data as $key => $value) {
            $value->update(['status' => 4]);
        }
        
        return response()->json(['success' => true, 'data' => $data], 200);
    }
}
