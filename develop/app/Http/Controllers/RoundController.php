<?php
namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\Round;
use App\Models\Sessions;
use App\Models\Articles;
use App\Models\Judges;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class RoundController extends Controller
{
    public function index()
    {
        // Retrieve all rounds
        $rounds = Round::all();
        return response()->json(['success' => true, 'data' => $rounds], 200);
    }

    public function show(Request $request, $id)
    {
        $token = $request->header('token');
        $token = USERS::validToken($token);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        $user_id = USERS::getId($token);

        $round = Round::find($id);
        if (!$round || $round->user_id != $user_id) {
            return response()->json(['success' => false, 'message' => 'Round not found.', 'token' => $token], 404);
        }
        $rounds = Round::where('round_number', $round->round_number)
                        -> where('session_id', $round->session_id)
                        -> leftjoin('users', 'rounds.user_id', '=', 'users.id')
                        -> where('role', '<', 3)
                        -> select('rounds.*', 'users.name_cn', 'users.school_cn')
                        -> get();
        $data = array();
        $data['rounds'] = $rounds;
        $data['user'] = $round;
        if ($round->status > 0)
        {
            $data['session'] = 
            Sessions::where('sessions.id', $round->session_id)
                ->leftjoin('groups', 'sessions.group_id', '=', 'groups.id')
                ->select ('sessions.neg_title', 'sessions.pos_title', 'sessions.date', 'groups.group_name', 'groups.t_write', 'groups.t_read', 'groups.t_debate')
                ->first();
            $data['articles'] = Articles::where('round_id', $round->id)->where('type', 0)->first();
        }
        else
        {
            $data['session'] = 
            Sessions::where('sessions.id', $round->session_id)
                ->leftjoin('groups', 'sessions.group_id', '=', 'groups.id')
                ->select ('sessions.date', 'groups.group_name', 'groups.t_write', 'groups.t_read', 'groups.t_debate')
                ->first();
        }
        if ($round->status > 1)
        {
            foreach ($rounds as $key => $value) {
                if ($value->id != $round->id)
                    $data['ops_argument'] = Articles::where('round_id', $value->id)->where('type', 0)->first();
                else
                    $data['my_argument'] = Articles::where('round_id', $value->id)->where('type', 0)->first();
            }
        }
        if ($round->status > 2)
            $data['articles'] = Articles::where('round_id', $round->id)->where('type', 1)->first();
        else
            $data['articles'] = Articles::where('round_id', $round->id)->where('type', 0)->first();
        return response()->json(['success' => true, 'data' => $data, 'token' => $token], 200);
    }

    public function store(Request $request)
    {
        // Create a new round
        $round = Round::create($request->all());
        return response()->json(['success' => true, 'data' => $round], 201);
    }

    public function judgeStore(Request $request)
    {
        $round = Round::where('session_id', $request->input('session_id'))
                        -> where('round_number', $request->input('round_number'))
                        -> where('role', 3)
                        -> delete();
        foreach ($request['user_id'] as $key => $value) {
            $request->merge(['user_id' => $value]);
            $round = Round::create($request->all());
        }
        // $round = Round::create($request->all());
        return response()->json(['success' => true, 'data' => $round], 201);
    }

    // getRoundBySid
    public function getRoundBySid($session_id)
    {
        $ret = array();
        $round = Round::where('session_id', $session_id) 
                    -> where('round_number', '>', 0)
                    -> leftJoin('users', 'rounds.user_id', '=', 'users.id')
                    -> select('rounds.*', 'users.name_cn', 'users.school_cn')
                    -> get();
        foreach ($round as $key => $value) {
            if (!array_key_exists($value->round_number, $ret)) {
                $ret[$value->round_number] = array();
                $ret[$value->round_number]['candidates'] = array();
                $ret[$value->round_number]['judges'] = array();
            }
            switch ($value->role) {
                case 1:
                    $ret[$value->round_number]['candidates']['pos'] = $value;
                    break;

                case 2:
                    $ret[$value->round_number]['candidates']['neg'] = $value;
                    break;
                
                default:
                    array_push($ret[$value->round_number]['judges'], $value);
                    break;
            }
        }
        return response()->json(['success' => true, 'data' => $ret], 200);
    }

    public function update(Request $request, $id)
    {
        // Update a round by ID
        $round = Round::find($id);
        if ($round->role < 3 && !( $request->has('status')))
        {
            $judges = Round::where('session_id', $round->session_id)
                            -> where('round_number', $round->round_number)
                            -> where('role', 3)
                            -> delete();
        }
        if (!$round) {
            return response()->json(['success' => false, 'message' => 'Round not found.'], 404);
        }
        $round->update($request->all());
        if ($round->role < 3 && $round->status == 1)
        {
            $round->start = time();
            $round->save();
            Articles::initArticle($round->id);
        }
        return response()->json(['success' => true, 'data' => $round], 200);
    }

    public function destroy($id)
    {
        // Delete a round by ID
        $round = Round::find($id);
        $judges = Round::where('session_id', $round->session_id)
                        -> where('round_number', $round->round_number)
                        -> where('role', 3)
                        -> delete();
        if (!$round)
            return response()->json(['success' => false, 'message' => 'Round not found.'], 404);
        $round->delete();
        return response()->json(['success' => true, 'message' => 'Round deleted successfully.'], 200);
    }

    // shuffle by session id
    public function shuffle(Request $request, $session_id)
    {
        $i = 1;
        $data = Round::where('session_id', $session_id)
                        -> where('role', '<=', 2)
                        -> inRandomOrder() 
                        -> get();
        foreach ($data as $key => $value) 
        {
            $value->update(['round_number' => $i / 2, 'role' => ($i % 2) + 1]);
            $i++;
        }
        
        return response()->json(['success' => true, 'data' => $data], 200);
    }

    // end all round by session id
    public function endAllRound(Request $request, $session_id)
    {
        $data = Round::where('session_id', $session_id) ->get();
        foreach ($data as $key => $value) {
            $value->update(['status' => 5]);
            $value->timestamps = true;
            $value->updated_at = time();
            $value->save();
        }
        
        return response()->json(['success' => true, 'data' => $data], 200);
    }

    // upload image
    public function uploadImage(Request $request, $id)
    {
        $content = Round::find($id);
        log::info($content);
        if (!$content)
            return ("error");
        if ($content->camera
            && file_exists($_SERVER['DOCUMENT_ROOT']."/camera//" . $content->camera)
            && (is_writable($_SERVER['DOCUMENT_ROOT']."/camera//" . $content->camera))
        )
        {
            unlink($_SERVER['DOCUMENT_ROOT']."/camera//" . $content->camera);
            $content->camera = NULL;
            $content->save();
        }

        if($request->has('dataURI'))
        {
            // log::info($request['dataURI']);
            try {
                $mime = substr($request['dataURI'], 5, strpos($request['dataURI'], ';') - 5);
                $extension = explode('/', $mime)[1];
                $filename = Uuid::uuid4() . '.jpeg';
                log::info($filename);
                $file_path = public_path() .'/camera//' . $filename;
                $data = base64_decode(str_replace('data:'.$mime.';base64,', '', $request['dataURI']));
                file_put_contents($file_path, $data);
                
                $content->camera = $filename;
                $content->timestamps = false;
                $content->camera_ts = time();
                $content->save();
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Failed to upload image.'], 400);
            } 
        }

        $row = Round::where('session_id', $content->session_id)
                    -> where('round_number', $content->round_number)
                    -> where('user_id', '!=', $content->user_id)
                    -> first();

        log::info($row);

        if (!$row || !$row['camera'])
            return (NULL);
        return response()->json(['success' => true, 'data' => $row['camera']], 200);
    }

    // get article by round id
    public function getArticleByRid(Request $request, $rid)
    {
        $article = Articles::where('round_id', $rid)->get();
        if (!$article) {
            return response()->json(['success' => false, 'message' => 'Article not found.'], 404);
        }
        $session = Round::where('rounds.id', $rid)
                        -> leftjoin('sessions', 'rounds.session_id', '=', 'sessions.id')
                        -> leftjoin('users', 'rounds.user_id', '=', 'users.id')
                        -> select('sessions.*', 'users.name_cn', 'users.school_cn', 'rounds.status', 'rounds.updated_at', 'rounds.camera')
                        -> first();
        
        $data = array();
        $data['session'] = $session;
        $data['article'] = $article;
        
        return response()->json(['success' => true, 'data' => $data], 200);
    }

    public function getFeedbackByRid(Request $request, $rid)
    {
        $feedback = Judges::where('round_id', $rid)->get();
        if (!$feedback) {
            return response()->json(['success' => false, 'message' => 'feedback not found.'], 404);
        }
        $session = Round::where('rounds.id', $rid)
                        -> leftjoin('sessions', 'rounds.session_id', '=', 'sessions.id')
                        -> leftjoin('users', 'rounds.user_id', '=', 'users.id')
                        -> select('sessions.*', 'users.name_cn', 'users.school_cn', 'rounds.status', 'rounds.updated_at')
                        -> first();
        
        $data = array();
        $data['session'] = $session;
        $data['feedback'] = $feedback;
        
        return response()->json(['success' => true, 'data' => $data], 200);
    }
}
