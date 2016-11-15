<?php

Route::get('/', 'Overview@show')->name('home.index');
Route::get('/about', 'Overview@about')->name('about');
Route::get('/stats', 'Stats@show')->name('stats');
Route::get('/movers', 'Stats@movers')->name('stats.movers');
Route::get('/private', 'Stats@inPrivate')->name('stats.private');
Route::get('/meetings', 'Meetings@listMeetings')->name('meetings.list');
Route::get('/meetings/{meeting_id}', 'Meetings@show')->name('meetings.show');
Route::get('/motions/{motion_id}', 'Motions@show')->name('motion.show');

Route::get('/embed/about/attendance', 'Embed@attendanceInfo')->name('embed.about.attendance');
Route::get('/embed/agenda_item/{agendaItem}', 'Embed@agendaItem')->name('embed.agenda_item');

Route::get('/agenda/{agenda_item_id}', 'AgendaItems@show')->name('agenda_item.show');
Route::get('/councillor/{councillor}', 'Councillors@show')->name('councillor.show');
Route::get('councillor/{councillor}/no_votes', 'Councillors@noVotes')->name('councillor.no_votes');

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
Route::post('postable/{id}/deny', 'Postable@deny')->name('postable.deny');

Route::get('potato', 'Potato@show')->name('potato');
Route::post('potato/vote', 'Potato@vote')->name('potato.vote');

Route::get('search/{term}', 'Search@search')->name('search');
