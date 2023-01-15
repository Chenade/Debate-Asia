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
Route::prefix('admin')->group(function () {
    Route::post('/signup', function(){
        $input = request() -> all();
        $required = array('account', 'password', 'authority');
        if (count(array_intersect_key(array_flip($required), $input)) != count($required))
            return response() -> json(['success' => False, 'message' => 'Missing required column.'], 400);    
        $token = users::store($input);
        return response() -> json(['success' => True, 'message' => $token], 200);
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
        $token = users::genToken($input['account']);
        $content->token = $token;
        $content->timestamps = true;
        $content->save();
        return response() -> json(['success' => True, 'message' => $token, 'auth' => $content->authority], 200);
    });

    Route::post('/ct', function(){
        // $input = request() -> all();
        // $token = ADMIN::checkToken($input);
        // if(!$token)
        //     return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        return response() -> json(['success' => True, 'message' => '', 'token' => ''], 200);
    });

});

Route::prefix('image')->group(function () {
    Route::post('/{type}/{id}/store', function(Request $request, $type, $id){
        $token = ADMIN::validToken(request() -> token);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        
        $category = get_category($type);
        $content = get_content($type, $id);
        if (!$content)
            return response() -> json(['success' => False, 'message' => $type.' not found.'], 404);
        
        if ($category == 2)
        {
            $image = PostImage::getList($category, $id);
            foreach($image as $i)
            PostImage::deleteById($i->id);
        }
        $filename = PostImage::store($request, $category, $id);
        if (!$filename)
            return response() -> json(['success' => False, 'message' => 'Image upload failed'], 400);
        return response() -> json(['success' => True, 'message' => '', 'token' => $token], 200);
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
});

Route::prefix('users')->group(function () {
    // Route::get('/list',function (){
    //     $row = NEWS::getList();
    //     foreach ($row as &$value) {
    //         // $value->content = str_replace("'", '"', trim($value->content, "\\\""));
    //         // $value->content = json_decode($value->content, true);
    //         $value->images = PostImage::getList(1, $value->id);
    //     }
    //     return response() -> json(['success' => True, 'message' => '','data' => $row], 200);
    // });

    Route::get('/adminlist',function (){
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
            // $value->end_at = '<span class="date-convert">' . $value->end_at . '</span>';
            $value->operate = '<button type="button" class="btn btn-info edit-btn" style="margin:0" data-id="'.$value->id.'"><i class="far fa-solid fa-gears"></i></button>';
            // $value->operate .= '<button type="button" class="btn btn-danger delete-btn" style="margin:0" data-id="'.$value->id.'"><i class="far fa-solid fa-trash-can"></i></button>';
        }
        return response() -> json(['success' => True, 'message' => '','data' => $row], 200);
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
        $token = ADMIN::checkToken($input);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        $required = array('title', 'content');
        if (count(array_intersect_key(array_flip($required), $input)) != count($required))
            return response() -> json(['success' => False, 'message' => 'Missing required column.'], 400);    
        $row = NEWS::store($input);
        return response() -> json(['success' => True, 'message' => $row, 'token' => $token], 200);
    });
    
    Route::put('/{id}',function ($id){
        $input = request() -> all();
        $token = ADMIN::checkToken($input);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        $content = USERS::updateById($id, $input);
        if (!$content)
            return response() -> json(['success' => False, 'message' => 'News not found.'], 404);
        return response() -> json(['success' => True, 'message' => '', 'token' => $token], 200);
    });
    
    // Route::delete('/{id}/{token}',function ($id, $token){
    //     $token = ADMIN::validToken($token);
    //     if(!$token)
    //         return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
    //     $row = NEWS::deleteById($id);
    //     if (!$row)
    //         return response() -> json(['success' => False, 'message' => 'News not found.'], 200);
    //     return response() -> json(['success' => True, 'message' => '', 'token' => $token], 200);
    // });

    // Route::post('/{id}/uploadThumbnail', function(Request $request, $id){
    //     $token = ADMIN::validToken(request() -> token);
    //     if(!$token)
    //         return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        
    //     $content = NEWS::uploadThumbnail($request, $id);
    //     // $filename = PostImage::store($request, $category, $id);
    //     if (!$content)
    //         return response() -> json(['success' => False, 'message' => 'Image upload failed'], 400);
    //     return response() -> json(['success' => True, 'message' => '', 'token' => $token], 200);
    // });
});

Route::prefix('competition')->group(function () {
    Route::get('/adminlist',function (){
        $row = COMPETITION::getList();
        foreach ($row as &$value) {
            $value->candidates = count(SESSIONS::getListbyCID(1, $value->id));
            $value->date = '<span class="date-convert">' . $value->date . '</span>';
            // $value->end_at = '<span class="date-convert">' . $value->end_at . '</span>';
            $value->operate = '<button type="button" class="btn btn-info edit-btn" style="margin:0" data-id="'.$value->id.'"><i class="far fa-solid fa-gears"></i></button>';
            // $value->operate .= '<button type="button" class="btn btn-danger delete-btn" style="margin:0" data-id="'.$value->id.'"><i class="far fa-solid fa-trash-can"></i></button>';
        }
        return response() -> json(['success' => True, 'message' => '','data' => $row], 200);
    });

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
    
    // Route::delete('/{id}/{token}',function ($id, $token){
    //     $token = ADMIN::validToken($token);
    //     if(!$token)
    //         return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
    //     $row = ADS::deleteById($id);
    //     if (!$row)
    //         return response() -> json(['success' => False, 'message' => 'Banner not found.'], 200);
    //     return response() -> json(['success' => True, 'message' => '', 'token' => $token], 200);
    // });
});

Route::prefix('sessions')->group(function () {
    Route::get('/{roles}/{cid}',function ($roles, $cid){
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
        return response() -> json(['success' => True, 'message' => '','data' => $row], 200);
    });

    Route::get('/{id}',function ($id){
        $content = SESSIONS::getElementById($id);
        if (!$content)
            return response() -> json(['success' => False, 'message' => 'Competition not found.'], 404);
        return response() -> json(['success' => True, 'message' => '', 'data' => $content[0]], 200);
    });
    
    Route::post('/create',function (){
        $input = request() -> all();
        $token = ADMIN::checkToken($input);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        $required = array('mid', 'cid');
        if (count(array_intersect_key(array_flip($required), $input)) != count($required))
            return response() -> json(['success' => False, 'message' => 'Missing required column.'], 400);    
        $row = SESSIONS::store($input);
        if (!$row)
            return response() -> json(['success' => False, 'message' => 'Member already joined', 'token' => $token], 400);
        return response() -> json(['success' => True, 'message' => $row, 'token' => $token], 200);
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
});

Route::prefix('articles')->group(function () {
    Route::get('/adminlist/{said}/{sbid}',function ($said, $sbid){
        $row['candidates']['a'] = SESSIONS::getElementById($said);
        $row['candidates']['b'] = SESSIONS::getElementById($sbid);
        $row['a'] = ARTICLES::getArticlebySID($said);
        $row['b'] = ARTICLES::getArticlebySID($sbid);
        return response() -> json(['success' => True, 'message' => '','data' => $row], 200);
    });
    
    Route::put('/admin/update',function (){
        $input = request() -> all();
        $token = ADMIN::checkToken($input);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        $content = ARTICLES::updateById($input['a'][0]['id'], $input['a'][0]);
        if ($content) $content = ARTICLES::updateById($input['a'][1]['id'], $input['a'][1]);
        if ($content) $content = ARTICLES::updateById($input['b'][0]['id'], $input['b'][0]);
        if ($content) $content = ARTICLES::updateById($input['b'][1]['id'], $input['b'][1]);
        if (!$content)
            return response() -> json(['success' => False, 'message' => 'News not found.'], 404);
        return response() -> json(['success' => True, 'message' => $input, 'token' => $token], 200);
    });

    Route::get('/{id}',function ($id){
        $content = SESSIONS::getElementById($id);
        if (!$content)
            return response() -> json(['success' => False, 'message' => 'Competition not found.'], 404);
        return response() -> json(['success' => True, 'message' => '', 'data' => $content[0]], 200);
    });
    
    Route::put('/{id}',function ($id){
        $input = request() -> all();
        $token = ADMIN::checkToken($input);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        $content = ARTICLES::updateById($id, $input);
        if (!$content)
            return response() -> json(['success' => False, 'message' => 'Competition not found.'], 404);
        return response() -> json(['success' => True, 'message' => '', 'data' => $content[0]], 200);
    });
});


Route::prefix('judges')->group(function () {
    Route::get('/list/{cid}',function ($cid){
        $row = JUDGES::getListbyCID($cid);
        foreach ($row as &$value) {
            // $value->date = '<span class="date-convert">' . $value->date . '</span>';
            // $value->end_at = '<span class="date-convert">' . $value->end_at . '</span>';
            // $value->operate = '<button type="button" class="btn btn-info edit-btn" style="margin:0" data-id="'.$value->id.'"><i class="far fa-solid fa-gears"></i></button>';
            // $value->operate .= '<button type="button" class="btn btn-danger delete-btn" style="margin:0" data-id="'.$value->id.'"><i class="far fa-solid fa-trash-can"></i></button>';
        }
        return response() -> json(['success' => True, 'message' => '','data' => $row], 200);
    });

    Route::get('/{id}',function ($id){
        $content = SESSIONS::getElementById($id);
        if (!$content)
            return response() -> json(['success' => False, 'message' => 'Competition not found.'], 404);
        return response() -> json(['success' => True, 'message' => '', 'data' => $content[0]], 200);
    });
    
    Route::post('/create',function (){
        $input = request() -> all();
        $token = ADMIN::checkToken($input);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        $required = array('mid', 'cid');
        if (count(array_intersect_key(array_flip($required), $input)) != count($required))
            return response() -> json(['success' => False, 'message' => 'Missing required column.'], 400);    
        $row = JUDGES::store($input);
        if (!$row)
            return response() -> json(['success' => False, 'message' => 'Member already joined', 'token' => $token], 400);
        return response() -> json(['success' => True, 'message' => $row, 'token' => $token], 200);
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
    
    // Route::delete('/{id}/{token}',function ($id, $token){
    //     $token = ADMIN::validToken($token);
    //     if(!$token)
    //         return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
    //     $row = ADS::deleteById($id);
    //     if (!$row)
    //         return response() -> json(['success' => False, 'message' => 'Banner not found.'], 200);
    //     return response() -> json(['success' => True, 'message' => '', 'token' => $token], 200);
    // });
});