<?php

namespace Depotwarehouse\YEGVotes\Http\Controllers;

use Depotwarehouse\YEGVotes\Model\Election\GetPostable;
use Depotwarehouse\YEGVotes\Model\Election\Tweet;
use Illuminate\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

class Admin extends Controller
{

    public function login()
    {
        return view('admin.login');
    }

    public function auth(Guard $auth, Request $input)
    {
        if ($input->get('password') !== env('ADMIN_PASSWORD')) {
            return redirect()->route('admin.login')->withErrors(new MessageBag([
                'errors' => 'Could not log in'
            ]));
        }

        $auth->loginUsingId(1);

        return redirect()->route('admin.dashboard');
    }

    public function logout(Guard $auth) {
        $auth->logout();

        return redirect()->route('home.index');
    }

    public function dashboard(GetPostable $getPostable)
    {
        $postables = $getPostable->getUnapproved();

        return view('admin.dashboard')
            ->with('postable_content', $postables);
    }

}
