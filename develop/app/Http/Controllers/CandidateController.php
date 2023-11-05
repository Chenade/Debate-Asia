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
        $token = USERS::validToken($token);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        $user_id = USERS::getId($token);
        $authority = USERS::find($user_id)->authority;
        if ($authority != 1)
            return response()->json(['success' => false, 'message' => 'No authority.'], 403);

        $ret = array();
        $rounds = Round::where('user_id', $user_id) 
                    -> where('round_number', '>', 0)
                    -> leftJoin('sessions', 'rounds.session_id', '=', 'sessions.id')
                    -> leftJoin('groups', 'sessions.group_id', '=', 'groups.id')
                    -> leftJoin('competitions', 'groups.competition_id', '=', 'competitions.id')
                    -> leftjoin('users', 'rounds.user_id', '=', 'users.id')
                    -> select('rounds.*', 'users.name_cn', 'users.school_cn',
                                    'sessions.group_id', 'sessions.session_name', 'sessions.pos_title', 'sessions.neg_title', 'sessions.date',
                                    'groups.group_name', 'groups.competition_id', 
                                    'competitions.competition_name')
                    -> get();

        foreach ($rounds as $round)
        {
            unset($round->created_at);
            unset($round->updated_at);
            if ($round->status == 0)
            {
                unset($round->pos_title);
                unset($round->neg_title);
                unset($round->role);
                unset($round->round_number);
            }
            if ($round->status >= 4)
            {
                $round['ops'] = Round::where('round_number', $round->round_number)
                                    -> where('session_id', $round->session_id)
                                    -> where('user_id', '!=', $user_id)
                                    -> leftjoin('users', 'rounds.user_id', '=', 'users.id')
                                    -> select('rounds.*', 'users.name_cn', 'users.school_cn')
                                    -> first();
            }

        }
        $username = Users::where('id', $user_id)->value('account');
        $token = Users::genToken($username);
        return response()->json(['success' => true, 'data' => $rounds, 'token' => $token], 200);
    }

    
}
