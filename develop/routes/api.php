<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Models\PostImage;
use App\Models\Admin;
use App\Models\Users;
use App\Models\Competition;
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

use App\Http\Controllers\UserController;
Route::prefix('users')->group(function () {
    Route::post('/info', [UserController::class, 'getInfo']);
    Route::post('/signup', [UserController::class, 'signup']);
    Route::get('/signup/list', [UserController::class, 'getSignupList']);
    Route::get('/signup/{id}', [UserController::class, 'getSignupById']);
    Route::post('/signup/{id}/approval', [UserController::class, 'signUpApproval']);
    Route::get('/token', [UserController::class, 'getToken']);
    Route::post('/login', [UserController::class, 'login']);
    Route::get('/list/candidates', [UserController::class, 'getCandidatesList']);
    Route::get('/list/judges', [UserController::class, 'getJudgesList']);
    Route::get('/{id}', [UserController::class, 'getUserById']);
    Route::post('/create', [UserController::class, 'createUser']);
    Route::put('/{id}', [UserController::class, 'updateUser']);
    Route::delete('/{id}', [UserController::class, 'deleteUser']);
    Route::post('/lock/{id}', [UserController::class, 'lockUser']);
});
    
use App\Http\Controllers\CompetitionController;
Route::get('competitions', [CompetitionController::class, 'index']);
Route::get('competitions/{id}', [CompetitionController::class, 'show']);
Route::post('competitions', [CompetitionController::class, 'store']);
Route::put('competitions/{id}', [CompetitionController::class, 'update']);
Route::delete('competitions/{id}', [CompetitionController::class, 'destroy']);


use App\Http\Controllers\GroupController;
Route::get('groups', [GroupController::class, 'index']);
Route::get('groups/{id}', [GroupController::class, 'show']);
Route::post('groups', [GroupController::class, 'store']);
Route::put('groups/{id}', [GroupController::class, 'update']);
Route::delete('groups/{id}', [GroupController::class, 'destroy']);


use App\Http\Controllers\SessionController;
Route::get('groups/{id}/sessions', [SessionController::class, 'showByGid']);
Route::get('groups/{id}/candidates', [SessionController::class, 'showCandidatesByGid']);

Route::get('sessions', [SessionController::class, 'index']);
Route::get('sessions/{id}', [SessionController::class, 'show']);
Route::post('sessions', [SessionController::class, 'store']);
Route::put('sessions/{id}', [SessionController::class, 'update']);
Route::delete('sessions/{id}', [SessionController::class, 'destroy']);


use App\Http\Controllers\RoundController;
Route::post('sessions/{sid}/shuffle', [RoundController::class, 'shuffle']);
Route::post('sessions/{sid}/end', [RoundController::class, 'endAllRound']);
Route::get('sessions/{sid}/rounds', [RoundController::class, 'getRoundBySid']);

Route::get('rounds', [RoundController::class, 'index']);
Route::get('rounds/{id}', [RoundController::class, 'show']);
Route::post('rounds', [RoundController::class, 'store']);
Route::post('rounds/judges', [RoundController::class, 'judgeStore']);
Route::put('rounds/{id}', [RoundController::class, 'update']);
Route::delete('rounds/{id}', [RoundController::class, 'destroy']);
Route::post('rounds/{id}/image', [RoundController::class, 'uploadImage']);
Route::get('rounds/{id}/articles', [RoundController::class, 'getArticleByRid']);

use App\Http\Controllers\ArticlesController;
Route::get('articles', [ArticlesController::class, 'index']);
Route::get('articles/{id}', [ArticlesController::class, 'show']);
Route::post('articles', [ArticlesController::class, 'store']);
Route::put('articles/{id}', [ArticlesController::class, 'update']);
Route::delete('articles/{id}', [ArticlesController::class, 'destroy']);


use App\Http\Controllers\JudgeController;
Route::get('judges/info',         [JudgeController::class, 'getInfo']);
Route::get('judges/list',         [JudgeController::class, 'showByUid']);
Route::get('judges/sessions/{sid}/rounds/{rid}', [JudgeController::class, 'judgeSession']);
Route::put('judges/submit/{rid}', [JudgeController::class, 'judgeSubmit']);

use App\Http\Controllers\CandidateController;
Route::get('candidates/info', [CandidateController::class, 'getInfo']);
Route::get('candidates/list', [CandidateController::class, 'showByUid']);


Route::prefix('image')->group(function () {

    // /api/image/upload/proof
    Route::post('/upload/{type}', function(Request $request, $type){
        $input = request() -> all();
        $file = $request->file('file');
        if ($file) {
            $content = PostImage::uploadImage($type, $file);
            
            if ($content === 'error') {
                return response()->json(['success' => false, 'message' => 'Image upload failed'], 400);
            }
    
            return response()->json(['success' => true, 'content' => $content], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'No file uploaded'], 400);
        }
    });

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
