<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Round;
use App\Models\Judge;
use App\Models\Users;

class JudgeController extends Controller
{
    // showByUid
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
                                    'sessions.group_id', 'sessions.session_name', 'sessions.pos_title', 'sessions.neg_title',
                                    'groups.group_name', 'groups.competition_id', 
                                    'competitions.competition_name')
                    -> get();

        $nestedRounds = [];

        foreach ($rounds as $round) {
            $competitionId = $round->competition_id;
            $competitionName = $round->competition_name;
            $groupId = $round->group_id;
            $groupName = $round->group_name;
            $sessionId = $round->session_id;
            $sessionName = $round->session_name;
        
            $nestedRounds[$competitionId]['competition_name'] = $competitionName;
            $nestedRounds[$competitionId]['groups'][$groupId]['group_name'] = $groupName;
            $nestedRounds[$competitionId]['groups'][$groupId]['sessions'][$sessionId]['session_name'] = $sessionName;
            $nestedRounds[$competitionId]['groups'][$groupId]['sessions'][$sessionId]['rounds'][$round->round_number] = 
            [
                'pos_title' => $round->pos_title,
                'neg_title' => $round->neg_title,
                'status' => $round->status,
            ];
        }
                    
        return response()->json(['success' => true, 'data' => $nestedRounds ], 200);
    }
}
