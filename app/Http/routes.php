<?php

get('/', 'Councillors@index');
get('/meetings', 'Meetings@listMeetings')->name('meetings.list');
get('/meetings/{meeting_id}', 'Meetings@show')->name('meetings.show');
get('/motions/{motion_id}', 'Motions@show')->name('motion.show');

get('/agenda/{agenda_item_id}', 'AgendaItems@show')->name('agenda_item.show');
