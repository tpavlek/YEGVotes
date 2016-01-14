<?php

get('/', 'Overview@show')->name('home.index');
get('/about', 'Overview@about')->name('about');
get('/stats', 'Stats@show')->name('stats');
get('/movers', 'Stats@movers')->name('stats.movers');
get('/meetings', 'Meetings@listMeetings')->name('meetings.list');
get('/meetings/{meeting_id}', 'Meetings@show')->name('meetings.show');
get('/motions/{motion_id}', 'Motions@show')->name('motion.show');

get('/agenda/{agenda_item_id}', 'AgendaItems@show')->name('agenda_item.show');
get('/councillor/{council_member}', 'Councillors@show')->name('councillor.show');
get('councillor/{council_member}/no_votes', 'Councillors@noVotes')->name('councillor.no_votes');

Route::get('elections/{id}', 'Elections@show')->name('elections.show');
Route::get('elections/{id}/feed', 'Elections@feed')->name('elections.feed');

Route::get('candidate/{name}', 'Candidates@show')->name('candidate.show');

Route::get('admin/login', 'Admin@login')->name('admin.login')->middleware('guest');
Route::post('admin/auth', 'Admin@auth')->name('admin.auth')->middleware('guest');
Route::get('admin/logout', 'Admin@logout')->name('admin.logout')->middleware('auth');
Route::get('admin/dashboard', 'Admin@dashboard')->name('admin.dashboard')->middleware('auth');

Route::get('elections/update/submit', 'Postable@submit')->name('postable.submit');
Route::post('elections/update/submit', 'Postable@store')->name('postable.store');
Route::post('postable/{id}/approve', 'Postable@approve')->name('postable.approve');
Route::Post('postable/{id}/deny', 'Postable@deny')->name('postable.deny');
