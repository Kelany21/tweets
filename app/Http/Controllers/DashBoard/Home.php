<?php

namespace App\Http\Controllers\DashBoard;

use App\Models\Group;
use App\Models\Tweet;
use App\Models\User;
use Illuminate\Support\Arr;

/**
 * Class Groups
 * @package App\Http\Controllers\Dashboard
 */
class Home extends BackEnd
{

    protected $createBtn = false;

    /**
     * @var string
     */
    protected $moduleIcon = 'flaticon-pie-chart';

    protected $haveModel = false;

    /**
     * @param array $array
     * @return array
     */
    protected function appendToIndex($array = [])
    {
        $statuses = [
            [
                'color' => 'success',
                'label' => 'all_users',
                'module' => 'users',
                'icon' => 'flaticon-users-1',
                'count' => User::count(),
            ],
            [
                'color' => 'danger',
                'label' => 'deleted_users',
                'module' => 'users',
                'icon' => 'flaticon-users-1',
                'count' => User::onlyTrashed()->count(),
            ],
            [
                'color' => 'success',
                'label' => 'all_groups',
                'module' => 'groups',
                'icon' => 'flaticon2-group',
                'count' => Group::count(),
            ],
            [
                'color' => 'danger',
                'label' => 'deleted_groups',
                'module' => 'groups',
                'icon' => 'flaticon2-group',
                'count' => Group::onlyTrashed()->count(),
            ],
            [
                'color' => 'success',
                'label' => 'all_tweets',
                'module' => 'tweets',
                'icon' => 'flaticon-twitter-logo',
                'count' => Tweet::count(),
            ],
            [
                'color' => 'danger',
                'label' => 'deleted_tweets',
                'module' => 'tweets',
                'icon' => 'flaticon-twitter-logo',
                'count' => Tweet::onlyTrashed()->count(),
            ],
        ];
        $users = User::with('tweets.seenUsers')->get();
        $mostUser = null;
        $mostUserCount = 0;
        foreach ($users as $user)
        {
            $user->seenCount = count(Arr::collapse(Arr::pluck($user->tweets, 'seenUsers')));
            if ($mostUserCount < $user->seenCount)
            {
                $mostUserCount = $user->seenCount;
                $mostUser = $user;
            }
        }
        $tweets = Tweet::with('seenUsers')->get();
        $mostTweet = null;
        $mostTweetCount = 0;
        foreach ($tweets as $tweet)
        {
            $tweet->seenCount = count($tweet->seenUsers);
            if ($mostTweetCount < $tweet->seenCount)
            {
                $mostTweetCount = $tweet->seenCount;
                $mostTweet = $tweet;
            }
        }
        return [
            'statuses' => $statuses,
            'mostUser' => $mostUser,
            'mostTweet' => $mostTweet,
        ];
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function FileManager()
    {
        return $this->view('dashboard.home.file-manager', 'file-manager');
    }
}
