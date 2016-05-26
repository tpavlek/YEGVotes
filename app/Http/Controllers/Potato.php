<?php

namespace Depotwarehouse\YEGVotes\Http\Controllers;

use Depotwarehouse\YEGVotes\Model\Potato\PotatoVote;
use Illuminate\Http\Request;

class Potato extends Controller
{

    /**
     * @var PotatoVote
     */
    private $potatoModel;

    public function __construct(PotatoVote $potatoModel)
    {

        $this->potatoModel = $potatoModel;
    }

    public function show(Request $request)
    {
        $vote = $this->potatoModel->newQuery()->where([ 'ip' => $request->ip() ])->first();
        $agreement = ($vote !== null) ? $this->potatoModel->sum($vote->vote) : null;
        return view('potato.show')->with('vote', $vote)->with('agreement', $agreement);
    }

    public function vote(Request $request)
    {
        $vote = $request->get('vote');
        $ip = $request->ip();

        $model = $this->potatoModel->newQuery()->firstOrNew([ 'ip' => $ip ]);
        $model->vote = $vote;
        $model->save();

        return $this->votes($request);
    }

    public function votes(Request $request)
    {
        $for = $request->get('vote');
        return response()->json([ $for => $this->potatoModel->sum($for) ]);
    }
    
}
