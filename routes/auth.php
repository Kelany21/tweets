<?php
Route::get('/', 'HomeController@index');
Route::get('/get-tweets', 'HomeController@getTweets');
Route::post('/tweets', 'HomeController@storeTweets');
Route::put('/tweets/{id}', 'HomeController@updateTweets');
Route::post('/tweets/see/{id}', 'HomeController@seeTweet');
