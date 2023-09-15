<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Session;

class SessionController extends Controller
{
    // List Sessions
    public function index()
    {
        return Session::all();
    }

    // Get a Single Session
    public function show($id)
    {
        return Session::find($id);
    }

    // Create a New Session
    public function store(Request $request)
    {
        return Session::create($request->all());
    }

    // Update a Session
    public function update(Request $request, $id)
    {
        $session = Session::findOrFail($id);
        $session->update($request->all());
        return $session;
    }

    // Delete a Session
    public function destroy($id)
    {
        $session = Session::findOrFail($id);
        $session->delete();
        return 204; // No content
    }
}
