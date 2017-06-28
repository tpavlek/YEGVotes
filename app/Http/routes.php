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

Route::get('election', function() { return redirect()->route('elections.2017'); });
Route::get('elections/2017', 'Elections@general2017')->name('elections.2017');
Route::get('elections/ward12', 'Elections@ward12')->name('elections.ward12');
Route::get('/ward-finder', 'Elections@wardFinder')->name('wardfinder');

Route::get('potato', 'Potato@show')->name('potato');

Route::get('search/{term}', 'Search@search')->name('search');

Route::get('speakers', 'Speakers@index')->name('stats.speakers');
Route::get('speakers/list', 'Speakers@fullList')->name('speakers.list');
Route::get('speaker/{speaker}', 'Speakers@show')->name('speakers.show');
