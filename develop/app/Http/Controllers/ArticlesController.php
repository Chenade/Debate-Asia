<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Articles;
use App\Models\Group;
use App\Models\sessions;
use App\Models\Round;

use Log;
use DB;

class ArticlesController extends Controller
{
    //

    // update
    public function update(Request $request, $id)
    {
        // Update a specific article
        $article = Articles::where('article_id', $id)->first();
        if (!$article) {
            return response()->json(['success' => false, 'message' => 'Article not found.'], 404);
        }
        $article->update($request->all());
        return response()->json(['success' => true, 'data' => $article], 200);
    }

    public function getArticleByRid(Request $request, $rid)
    {
        $article = Articles::where('round_id', $rid)->get();
        if (!$article) {
            return response()->json(['success' => false, 'message' => 'Article not found.'], 404);
        }
        
        return response()->json(['success' => true, 'data' => $article], 200);
    }

    public function getArticleByCompetitorId(Request $request, $cid)
    {
        $groupsIds = Group::where('competition_id', $cid)->pluck('id');
        $sessions = sessions::whereIn('group_id', $groupsIds)->get();
        $sessionsIds = $sessions->pluck('id');
        for($i = 0; $i < count($sessions); $i++) {
            $articles = Round::where('session_id', $sessions[$i]->id)
                ->join('users', 'rounds.user_id', '=', 'users.id')
                ->join('articles', 'rounds.id', '=', 'articles.round_id')
                ->select(
                    'articles.content', 
                    'users.name_cn', 
                    'users.school_cn', 
                    'rounds.role', 
                    'articles.type', 
                    'rounds.round_number',
                    DB::raw('CONCAT(rounds.round_number, "-", rounds.role) as round_type')
                )
                ->get()
                ->groupBy('round_number');
            $articles = $articles->map(function($item, $key) {
                return $item->groupBy('role');
            });
            $sessions[$i]->rounds = $articles;
        }
        
        return response()->json(['success' => true, 'data' => $sessions], 200);
    }

    public function getArticleByGoupId(Request $request, $gid)
    {
        $sessions = sessions::where('group_id', $gid)->get();
        $sessionsIds = $sessions->pluck('id');
        for($i = 0; $i < count($sessions); $i++) {
            $articles = Round::where('session_id', $sessions[$i]->id)
                ->join('users', 'rounds.user_id', '=', 'users.id')
                ->join('articles', 'rounds.id', '=', 'articles.round_id')
                ->select(
                    'articles.content', 
                    'users.name_cn', 
                    'users.school_cn', 
                    'rounds.role', 
                    'articles.type', 
                    'rounds.round_number',
                    DB::raw('CONCAT(rounds.round_number, "-", rounds.role) as round_type')
                )
                ->get()
                ->groupBy('round_number');
            $articles = $articles->map(function($item, $key) {
                return $item->groupBy('role');
            });
            $sessions[$i]->rounds = $articles;
        }
        
        return response()->json(['success' => true, 'data' => $sessions], 200);
    }
}
