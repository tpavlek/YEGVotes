<?php

get('/', 'Overview@show')->name('home.index');
get('/about', 'Overview@about')->name('about');
get('/meetings', 'Meetings@listMeetings')->name('meetings.list');
get('/meetings/{meeting_id}', 'Meetings@show')->name('meetings.show');
get('/motions/{motion_id}', 'Motions@show')->name('motion.show');

get('/agenda/{agenda_item_id}', 'AgendaItems@show')->name('agenda_item.show');
get('/councillor/{council_member}', 'Councillors@show')->name('councillor.show');
get('councillor/{council_member}/no_votes', 'Councillors@noVotes')->name('councillor.no_votes');
