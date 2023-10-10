<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Models\Users;
use App\Models\News;
use App\Models\Competition;
use App\Models\Competition_log;
use App\Models\Competition_session;

use App\Mail\signupConfirmation;

class UserController extends Controller
{
    public function getInfo(Request $request)
    {
        $content = Users::getInfo($request->all());
        return response()->json(['success' => true, 'message' => '', 'data' => $content], 200);
    }

    public function signup(Request $request)
    {
        $val = Users::signup($request->all());
        if ($val) {
            return response()->json(['success' => false, 'error' => $val], 400);
        }
        
        $details = [
            'title' => '第二届「亚洲思辨写作对抗赛」 报名成功',
            'body' => '恭喜您已第二届「亚洲思辨写作对抗赛」，组委会将后续与您联络比赛的具体事宜，请耐心等待赛事安排通知。'
        ];
       
        Mail::to($request->email)->send(new signupConfirmation($details));
       
        
        return response()->json(['success' => true], 200);
    }

    public function getSignupList(Request $request)
    {
        $lst = Users::getSignupLst($request->all());
        return response()->json(['success' => true, 'data' => $lst], 200);
    }

    public function getSignupById($id)
    {
        $lst = Users::getSignupById($id);
        return response()->json(['success' => true, 'data' => $lst], 200);
    }

    public function signUpApproval($id)
    {
        $lst = Users::signUpApprove($id);
        return response()->json(['success' => true, 'data' => $lst], 200);
    }

    public function getToken(Request $request)
    {
        $token = $request->header('token');
        $token = Users::validToken($token);
        if (!$token) {
            return response()->json(['success' => false, 'message' => 'Invalid Token'], 403);
        }

        $val = Users::getId($token);
        return response()->json(['success' => true, 'id' => $val, 'token' => $token], 200);
    }

    public function login(Request $request)
    {
        $input = $request->all();
        $required = ['account', 'password'];
        if (count(array_intersect_key(array_flip($required), $input)) != count($required)) {
            return response()->json(['success' => false, 'message' => 'Missing required column.'], 400);
        }

        $id = Users::getLogin($input);
        if (!$id) {
            return response()->json(['success' => false, 'message' => 'Wrong account or password'], 403);
        }

        $content = Users::find($id);
        $token = Users::genToken($input['account']);
        $content->token = $token;
        $content->timestamps = true;
        $content->save();

        $url = '/';
        if ($content->authority == 7) {
            $url = '/admin';
        } elseif ($content->authority == 1) {
            $url = '/candidate';
        } elseif ($content->authority == 2) {
            $url = '/judge';
        }

        return response()->json(['success' => true, 'message' => $token, 'url' => $url], 200);
    }

    public function getCandidatesList()
    {
        $content = Users::getElementByRole(1);
        return response()->json(['success' => true, 'message' => '', 'data' => $content], 200);
    }

    public function getJudgesList()
    {
        $content = Users::getElementByRole(2);
        if (!$content) {
            return response()->json(['success' => false, 'message' => 'Judges not found.'], 404);
        }
        return response()->json(['success' => true, 'message' => '', 'data' => $content], 200);
    }

    public function getUserById($id)
    {
        $content = Users::getElementById($id);
        if (!$content) {
            return response()->json(['success' => false, 'message' => 'User not found.'], 404);
        }
        return response()->json(['success' => true, 'message' => '', 'data' => $content], 200);
    }

    public function createUser(Request $request)
    {
        $input = $request->all();
        $token = $request->header('token');
        $token = Users::validToken($token);
        if (!$token) {
            return response()->json(['success' => false, 'message' => 'Invalid Token'], 403);
        }

        $required = ['title', 'content'];
        if (count(array_intersect_key(array_flip($required), $input)) != count($required)) {
            return response()->json(['success' => false, 'message' => 'Missing required column.'], 400);
        }

        $row = News::store($input);
        return response()->json(['success' => true, 'message' => $row, 'token' => $token], 200);
    }

    public function updateUser(Request $request, $id)
    {
        $token = $request->header('token');
        $token = Users::validToken($token);
        if (!$token) {
            return response()->json(['success' => false, 'message' => 'Invalid Token'], 403);
        }

        $input = $request->all();
        $content = Users::updateById($id, $input);
        if (!$content) {
            return response()->json(['success' => false, 'message' => 'User not found.'], 404);
        }

        return response()->json(['success' => true, 'message' => '', 'token' => $token], 200);
    }

    public function deleteUser(Request $request, $id)
    {
        $token = $request->header('token');
        $token = Users::validToken($token);
        if (!$token) {
            return response()->json(['success' => false, 'message' => 'Invalid Token'], 403);
        }

        $content = Users::deleteById($id);
        if (!$content) {
            return response()->json(['success' => false, 'message' => 'User cannot be deleted.'], 404);
        }

        return response()->json(['success' => true, 'message' => '', 'token' => $token], 200);
    }

    public function lockUser(Request $request, $id)
    {
        $token = $request->header('token');
        $token = Users::validToken($token);
        if (!$token) {
            return response()->json(['success' => false, 'message' => 'Invalid Token'], 403);
        }

        $content = Users::lockById($id);
        if (!$content) {
            return response()->json(['success' => false, 'message' => 'User not found.'], 404);
        }

        return response()->json(['success' => true, 'message' => '', 'token' => $token], 200);
    }
}
