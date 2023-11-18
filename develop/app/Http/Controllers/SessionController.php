<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sessions;
use App\Models\Group;
use App\Models\Competition_log;

class SessionController extends Controller
{
    // List Sessionss
    public function index()
    {
        return Sessions::all();
    }

    // Get a Single Sessions
    public function show($id)
    {
        $data = Sessions::find($id);
        $gid = $data->group_id;
        $competition_data = Group::find($gid);
        $candidates = Competition_log::where('competition_id', $competition_data->competition_id)
            -> where('group_id', $gid)
            -> where ('approval', 1)
            -> leftjoin ('users', 'users.id', '=', 'competition_log.userId')
            -> leftjoin ('rounds', 'rounds.user_id', '=', 'competition_log.userId')
            -> selectRaw('competition_log.*, users.name_cn, users.school_cn, rounds.session_id, rounds.round_number, rounds.role, rounds.id as round_id')
            -> orderBy ('rounds.round_number', 'asc')
            -> get();
        foreach ($candidates as $key => $value) {
            $value->date = json_decode($value->date);
        }
        return response ()->json ([ 'data' => $data, 'candidates' => $candidates ]);
    }

    // Get sessions list base on group id
    public function showByGid($gid)
    {
        $data = Sessions::where('group_id', $gid)->get();
        return response ()->json ([ 'data' => $data]);
    }

    // showCandidatesByGid
    public function showCandidatesByGid($gid)
    {
        $competition_data = Groups::find($gid);
        $data = Competition_log::where('competition_id', $competition_data->cid)
            ->where('group_id', $gid)
            ->get();
        return response ()->json ([ 'data' => $data ]);
    }

    // Create a New Sessions
    public function store(Request $request)
    {
        return Sessions::create($request->all());
    }

    // Update a Sessions
    public function update(Request $request, $id)
    {
        $session = Sessions::findOrFail($id);
        $session->update($request->all());
        return $session;
    }

    // Delete a Sessions
    public function destroy($id)
    {
        $session = Sessions::findOrFail($id);
        $session->delete();
        return 204; // No content
    }


}
