<?php

namespace Depotwarehouse\YEGVotes\Http\Controllers;

use Carbon\Carbon;
use Depotwarehouse\Toolbox\DataManagement\Validation\ValidationException;
use Depotwarehouse\YEGVotes\Commands\CreatePostableCommand;
use Depotwarehouse\YEGVotes\Model\Election\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

class Postable extends Controller
{

    public function submit(Candidate $candidates)
    {
        $all_candidates = $candidates->all();
        return view('postable.submit')
            ->with('candidates', $all_candidates);
    }

    public function store(Request $input, CreatePostableCommand $createPostableCommand)
    {
        try {
            $createPostableCommand->handle($input->get('postable_type'), $input->get('content'), $input->get('candidates'));

            return redirect()->route('elections.feed', 'ward12')->withErrors(new MessageBag([
                'success' => "Your update has been submitted for moderation"
            ]));
        } catch (ValidationException $exception) {
            return redirect()->route('postable.submit')->withErrors($exception->get())->withInput();
        }
    }

    public function approve($id, Request $input)
    {
        $type = $input->get('type');

        \DB::table('election_postable_content')
            ->where('postable_type', '=', $type)
            ->where('postable_id', '=', $id)
            ->update([ 'approved_at' => Carbon::now()->toDateTimeString() ]);

        return redirect()->route('admin.dashboard')->withErrors(new MessageBag([
            'success' => "Successfully approved"
        ]));
    }

    public function deny($id, Request $input)
    {
        $type = $input->get('type');

        \DB::table('election_postable_content')
            ->where('postable_type', '=', $type)
            ->where('postable_id', '=', $id)
            ->update([ 'rejected_at' => Carbon::now()->toDateTimeString() ]);

        return redirect()->route('admin.dashboard')->withErrors(new MessageBag([
            'success' => "Successfully denied update"
        ]));
    }

}
