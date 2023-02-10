<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\Tweet;
use \Illuminate\Contracts\Foundation\Application;
use \Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use \Illuminate\View\View;

class HomeController extends FrontEndController
{

    /**
     * @return Application | Factory | View
     */
    public function index()
    {
        $toolBar = $this->toolBar;
        return view('website.home', compact('toolBar'));
    }

    /**
     * @return array
     */
    public function getTweets(): array
    {
        return [
            'tweets' => Tweet::with(['author', 'seenUsers' => function($query){
                return $query->where('users.id', auth()->id());
            }])->active()->orderBy('created_at', 'desc')->get(),
            'auth' => auth()->user(),
        ];
    }

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function storeTweets()
    {
        auth()->user()->tweets()->create(['text' => request()->get('text')]);
    }

    /**
     * @param $id
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function updateTweets($id)
    {
        auth()->user()->tweets()->where('id', $id)->increment('update_count', 1, ['text' => request()->get('text')]);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function seeTweet($id): JsonResponse
    {
        auth()->user()->seenTweets()->attach([$id]);
        return response()->json();
    }

}
