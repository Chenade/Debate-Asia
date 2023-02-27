<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Models\PostImage;
use App\Models\Admin;
use App\Models\users;
use App\Models\competition;
use App\Models\sessions;
use App\Models\judges;
use App\Models\articles;
use App\Models\Awards;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//----- Admin Control ----//
// token done
Route::prefix('admin')->group(function () {
    Route::middleware(['logresponse'])->group(function () {
    Route::post('/signup', function(Request $request){
        $token = $request->header('token');
        $token = USERS::validToken($token);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        $input = request() -> all();
        $required = array('account', 'password', 'authority');
        if (count(array_intersect_key(array_flip($required), $input)) != count($required))
            return response() -> json(['success' => False, 'message' => 'Missing required column.'], 400);    
        $token2 = users::store($input);
        return response() -> json(['success' => True, 'token' => $token], 200);
    });

    Route::post('/ct', function(Request $request){
        $token = $request->header('token');
        $token = USERS::validToken($token);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        // Log::info('/admin/ct - 403 {"success":false,"message":"Invalid Token"}'  . ' | ' . $token);
        $auth = USERS::getauth($token);
        return response() -> json(['success' => True, 'auth' => $auth, 'token' => $token], 200);
    });

    Route::get('/users/list',function (Request $request){
        $token = $request->header('token');
        $token = ADMIN::validToken($token);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);

        $row = USERS::getList();
        foreach ($row as &$value) {
            $value->school = $value->school_cn . ' (' . $value->school_zh . ')';
            $value->name = $value->name_cn . ' (' . $value->name_zh . ')';
            switch ($value->authority) {
                case 1:
                    $value->authority = '選手';
                    break;
                case 2:
                    $value->authority = '裁判';
                    break;
                case 7:
                    $value->authority = '工作人員';
                    break;
            }
            $value->operate = '<button type="button" class="btn btn-info edit-btn" style="margin:0" data-id="'.$value->id.'"><i class="far fa-solid fa-gears"></i></button>';
        }
        return response() -> json(['success' => True, 'message' => '','data' => $row, 'token' => $token], 200);
    });

    Route::get('/competition/list',function (Request $request){
        $token = $request->header('token');
        $token = ADMIN::validToken($token);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);

        $row = COMPETITION::getList();
        foreach ($row as &$value) {
            $value->candidates = count(SESSIONS::getListbyCID(1, $value->id));
            $value->date = '<span class="date-convert">' . $value->date . '</span>';
            // $value->end_at = '<span class="date-convert">' . $value->end_at . '</span>';
            $value->operate = '<button type="button" class="btn btn-info edit-btn" style="margin:0" data-id="'.$value->id.'"><i class="far fa-solid fa-gears"></i></button>';
            // $value->operate .= '<button type="button" class="btn btn-danger delete-btn" style="margin:0" data-id="'.$value->id.'"><i class="far fa-solid fa-trash-can"></i></button>';
        }
        return response() -> json(['success' => True, 'message' => '','data' => $row, 'token' => $token], 200);
    });

    Route::get('/articles/list/{said}/{sbid}',function (Request $request, $said, $sbid){
        $token = $request->header('token');
        $token = ADMIN::validToken($token);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);

        $row['candidates']['a'] = SESSIONS::getElementById($said);
        $row['candidates']['b'] = SESSIONS::getElementById($sbid);
        $row['a'] = ARTICLES::getArticlebySID($said);
        $row['b'] = ARTICLES::getArticlebySID($sbid);
        return response() -> json(['success' => True, 'message' => '','data' => $row, 'token' => $token], 200);
    });
});
});

Route::prefix('users')->group(function () {
    
    Route::get('/token',function (Request $request){
        $token = $request->header('token');
        $token = USERS::validToken($token);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        
        $val = USERS::getId($token);
        return response() -> json(['success' => True, 'id' => $val, 'token' => $token], 200);
    });

    Route::post('/login', function(){
        $input = request() -> all();
        $required = array('account', 'password');
        if (count(array_intersect_key(array_flip($required), $input)) != count($required))
            return response() -> json(['success' => False, 'message' => 'Missing required column.'], 400);
        $id = users::getlogin($input);
        if(!$id)
            return  response() -> json(['success' => False, 'message' => 'Wrong account or password'], 403);
        $content = users::find($id);
        $token = USERS::genToken($input['account']);
        $content->token = $token;
        $content->timestamps = true;
        $content->save();
        $url = '/';
        if ($content->authority == 7)
            $url = '/admin';
        else if ($content->authority == 1)
            $url = '/candidate';
        else if ($content->authority == 2)
            $url = '/judge';
        return response() -> json(['success' => True, 'message' => $token, 'url' => $url], 200);
    });

    Route::get('/list/candidates',function (){
        $content = USERS::getElementByRole(1);
        return response() -> json(['success' => True, 'message' => '', 'data' => $content], 200);
    });

    Route::get('/list/judges',function (){
        $content = USERS::getElementByRole(2);
        if (!$content)
            return response() -> json(['success' => False, 'message' => 'News not found.'], 404);
        return response() -> json(['success' => True, 'message' => '', 'data' => $content], 200);
    });

    Route::get('/{id}',function ($id){
        $content = USERS::getElementById($id);
        if (!$content)
            return response() -> json(['success' => False, 'message' => 'Users not found.'], 404);
        // $content[0]->images = PostImage::getList(1, $id);
        return response() -> json(['success' => True, 'message' => '', 'data' => $content], 200);
    });
    
    Route::post('/create',function (){
        $input = request() -> all();
        $token = USERS::validToken($token);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        $required = array('title', 'content');
        if (count(array_intersect_key(array_flip($required), $input)) != count($required))
            return response() -> json(['success' => False, 'message' => 'Missing required column.'], 400);    
        $row = NEWS::store($input);
        return response() -> json(['success' => True, 'message' => $row, 'token' => $token], 200);
    });
    
    Route::put('/{id}',function (Request $request, $id){
        $token = $request->header('token');
        $token = USERS::validToken($token);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        $input = request() -> all();
        $content = USERS::updateById($id, $input);
        if (!$content)
            return response() -> json(['success' => False, 'message' => 'News not found.'], 404);
        return response() -> json(['success' => True, 'message' => '', 'token' => $token], 200);
    });
});

Route::prefix('competition')->group(function () {

    Route::get('/{id}',function ($id){
        $content = COMPETITION::getElementById($id);
        if (!$content)
            return response() -> json(['success' => False, 'message' => 'Competition not found.'], 404);
        return response() -> json(['success' => True, 'message' => '', 'data' => $content[0]], 200);
    });
    
    Route::post('/create',function (){
        $input = request() -> all();
        $token = ADMIN::checkToken($input);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        $required = array('title', 'tag');
        if (count(array_intersect_key(array_flip($required), $input)) != count($required))
            return response() -> json(['success' => False, 'message' => 'Missing required column.'], 400);    
        $row = COMPETITION::store($input);
        return response() -> json(['success' => True, 'message' => '', 'token' => $token], 200);
    });
    
    Route::put('/{id}',function ($id){
        $input = request() -> all();
        $token = ADMIN::checkToken($input);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        $content = COMPETITION::updateById($id, $input);
        if (!$content)
            return response() -> json(['success' => False, 'message' => 'News not found.'], 404);
        return response() -> json(['success' => True, 'message' => '', 'token' => $token], 200);
    });
    
    // Route::get('/delete/{id}',function ($id){
    //     // $token = ADMIN::validToken($token);
    //     // if(!$token)
    //         // return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
    //     $row = COMPETITION::deleteById($id);
    //     if (!$row)
    //         return response() -> json(['success' => False, 'message' => 'COMPETITION not found.'], 200);
    //     return response() -> json(['success' => True, 'message' => ''], 200);
    // });
});

Route::prefix('sessions')->group(function () {
    Route::get('/{roles}/{cid}',function (Request $request, $roles, $cid){
        $token = $request->header('token');
        $token = ADMIN::validToken($token);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);

        if ($roles == 'candidates')
            $row = SESSIONS::getListbyCID(1, $cid);
        else
            $row = SESSIONS::getListbyCID(3, $cid);
        foreach ($row as $value)
        {
            switch ($value->role) {
                case 1:
                    $value->roles = '正方';
                    break;
                case 2:
                    $value->roles = '反方';
                    break;
                case 3:
                    $value->roles = '裁判';
                    break;
                default:
                    $value->roles = '未指定';
                    break;
            }
        }
        return response() -> json(['success' => True, 'message' => '','data' => $row, 'token' => $token], 200);
    });

    Route::get('/{id}',function ($id){
        $token = $request->header('token');
        $token = USERS::validToken($token);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        
        $content = SESSIONS::getElementById($id);
        if (!$content)
            return response() -> json(['success' => False, 'message' => 'Competition not found.'], 404);
        return response() -> json(['success' => True, 'token' => $token, 'data' => $content[0]], 200);
    });
    
    Route::post('/create',function (Request $request){
        $token = $request->header('token');
        $token = ADMIN::validToken($token);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        $input = request() -> all();
        $required = array('mid', 'cid');
        if (count(array_intersect_key(array_flip($required), $input)) != count($required))
            return response() -> json(['success' => False, 'message' => 'Missing required column.'], 400);    
        $row = SESSIONS::store($input);
        if (!$row)
            return response() -> json(['success' => False, 'message' => 'Member already joined', 'token' => $token], 400);
        return response() -> json(['success' => True, 'message' => $row, 'token' => $token], 200);
    });

    Route::post('/delete',function (Request $request){
        $token = $request->header('token');
        $token = ADMIN::validToken($token);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        $input = request() -> all();
        // $required = array('mid', 'cid');
        // if (count(array_intersect_key(array_flip($required), $input)) != count($required))
        //     return response() -> json(['success' => False, 'message' => 'Missing required column.'], 400);    
        $row = SESSIONS::deleteById($input);
        if (!$row)
            return response() -> json(['success' => False, 'message' => 'Member not joined', 'token' => $token], 400);
        return response() -> json(['success' => True, 'message' => $input, 'token' => $token], 200);
    });
    
    Route::post('/pairs/{id}', function($cid){
        $lst = array();
        $row = SESSIONS::getListbyCID(1, $cid);
        foreach ($row as &$value) {
            array_push($lst, $value->mid);
        }
        shuffle($lst);
        $room = 1;
        $count = 1;
        foreach ($lst as &$mid) {
            $row = SESSIONS::pairsRoom($cid, $mid, $room, ($count % 2) + 1);
            if ($count % 2 == 0) $room += 1;
            $count += 1;
        }
        return response() -> json(['success' => True, 'message' => '', 'token' => 'token'], 200);
    }); 

    Route::get('/{cid}/rooms/{id}/status',function (Request $request, $cid, $id){
        $token = $request->header('token');
        $token = USERS::validToken($token);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        
        $content = SESSIONS::getSessionStatus($id, $cid);
        $content['mid'] = USERS::getId($token);
        return response() -> json(['success' => True, 'data' => $content, 'token' => $token], 200);
    });
    
    Route::put('/{id}',function (Request $request, $id){
        $token = $request->header('token');
        $token = USERS::validToken($token);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        $input = request() -> all();
        $content = SESSIONS::updateById($id, $input);
        if (!$content)
            return response() -> json(['success' => False, 'message' => 'Sessions not found.'], 404);
        return response() -> json(['success' => True, 'message' => '', 'token' => $token], 200);
    });

});

Route::prefix('articles')->group(function () {
    
    Route::put('/admin/update',function (Request $request){
        $token = $request->header('token');
        $token = ADMIN::validToken($token);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        
        $input = request() -> all();
        $content = ARTICLES::updateById($input['a'][0]['id'], $input['a'][0]);
        if ($content) $content = ARTICLES::updateById($input['a'][1]['id'], $input['a'][1]);
        if ($content) $content = ARTICLES::updateById($input['b'][0]['id'], $input['b'][0]);
        if ($content) $content = ARTICLES::updateById($input['b'][1]['id'], $input['b'][1]);
        if (!$content)
            return response() -> json(['success' => False, 'message' => 'AArticle not found.'], 404);
        return response() -> json(['success' => True, 'message' => $input, 'token' => $token], 200);
    });

    Route::get('/{id}',function ($id){
        $content = SESSIONS::getElementById($id);
        if (!$content)
            return response() -> json(['success' => False, 'message' => 'Competition not found.'], 404);
        return response() -> json(['success' => True, 'message' => '', 'data' => $content[0]], 200);
    });
    
    Route::put('/{id}',function (Request $request, $id){
        $token = $request->header('token');
        $token = USERS::validToken($token);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        
        $input = request() -> all();
        $content = ARTICLES::updateById($id, $input);
        if (!$content)
            return response() -> json(['success' => False, 'message' => 'Competition not found.'], 404);
        return response() -> json(['success' => True, 'token' => $token, 'data' => $content], 200);
    });

    Route::get('download/{id}',function (Request $request, $id){
        $token = $request->header('token');
        $token = USERS::validToken($token);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        
        $content = ARTICLES::getArticlebySid($id);
        if (!$content)
            return response() -> json(['success' => False, 'message' => 'Competition not found.'], 404);
        $return = COMPETITION::getInfoBySid($id);
        $return->article = $content;
        return response() -> json(['success' => True, 'message' => '', 'data' => $return], 200);
    });

});

Route::prefix('candidates')->group(function () {
    Route::get('/list',function (Request $request){
        $token = $request->header('token');
        $token = USERS::validToken($token);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        
        $row = USERS::getEventListByUser(USERS::getId($token));
        if (!$row)
            return response() -> json(['success' => FALSE, 'message' => 'User not found'], 404);
        return response() -> json(['success' => True, 'message' => '','data' => $row, 'token' => $token], 200);
    });

});

Route::prefix('judges')->group(function () {
    Route::get('/list/{cid}',function ($cid){
        $row = JUDGES::getListbyCID($cid);
        return response() -> json(['success' => True, 'message' => '','data' => $row], 200);
    });

    Route::get('/list',function (Request $request){
        $token = $request->header('token');
        $token = USERS::validToken($token);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        
        // $row = USERS::getJudgeListByUser(USERS::getId($token));
        $row = JUDGES::getJudgeList(USERS::getId($token));
        if (!$row)
            return response() -> json(['success' => FALSE, 'message' => 'User not found'], 404);
        return response() -> json(['success' => True, 'message' => '','data' => $row, 'token' => $token], 200);
    });

    Route::get('/{cid}/roomlist',function (Request $request, $cid){
        $token = $request->header('token');
        $token = USERS::validToken($token);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        
        $row = JUDGES::getJudgeRoomList($cid, USERS::getId($token));
        if (!$row)
            return response() -> json(['success' => FALSE, 'message' => 'User not found'], 404);
        return response() -> json(['success' => True, 'message' => '','data' => $row, 'token' => $token], 200);
    });

    Route::get('sessions/{cid}/rooms/{id}/status',function (Request $request, $cid, $id){
        $token = $request->header('token');
        $token = USERS::validToken($token);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        
        $row = JUDGES::getJudgeRoom($cid, $id, $token);
            return response() -> json(['success' => TRUE, 'message' => 'Judge info not found', 'data' => $row], 200);
            if (!$row || count($row) < 1)
            return response() -> json(['success' => TRUE, 'message' => 'Judge info not found', 'data' => $row], 200);
        $return['competition']['title'] = $row[0]->title;
        $return['competition']['tag'] = $row[0]->tag;
        $return['competition']['date'] = $row[0]->date;
        $return['competition']['t_read'] = $row[0]->t_read;
        $return['competition']['t_write'] = $row[0]->t_write;
        $return['competition']['t_debate'] = $row[0]->t_debate;

        foreach ($row as $key => $value) 
        {
            $return['usr'][$value->role]['judge']['id'] = $value->id;
            $return['usr'][$value->role]['judge']['comment'] = $value->comment;
            $return['usr'][$value->role]['judge']['score'][1] = $value->score_1;
            $return['usr'][$value->role]['judge']['score'][2] = $value->score_2;
            $return['usr'][$value->role]['judge']['score'][3] = $value->score_3;
            $return['usr'][$value->role]['judge']['score'][4] = $value->score_4;
            $return['usr'][$value->role]['judge']['sum_score'] = $value->score;
            $return['usr'][$value->role]['article'] = $value->article;
        }
        
        return response() -> json(['success' => True, 'message' => '','data' => $return, 'token' => $token], 200);
    });

    Route::put('/submit/{id}',function (Request $request, $id){
        $token = $request->header('token');
        $token = USERS::validToken($token);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        $input = request() -> all();
        $content = JUDGES::updateById($id, $input);
        if (!$content)
            return response() -> json(['success' => False, 'message' => 'Sessions not found.'], 404);
        return response() -> json(['success' => True, 'message' => '', 'token' => $token], 200);
    });

    Route::post('/{cid}/end', function(Request $request, $cid){
        $token = $request->header('token');
        $token = USERS::validToken($token);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        
        $input = request() -> all();
        $content = JUDGES::endJudging($cid);
        return response() -> json(['success' => True, 'content' => $content, 'token' => $token], 200);
    });

    Route::get('download/{id}',function (Request $request, $id){
        $token = $request->header('token');
        $token = USERS::validToken($token);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        
        $content = JUDGES::getJudgebySID($id);
        if (!$content)
            return response() -> json(['success' => False, 'message' => 'Competition not found.'], 404);
        $return = COMPETITION::getInfoBySid($id);
        $return->judge = $content;
        return response() -> json(['success' => True, 'message' => '', 'data' => $return], 200);
    });

});

Route::prefix('image')->group(function () {
    Route::post('/session/{sid}/store', function(Request $request, $sid){
        $token = $request->header('token');
        $token = USERS::validToken($token);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        
        $input = request() -> all();
        $content = SESSIONS::uploadImage($sid, $input);
        if ($content == 'error')
            return response() -> json(['success' => False, 'message' => 'Imagess upload failed'], 400);
        return response() -> json(['success' => True, 'content' => $content->camera, 'token' => $token], 200);
    });

    Route::get('/{type}/{id}/get', function(Request $request, $type, $id){
        $category = get_category($type);
        $content = get_content($type, $id);
        
        if (!$content)
            return response() -> json(['success' => False, 'message' => $type . ' not found.'], 404);
        $image = PostImage::getList($category, $id);
        return response() -> json(['success' => True, 'message' => '', 'data' => $image], 200);
    });

    Route::delete('/{id}/{token}', function ($id, $token) {
        $token = ADMIN::validToken($token);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        $row = PostImage::deleteById($id);
        if (!$row)
            return response() -> json(['success' => False, 'message' => 'News not found.'], 200);
        return response() -> json(['success' => True, 'message' => '', 'token' => $token], 200);
    });

    Route::get('/convert', function(){
        $image = SESSIONS::saveImage();
        return response() -> json(['success' => True, 'message' => '', 'data' => $image], 200);
    });
});

Route::prefix('ranking')->group(function () {
    Route::post('/candidates/list',function (Request $request){
        $token = $request->header('token');
        $token = USERS::validToken($token);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);

        $input = request() -> all();
        $row = SESSIONS::getCandidatesListbyCid($input);
        if (!$row)
            return response() -> json(['success' => FALSE, 'message' => 'User not found'], 404);
        return response() -> json(['success' => True, 'message' => '','data' => $row, 'token' => $token], 200);
    });

    Route::post('/submit',function (Request $request){
        $token = $request->header('token');
        $token = USERS::validToken($token);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);

        $input = request() -> all();
        $row = SESSIONS::updateRankingList($input);
        // if (!$row)
        //     return response() -> json(['success' => FALSE, 'message' => 'User not found'], 404);
        return response() -> json(['success' => True, 'message' => '','data' => $row, 'token' => $token], 200);
    });

});

Route::prefix('awards')->group(function () {

    Route::get('/list',function (Request $request){
        $token = $request->header('token');
        $token = ADMIN::validToken($token);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        $row = Awards::getList();
        return response() -> json(['success' => True, 'data' => $row, 'token' => $token], 200);
    });

    Route::post('/create',function (Request $request){
        $token = $request->header('token');
        $token = ADMIN::validToken($token);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        $input = request() -> all();
        $required = array('name');
        if (!$request->name || count(array_intersect_key(array_flip($required), $input)) != count($required))
            return response() -> json(['success' => False, 'message' => 'Missing required column.'], 400);    
        $row = Awards::store($input);
        return response() -> json(['success' => True, 'message' => $row, 'token' => $token], 200);
    });

    Route::post('/delete',function (Request $request){
        $token = $request->header('token');
        $token = ADMIN::validToken($token);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        $input = request() -> all();
        $row = Awards::deleteById($input);
        if (!$row)
            return response() -> json(['success' => False, 'message' => 'Member not joined', 'token' => $token], 400);
        return response() -> json(['success' => True, 'message' => $input, 'token' => $token], 200);
    });
    
    Route::put('/{id}',function (Request $request, $id){
        $token = $request->header('token');
        $token = USERS::validToken($token);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        $input = request() -> all();
        $content = Awards::updateById($id, $input);
        if (!$content)
            return response() -> json(['success' => False, 'message' => 'Sessions not found.'], 404);
        return response() -> json(['success' => True, 'message' => '', 'token' => $token], 200);
    });

});
