<?php
namespace App\Http\Controllers;

use App\Models\Round;
use App\Models\Sessions;
use App\Models\Articles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

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
        $rounds = Round::where('round_number', $round->round_number)
                        -> where('session_id', $round->session_id)
                        -> leftjoin('users', 'rounds.user_id', '=', 'users.id')
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
        return response()->json(['success' => true, 'data' => $data], 200);
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
           Articles::initArticle($round->id);
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
            $value->update(['status' => 4]);
        }
        
        return response()->json(['success' => true, 'data' => $data], 200);
    }

    // upload image
    public function uploadImage(Request $request, $id)
    {
        $content = Round::find($id);
        if (!$content)
            return ("error");
        if ($content->camera && (is_writable($_SERVER['DOCUMENT_ROOT']."/camera//" . $content->camera)))
            unlink($_SERVER['DOCUMENT_ROOT']."/camera//" . $content->camera);
        $content->camera = Uuid::uuid4() . '.jpeg';
        $content->timestamps = false;
        $content->camera_ts = time();
        $content->save();

        $mime = substr($request['dataURI'], 5, strpos($request['dataURI'], ';') - 5);
        $extension = explode('/', $mime)[1];
        $filename = $content->camera;
        $file_path = public_path() .'/camera//' . $filename;
        $data = base64_decode(str_replace('data:'.$mime.';base64,', '', $request['dataURI']));
        file_put_contents($file_path, $data);

        $row = Round::where('session_id', $content->session_id)
                    -> where('round_number', $content->round_number)
                    -> where('user_id', '!=', $content->user_id)
                    -> first();
        if (!$row)
            return (NULL);
        return response()->json(['success' => true, 'data' => $row['camera']], 200);
    }
}
