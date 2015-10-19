<?php

get('/', 'Councillors@index');
get('/motions/{motion_id}', 'Motions@show')->name('motion.show');
