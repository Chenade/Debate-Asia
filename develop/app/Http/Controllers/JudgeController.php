<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Round;
use App\Models\Judges;
use App\Models\Users;
use App\Models\Articles;
use App\Models\Sessions;
use App\Models\Group;

use Log;

class JudgeController extends Controller
{
    public function getInfo(Request $request)
    {
        $token = $request->header('token');
        $token = USERS::validToken($token);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        $user_id = USERS::getId($token);
        $authority = USERS::find($user_id)->authority;
        if ($authority != 2)
            return response()->json(['success' => false, 'message' => 'No authority.'], 403);
        $users = USERS::find($user_id);

        return response()->json(['success' => true, 'data' => $users, 'id' => $user_id], 200);
    }

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
            // if ( $round->status < 2 )
            {
                $nestedRounds[$competitionId]['groups'][$groupId]['sessions'][$sessionId]['rounds'][$round->round_number] = 
                [
                    'pos_title' => $round->pos_title,
                    'neg_title' => $round->neg_title,
                    'status' => $round->status,
                ];
            }
        }
                    
        return response()->json(['success' => true, 'data' => $nestedRounds ], 200);
    }

    public function judgeSession(Request $request, $sid, $rid)
    {
        $token = $request->header('token');
        $token = USERS::validToken($token);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        $user_id = USERS::getId($token);
        $authority = USERS::find($user_id)->authority;
        if ($authority != 2)
            return response()->json(['success' => false, 'message' => 'No authority.'], 403);
        $data = Round::where ('session_id', intval($sid))
                    -> where ('round_number', intval($rid))
                    -> where ('role', '!=', 3)
                    -> get();

        foreach ($data as $key => $value) {
            $data[$key]['article'] = Articles::where('round_id', $value['id'])->get();
            $data[$key]['judge'] = Judges::where('round_id', $value['id']) -> where('user_id', $user_id) -> first();
        }

        $session = Sessions::where('id', intval($sid))->first();
        if ($session == null)
            return response()->json(['success' => false, 'message' => 'No session.'], 403);
        else
        {
            $info = Group::where('id', $session->group_id)->first();
            $info['session_name'] = $session->session_name;
            $info['pos_title'] = $session->pos_title;
            $info['neg_title'] = $session->neg_title;
        }

        return response()->json(['success' => true, 'data' => $data, 'info' => $info], 200);
    }

    public function judgeSubmit(Request $request, $rid)
    {
        $token = $request->header('token');
        $token = USERS::validToken($token);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        $user_id = USERS::getId($token);
        $authority = USERS::find($user_id)->authority;
        if ($authority != 2)
            return response()->json(['success' => false, 'message' => 'No authority from token.'], 403);

        // round id
        $round = Round::find($rid);
        if ($round == null)
            return response()->json(['success' => false, 'message' => 'No round.'], 404);

        $judge_rounds = Round::where('session_id', $round->session_id)
                                -> where('round_number', $round->round_number)
                                -> where('user_id', $user_id)
                                -> where('role', 3)
                                -> first();
        if ($judge_rounds == null)
            return response()->json(['success' => false, 'message' => 'No authority.'], 403);
        
        $data = Judges::where ('round_id', intval($rid))
                    -> where ('user_id', $user_id)
                    -> first();

        if ($data == null)
        {
            $data = new Judges;
            $data->round_id = $rid;
            $data->user_id = $user_id;
        }
        $data->comment = $request->comment;
        $data->score_1 = $request->score_1;
        $data->score_2 = $request->score_2;
        $data->score_3 = $request->score_3;
        $data->score_4 = $request->score_4;
        $data->save();

        $round->status = 6;
        $round->save();

        $theOther = Round::where('session_id', $round->session_id)
                            -> where('round_number', $round->round_number)
                            -> where('role', '!=', 3)
                            -> where ('id', '!=', intval($rid))
                            -> first();

        $status = 1;
        if ($theOther != null)
        {
            $record = Judges::where ('round_id', $theOther->id)
                        -> where ('user_id', $user_id)
                        -> first();
            if ($record != null)
                $status = 2;
        }
        $judge_rounds->status = $status;
        $judge_rounds->save();

        return response()->json(['success' => true, 'data' => $data], 200);
    }

    public function getFeedbackList(Request $request, $posId, $negId)
    {
        $token = $request->header('token');
        $token = USERS::validToken($token);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        $user_id = USERS::getId($token);
        $authority = USERS::find($user_id)->authority;
        if ($authority != 7)
            return response()->json(['success' => false, 'message' => 'No authority.'], 403);
        $ret = array();

        $data = Judges::whereIn('round_id', [intval($posId), intval($negId)])
                        -> leftJoin('rounds', 'judge.round_id', '=', 'rounds.id')
                        -> leftJoin('users', 'judge.user_id', '=', 'users.id')
                        -> select('judge.*', 'rounds.role', 'users.name_cn', 'users.name_en')
                        -> get();
        
        foreach ($data as $key => $value) {
            if (!isset($ret[$value['user_id']]))
                $ret[$value['user_id']] = array();
            array_push($ret[$value['user_id']], $value);
        }
        return response()->json(['success' => true, 'data' => $ret], 200);
    }

}
