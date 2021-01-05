<?php

namespace App\Http\Controllers;

use App\Issue;
use Illuminate\Http\Request;
use App\Property;
use App\User;
use Session;
use Auth;
use DB;

class IssueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $property = Property::findOrFail(Session::get('property_id'));

         $issues = DB::table('issues')
        ->join('users', 'user_id_foreign', 'id')
        ->select('*', 'issues.status as issue_status')
        ->orderBy('issues.created_at', 'desc')->get();

        return view('webapp.properties.issues',compact('property', 'issues'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'details' => 'required'
        ]);

        $issue = new Issue();
        $issue->user_id_foreign = Auth::user()->id;
        $issue->reported_by = Auth::user()->name;
        $issue->details = $request->details;
        $issue->status = 'active';
        $issue->save();

        return back()->with('success', 'new issue has been posted!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function show($property_id, $issue_id)
    {
        $issue = Issue::findOrFail($issue_id);

        $responses = DB::table('issue_responses')
        ->join('issues', 'issues.issue_id', 'issue_responses.issue_id')
        ->join('users', 'issue_responses.user_id', 'users.id')
        ->select('*', 'issue_responses.created_at as responded_at')
        ->where('issue_responses.issue_id', $issue_id)
        ->orderBy('issue_responses.created_at', 'desc')
        ->get();

        return view('webapp.properties.show_issues', compact('issue', 'responses'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function edit(Issue $issue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Issue $issue)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Issue $issue)
    {
        //
    }
}
