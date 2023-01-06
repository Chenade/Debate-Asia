<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Models\Board_Leader;
use App\Models\News; //1
use App\Models\Banner;  //2
use App\Models\Ads;  //3
use App\Models\N8;  //4
use App\Models\FAQ;  //5
use App\Models\Course;  //6
use App\Models\Peter;  //7
use App\Models\Media;  //8
use App\Models\Activity;
use App\Models\PostImage;
use App\Models\Admin;
use App\Models\Teams;
use App\Models\Promo;
use App\Models\users;

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
    Route::get('/index',function (){
        $row = NEWS::getindexList();
        foreach ($row as &$value) {
            // $value->content = str_replace("'", '"', trim($value->content, "\\\""));
            // $value->content = json_decode($value->content, true);
            $value->images = PostImage::getList(1, $value->id);
        }
        return response() -> json(['success' => True, 'message' => '','data' => $row], 200);
    });
    
    Route::get('/list',function (){
        $row = NEWS::getList();
        foreach ($row as &$value) {
            // $value->content = str_replace("'", '"', trim($value->content, "\\\""));
            // $value->content = json_decode($value->content, true);
            $value->images = PostImage::getList(1, $value->id);
        }
        return response() -> json(['success' => True, 'message' => '','data' => $row], 200);
    });

    Route::get('/adminlist',function (){
        $row = USERS::getList();
        foreach ($row as &$value) {
            $value->school = $value->school_cn . $value->school_zh;
            $value->name = $value->name_cn . $value->name_zh;
            // $value->content = json_decode($value->content, true);
            // $value->start_at = '<span class="date-convert">' . $value->start_at . '</span>';
            // $value->end_at = '<span class="date-convert">' . $value->end_at . '</span>';
            // $value->operate = '<button type="button" class="btn btn-info edit-btn" style="margin:0" data-id="'.$value->id.'"><i class="far fa-solid fa-gears"></i></button>';
            // $value->operate .= '<button type="button" class="btn btn-danger delete-btn" style="margin:0" data-id="'.$value->id.'"><i class="far fa-solid fa-trash-can"></i></button>';
        }
        return response() -> json(['success' => True, 'message' => '','data' => $row], 200);
    });

    Route::get('/{id}',function ($id){
        $content = NEWS::getElementById($id);
        if (!$content)
            return response() -> json(['success' => False, 'message' => 'News not found.'], 404);
        $content[0]->images = PostImage::getList(1, $id);
        return response() -> json(['success' => True, 'message' => '', 'data' => $content[0]], 200);
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
        $content = NEWS::updateById($id, $input);
        if (!$content)
            return response() -> json(['success' => False, 'message' => 'News not found.'], 404);
        return response() -> json(['success' => True, 'message' => '', 'token' => $token], 200);
    });
    
    Route::delete('/{id}/{token}',function ($id, $token){
        $token = ADMIN::validToken($token);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        $row = NEWS::deleteById($id);
        if (!$row)
            return response() -> json(['success' => False, 'message' => 'News not found.'], 200);
        return response() -> json(['success' => True, 'message' => '', 'token' => $token], 200);
    });

    Route::post('/{id}/uploadThumbnail', function(Request $request, $id){
        $token = ADMIN::validToken(request() -> token);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        
        $content = NEWS::uploadThumbnail($request, $id);
        // $filename = PostImage::store($request, $category, $id);
        if (!$content)
            return response() -> json(['success' => False, 'message' => 'Image upload failed'], 400);
        return response() -> json(['success' => True, 'message' => '', 'token' => $token], 200);
    });
});

Route::prefix('ads')->group(function () {
    Route::get('/list',function (){
        $row = ADS::getList();
        foreach ($row as &$value) {
            $value->image = PostImage::getList(3, $value->id);
        }
        return response() -> json(['success' => True, 'message' => '','data' => $row], 200);
    });

    Route::get('/adminlist',function (){
        $row = ADS::getList();
        foreach ($row as &$value) {
            $value->start_at = '<span class="date-convert">' . $value->start_at . '</span>';
            $value->end_at = '<span class="date-convert">' . $value->end_at . '</span>';
            $value->operate = '<button type="button" class="btn btn-info edit-btn" style="margin:0" data-id="'.$value->id.'"><i class="far fa-solid fa-gears"></i></button>';
            $value->operate .= '<button type="button" class="btn btn-danger delete-btn" style="margin:0" data-id="'.$value->id.'"><i class="far fa-solid fa-trash-can"></i></button>';
        }
        return response() -> json(['success' => True, 'message' => '','data' => $row], 200);
    });

    Route::get('/{id}',function ($id){
        $content = ADS::getElementById($id);
        if (!$content)
            return response() -> json(['success' => False, 'message' => 'Ads not found.'], 404);
        $content[0]->image = PostImage::getList(2, $id);
        return response() -> json(['success' => True, 'message' => '', 'data' => $content[0]], 200);
    });
    
    Route::post('/create',function (){
        $input = request() -> all();
        $token = ADMIN::checkToken($input);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        $required = array('title', 'link');
        if (count(array_intersect_key(array_flip($required), $input)) != count($required))
            return response() -> json(['success' => False, 'message' => 'Missing required column.'], 400);    
        $row = ADS::store($input);
        return response() -> json(['success' => True, 'message' => '', 'token' => $token], 200);
    });
    
    Route::put('/{id}',function ($id){
        $input = request() -> all();
        $token = ADMIN::checkToken($input);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        $content = ADS::updateById($id, $input);
        if (!$content)
            return response() -> json(['success' => False, 'message' => 'News not found.'], 404);
        return response() -> json(['success' => True, 'message' => '', 'token' => $token], 200);
    });
    
    Route::delete('/{id}/{token}',function ($id, $token){
        $token = ADMIN::validToken($token);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        $row = ADS::deleteById($id);
        if (!$row)
            return response() -> json(['success' => False, 'message' => 'Banner not found.'], 200);
        return response() -> json(['success' => True, 'message' => '', 'token' => $token], 200);
    });
});

Route::prefix('banner')->group(function () {
    Route::get('/list',function (){
        $row = BANNER::getList();
        foreach ($row as &$value) {
            $value->image = PostImage::getList(2, $value->id);
        }
        return response() -> json(['success' => True, 'message' => '','data' => $row], 200);
    });

    Route::get('/adminlist',function (){
        $row = BANNER::getList();
        foreach ($row as &$value) {
            $value->start_at = '<span class="date-convert">' . $value->start_at . '</span>';
            $value->end_at = '<span class="date-convert">' . $value->end_at . '</span>';
            $value->operate = '<button type="button" class="btn btn-info edit-btn" style="margin:0" data-id="'.$value->id.'"><i class="far fa-solid fa-gears"></i></button>';
            $value->operate .= '<button type="button" class="btn btn-danger delete-btn" style="margin:0" data-id="'.$value->id.'"><i class="far fa-solid fa-trash-can"></i></button>';
        }
        return response() -> json(['success' => True, 'message' => '','data' => $row], 200);
    });

    Route::get('/{id}',function ($id){
        $content = BANNER::getElementById($id);
        if (!$content)
            return response() -> json(['success' => False, 'message' => 'Banner not found.'], 404);
        $content[0]->image = PostImage::getList(2, $id);
        return response() -> json(['success' => True, 'message' => '', 'data' => $content[0]], 200);
    });
    
    Route::post('/create',function (){
        $input = request() -> all();
        $token = ADMIN::checkToken($input);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        $required = array('title', 'link');
        if (count(array_intersect_key(array_flip($required), $input)) != count($required))
            return response() -> json(['success' => False, 'message' => 'Missing required column.'], 400);    
        $row = BANNER::store($input);
        return response() -> json(['success' => True, 'message' => '', 'token' => $token], 200);
    });
    
    Route::put('/{id}',function ($id){
        $input = request() -> all();
        $token = ADMIN::checkToken($input);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        $content = BANNER::updateById($id, $input);
        if (!$content)
            return response() -> json(['success' => False, 'message' => 'News not found.'], 404);
        return response() -> json(['success' => True, 'message' => '', 'token' => $token], 200);
    });
    
    Route::delete('/{id}/{token}',function ($id, $token){
        $token = ADMIN::validToken($token);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        $row = BANNER::deleteById($id);
        if (!$row)
            return response() -> json(['success' => False, 'message' => 'Banner not found.'], 200);
        return response() -> json(['success' => True, 'message' => '', 'token' => $token], 200);
    });
});

Route::prefix('n8')->group(function () {
    Route::get('/list',function (){
        $row = N8::getList();
        foreach ($row as &$value) {
            $value->images = PostImage::getList(4, $value->id);
        }
        return response() -> json(['success' => True, 'message' => '','data' => $row], 200);
    });

    Route::get('/adminlist',function (){
        $row = N8::getList();
        foreach ($row as &$value) {
            $value->operate = '<button type="button" class="btn btn-info edit-btn" style="margin:0" data-id="'.$value->id.'"><i class="far fa-solid fa-gears"></i></button>';
            $value->operate .= '<button type="button" class="btn btn-danger delete-btn" style="margin:0" data-id="'.$value->id.'"><i class="far fa-solid fa-trash-can"></i></button>';
        }
        return response() -> json(['success' => True, 'message' => '','data' => $row], 200);
    });

    Route::get('/{id}',function ($id){
        $content = N8::getElementById($id);
        if (!$content)
            return response() -> json(['success' => False, 'message' => 'Ads not found.'], 404);
        $content[0]->image = PostImage::getList(2, $id);
        return response() -> json(['success' => True, 'message' => '', 'data' => $content[0]], 200);
    });
    
    Route::post('/create',function (){
        $input = request() -> all();
        $token = ADMIN::checkToken($input);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        $required = array('title', 'link');
        if (count(array_intersect_key(array_flip($required), $input)) != count($required))
            return response() -> json(['success' => False, 'message' => 'Missing required column.'], 400);    
        $row = N8::store($input);
        return response() -> json(['success' => True, 'message' => '', 'token' => $token], 200);
    });
    
    Route::put('/{id}',function ($id){
        $input = request() -> all();
        $token = ADMIN::checkToken($input);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        $content = N8::updateById($id, $input);
        if (!$content)
            return response() -> json(['success' => False, 'message' => 'News not found.'], 404);
        return response() -> json(['success' => True, 'message' => '', 'token' => $token], 200);
    });
    
    Route::delete('/{id}/{token}',function ($id, $token){
        $token = ADMIN::validToken($token);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        $row = N8::deleteById($id);
        if (!$row)
            return response() -> json(['success' => False, 'message' => 'Natural 8 not found.'], 200);
        return response() -> json(['success' => True, 'message' => '', 'token' => $token], 200);
    });

    Route::post('/{id}/uploadThumbnail', function(Request $request, $id){
        $token = ADMIN::validToken(request() -> token);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        
        $content = N8::uploadThumbnail($request, $id);
        // $filename = PostImage::store($request, $category, $id);
        if (!$content)
            return response() -> json(['success' => False, 'message' => 'Image upload failed'], 400);
        return response() -> json(['success' => True, 'message' => '', 'token' => $token], 200);
    });
});

Route::prefix('faq')->group(function () {
    Route::get('/list',function (){
        $row = FAQ::getList();
        foreach ($row as &$value) {
            $value->image = PostImage::getList(3, $value->id);
        }
        return response() -> json(['success' => True, 'message' => '','data' => $row], 200);
    });

    Route::get('/adminlist',function (){
        $row = FAQ::getList();
        foreach ($row as &$value) {
            $value->operate = '<button type="button" class="btn btn-info edit-btn" style="margin:0" data-id="'.$value->id.'"><i class="far fa-solid fa-gears"></i></button>';
            $value->operate .= '<button type="button" class="btn btn-danger delete-btn" style="margin:0" data-id="'.$value->id.'"><i class="far fa-solid fa-trash-can"></i></button>';
        }
        return response() -> json(['success' => True, 'message' => '','data' => $row], 200);
    });

    Route::get('/{id}',function ($id){
        $content = FAQ::getElementById($id);
        if (!$content)
            return response() -> json(['success' => False, 'message' => 'Ads not found.'], 404);
        $content[0]->image = PostImage::getList(2, $id);
        return response() -> json(['success' => True, 'message' => '', 'data' => $content[0]], 200);
    });
    
    Route::post('/create',function (){
        $input = request() -> all();
        $token = ADMIN::checkToken($input);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        $required = array('question', 'answer');
        if (count(array_intersect_key(array_flip($required), $input)) != count($required))
            return response() -> json(['success' => False, 'message' => 'Missing required column.'], 400);    
        $row = FAQ::store($input);
        return response() -> json(['success' => True, 'message' => '', 'token' => $token], 200);
    });
    
    Route::put('/{id}',function ($id){
        $input = request() -> all();
        $token = ADMIN::checkToken($input);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        $content = FAQ::updateById($id, $input);
        if (!$content)
            return response() -> json(['success' => False, 'message' => 'News not found.'], 404);
        return response() -> json(['success' => True, 'message' => '', 'token' => $token], 200);
    });
    
    Route::delete('/{id}/{token}',function ($id, $token){
        $token = ADMIN::validToken($token);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        $row = FAQ::deleteById($id);
        if (!$row)
            return response() -> json(['success' => False, 'message' => 'Natural 8 not found.'], 200);
        return response() -> json(['success' => True, 'message' => '', 'token' => $token], 200);
    });
});

Route::prefix('courses')->group(function () {
    Route::get('/list',function (){
        $row = COURSE::getList();
        foreach ($row as &$value) {
            $value->image = PostImage::getList(6, $value->id);
        }
        return response() -> json(['success' => True, 'message' => '','data' => $row], 200);
    });

    Route::get('/adminlist',function (){
        $row = COURSE::getList();
        foreach ($row as &$value) {
            $value->operate = '<button type="button" class="btn btn-info edit-btn" style="margin:0" data-id="'.$value->id.'"><i class="far fa-solid fa-gears"></i></button>';
            $value->operate .= '<button type="button" class="btn btn-danger delete-btn" style="margin:0" data-id="'.$value->id.'"><i class="far fa-solid fa-trash-can"></i></button>';
        }
        return response() -> json(['success' => True, 'message' => '','data' => $row], 200);
    });

    Route::get('/{id}',function ($id){
        $content = COURSE::getElementById($id);
        if (!$content)
            return response() -> json(['success' => False, 'message' => 'Ads not found.'], 404);
        $content[0]->image = PostImage::getList(2, $id);
        return response() -> json(['success' => True, 'message' => '', 'data' => $content[0]], 200);
    });
    
    Route::post('/create',function (){
        $input = request() -> all();
        $token = ADMIN::checkToken($input);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        $required = array('title', 'content');
        if (count(array_intersect_key(array_flip($required), $input)) != count($required))
            return response() -> json(['success' => False, 'message' => 'Missing required column.'], 400);    
        $row = COURSE::store($input);
        return response() -> json(['success' => True, 'message' => '', 'token' => $token], 200);
    });
    
    Route::put('/{id}',function ($id){
        $input = request() -> all();
        $token = ADMIN::checkToken($input);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        $content = COURSE::updateById($id, $input);
        if (!$content)
            return response() -> json(['success' => False, 'message' => 'News not found.'], 404);
        return response() -> json(['success' => True, 'message' => '', 'token' => $token], 200);
    });
    
    Route::delete('/{id}/{token}',function ($id, $token){
        $token = ADMIN::validToken($token);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        $row = COURSE::deleteById($id);
        if (!$row)
            return response() -> json(['success' => False, 'message' => 'Natural 8 not found.'], 200);
        return response() -> json(['success' => True, 'message' => '', 'token' => $token], 200);
    });
});

Route::prefix('peter')->group(function () {
    Route::get('/',function (){
        $row = PETER::get();
        if($row)
        {
            $row->content = str_replace('\n', '$?', $row->content);
            $row->content = stripslashes($row->content);
            $row->content = str_replace('$?', '', $row->content);
            $row->images = PostImage::getList(7, $row->id);
        }
        return response() -> json(['success' => True, 'message' => '','data' => $row], 200);
    });

    Route::post('/',function (){
        $input = request() -> all();
        $token = ADMIN::checkToken($input);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        $content = PETER::updateContent($input);
        return response() -> json(['success' => True, 'message' => '', 'token' => $token], 200);
    });
});

Route::prefix('course')->group(function () {
    Route::get('/',function (){
        $row = COURSE::get();
        if ($row)
        {
            $row->content = str_replace('\n', '$?', $row->content);
            $row->content = stripslashes($row->content);
            $row->content = str_replace('$?', '', $row->content);
            $row->images = PostImage::getList(4, $row->id);
        }
        return response() -> json(['success' => True, 'message' => '','data' => $row], 200);
    });

    Route::post('/',function (){
        $input = request() -> all();
        $token = ADMIN::checkToken($input);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        $content = COURSE::updateContent($input);
        return response() -> json(['success' => True, 'message' => '', 'token' => $token], 200);
    });
});

Route::prefix('media')->group(function () {
    Route::get('/index',function (){
        $row = MEDIA::getindexList();
        foreach ($row as &$value) {
            // $value->content = str_replace("'", '"', trim($value->content, "\\\""));
            // $value->content = json_decode($value->content, true);
            // $value->images = PostImage::getList(8, $value->id);
        }
        return response() -> json(['success' => True, 'message' => '','data' => $row], 200);
    });
        
    Route::get('/list',function (){
        $row = MEDIA::getList();
        // foreach ($row as &$value) {
            // $value->content = str_replace("'", '"', trim($value->content, "\\\""));
            // $value->content = json_decode($value->content, true);
            // $value->images = PostImage::getList(1, $value->id);
        // }
        return response() -> json(['success' => True, 'message' => '','data' => $row], 200);
    });

    Route::get('/adminlist',function (){
        $row = MEDIA::getList();
        foreach ($row as &$value) {
            // $value->content = str_replace("'", '"', trim($value->content, "\\\""));
            // $value->content = json_decode($value->content, true);
            $value->type = '<span class="type-convert">' . $value->type . '</span>';
            $value->operate = '<button type="button" class="btn btn-info edit-btn" style="margin:0" data-id="'.$value->id.'"><i class="far fa-solid fa-gears"></i></button>';
            $value->operate .= '<button type="button" class="btn btn-danger delete-btn" style="margin:0" data-id="'.$value->id.'"><i class="far fa-solid fa-trash-can"></i></button>';
        }
        return response() -> json(['success' => True, 'message' => '','data' => $row], 200);
    });

    Route::get('/{id}',function ($id){
        $content = MEDIA::getElementById($id);
        if (!$content)
            return response() -> json(['success' => False, 'message' => 'News not found.'], 404);
        $content[0]->images = PostImage::getList(1, $id);
        return response() -> json(['success' => True, 'message' => '', 'data' => $content[0]], 200);
    });
    
    Route::post('/create',function (){
        $input = request() -> all();
        $token = ADMIN::checkToken($input);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        $required = array('type', 'link', 'content');
        if (count(array_intersect_key(array_flip($required), $input)) != count($required))
            return response() -> json(['success' => False, 'message' => 'Missing required column.'], 400);    
        $row = MEDIA::store($input);
        return response() -> json(['success' => True, 'message' => '', 'token' => $token], 200);
    });
    
    Route::put('/{id}',function ($id){
        $input = request() -> all();
        $token = ADMIN::checkToken($input);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        $content = MEDIA::updateById($id, $input);
        if (!$content)
            return response() -> json(['success' => False, 'message' => 'Media not found.'], 404);
        return response() -> json(['success' => True, 'message' => '', 'token' => $token], 200);
    });
    
    Route::delete('/{id}/{token}',function ($id, $token){
        $token = ADMIN::validToken($token);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        $row = MEDIA::deleteById($id);
        if (!$row)
            return response() -> json(['success' => False, 'message' => 'News not found.'], 200);
        return response() -> json(['success' => True, 'message' => '', 'token' => $token], 200);
    });

    Route::post('/{id}/uploadThumbnail', function(Request $request, $id){
        $token = ADMIN::validToken(request() -> token);
        if(!$token)
            return $response = response() -> json(['success' => False, 'message' => 'Invalid Token'], 403);
        $content = MEDIA::uploadThumbnail($request, $id);
        if (!$content)
            return response() -> json(['success' => False, 'message' => 'Image upload failed'], 400);
        return response() -> json(['success' => True, 'message' => '', 'token' => $token], 200);
    });
});