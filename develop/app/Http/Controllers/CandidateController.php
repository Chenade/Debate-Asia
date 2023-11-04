<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Round;
use App\Models\Users;


class CandidateController extends Controller
{
    public function showByUid(Request $request)
    {
        $token = $request->header('token');
        $user_id = USERS::getId($token);
        $ret = array();
        $rounds = Round::where('user_id', $user_id) 
                    -> where('round_number', '>', 0)
                    -> leftJoin('sessions', 'rounds.session_id', '=', 'sessions.id')
                    -> leftJoin('groups', 'sessions.group_id', '=', 'groups.id')
                    -> leftJoin('competitions', 'groups.competition_id', '=', 'competitions.id')
                    -> select('rounds.*', 
                                    'sessions.group_id', 'sessions.session_name', 'sessions.pos_title', 'sessions.neg_title', 'sessions.date',
                                    'groups.group_name', 'groups.competition_id', 
                                    'competitions.competition_name')
                    -> get();

        foreach ($rounds as $round)
        {
            if ($round->status == 0)
            {
                unset($round->pos_title);
                unset($round->neg_title);
                unset($round->role);
                unset($round->round_number);
                unset($round->created_at);
                unset($round->updated_at);
            }
        }
        $username = Users::where('id', $user_id)->value('account');
        $token = Users::genToken($username);
        return response()->json(['success' => true, 'data' => $rounds, 'token' => $token], 200);
    }

    
}
