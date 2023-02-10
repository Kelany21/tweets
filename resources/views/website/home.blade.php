{{-- Extends layout --}}
@extends('layout.default')


@section('content')
    <div style="max-width: 40%; margin: auto" onload="loadTweets()">
        <form onsubmit="storeTweet()">
            <div class="card card-custom bg-primary">
                <div class="separator separator-solid separator-white opacity-20"></div>
                <div class="card-body text-white">
                    <div class="form-group mb-1">
                    <textarea style="resize: none;" class="form-control" rows="4" maxlength="280" id="tweet-text"
                              placeholder="{{ trans('website.what_you_are_thinking_about') }}"></textarea>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <button type="submit" class="btn btn-white">
                        <i class="flaticon-twitter-logo"></i> {{ trans('website.tweet') }}
                    </button>
                </div>
            </div>
        </form>
        <div class="timeline timeline-3" style="margin-top: 100px">
            <div class="timeline-items">
            </div>
        </div>
    </div>

    <div style="position: fixed; bottom: 0;right: 0" id="bottom-fixed"></div>

    {{-- Scripts Section --}}
@endsection

@section('scripts')
    <script>
        function trans(key){
            return @json(trans("website"))[key] ?? 'website.' + key
        }
        let tweetsIds = []
        function storeTweet(){
            $.ajax({
                url: '{{ url('/tweets') }}',
                method: 'post',
                data: {
                    text: $("#tweet-text").val(),
                    "_token": "{{ csrf_token() }}",
                },
                success: function(){
                    loadTweets()
                    $("#tweet-text").val('')
                }
            });
        }
        function updateTweet(id, textareaID){
            $("#" + textareaID + "_close").click()
            $.ajax({
                url: '{{ url('/tweets') }}/' + id,
                method: 'put',
                data: {
                    text: $("#" + textareaID + "_textarea").val(),
                    "_token": "{{ csrf_token() }}",
                },
                success: function(){
                    loadTweets()
                }
            });
        }
        function seeTweet(id){
            $.ajax({
                url: '{{ url('/tweets/see') }}/' + id,
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                complete: function(data, status){
                    if (status !== 'success') {
                        tweetsIds.push(id)
                    }
                }
            });
        }
        function loadTweets(_callback){
            $.ajax({
                url: '{{ url('/get-tweets') }}',
                method: 'get',
                success: function(data){
                    let childHtml = '';
                    for (const tweet of data.tweets) {
                        const ModalTitle = '{{ trans("website.edit_tweet") }}';
                        const ModalID = 'tweet_' + tweet.id;
                        const isAuthorTweet = data.auth.id === tweet.user_id
                        if (!isAuthorTweet && (!tweet.seen_users || !tweet.seen_users.length)){
                            tweetsIds.push(tweet.id)
                        }
                        childHtml += '<div class="timeline-item" id="' + tweet.id +'">' +
                            '<div class="timeline-media">' +
                            (tweet.author.picture ?
                                '<img alt="photo" src="' + tweet.author.picture + '" style="height: 100%"/>'
                                :
                                '<span class="symbol-label font-size-h4 font-weight-bold">' + tweet.author.name.charAt(0) + '</span>') +
                            '</div>' +
                            '<div class="timeline-content">' +
                            '<div class="d-flex align-items-center justify-content-between mb-3">' +
                            '<div class="mr-2">' +
                            '<a href="#" class="text-dark-75 text-hover-primary font-weight-bold">' +
                            tweet.author.name +
                            '</a>' +
                            '<span class="text-muted ml-2">' + dateRender(tweet.created_at, true) +'</span>' +
                            '</div>' +
                            (isAuthorTweet ?
                                '<div class="dropdown ml-2" data-toggle="tooltip" title="' + trans('quick_actions') + '" data-placement="left">' +
                                '<a href="#" class="btn btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" ' +
                                'aria-haspopup="true" aria-expanded="false">' +
                                '<i class="ki ki-more-hor font-size-lg text-primary"></i>' +
                                '</a>' +
                                '<div class="dropdown-menu p-0 m-0 dropdown-menu-md dropdown-menu-right">' +
                                '<ul class="navi navi-hover">' +
                                '<li class="navi-item">' +
                                '<a class="navi-link" data-toggle="modal"  data-target="#' + ModalID + '">' +
                                '<span class="navi-text">' + trans('edit') + '</span>' +
                                '</a>' +
                                '</li>' +
                                '</ul>' +
                                '</div>' +
                                '</div>'
                                : '') +
                            '</div>' +
                            '<p class="p-0">' + tweet.text + '</p>' +
                            '</div>' +
                            '</div>' +
                            (isAuthorTweet ?
                                '<form onsubmit="updateTweet(' + tweet.id + ', \'' + ModalID + '\')">' +
                                '<div class="modal fade" id="' + ModalID + '" data-backdrop="static" tabindex="-1" role="dialog" ' +
                                'aria-labelledby="staticBackdrop" aria-hidden="true">' +
                                '<div class="modal-dialog modal-dialog-centered" role="document">' +
                                '<div class="modal-content">' +
                                '<div class="modal-header">' +
                                '<h5 class="modal-title" id="' + ModalID + '_label">' + ModalTitle + '</h5>' +
                                '<button id="' + ModalID + '_close" type="button" class="close" data-dismiss="modal" aria-label="Close">' +
                                '<i aria-hidden="true" class="ki ki-close"></i>' +
                                '</button>' +
                                '</div>' +
                                '<div class="modal-body">' +
                                '<div class="form-group mb-1">' +
                                '<textarea style="resize: none;" class="form-control" rows="4" maxlength="280" ' +
                                'id="' + ModalID + '_textarea" placeholder="' + trans('what_you_are_thinking_about') + '">' + tweet.text + '</textarea>' +
                                '</div>' +
                                '</div>' +
                                '<div class="modal-footer">' +
                                '<button type="submit" class="btn btn-primary">' + trans('save') +'</button>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</form>'
                                : '') +
                            '\n';
                    }
                    $('.timeline-items').empty()
                    $('.timeline-items').append(
                        $(childHtml)
                    );
                    _callback()
                }
            });
        }
        function checkSeen(){
            console.log($( window ).height())
            const bottomFixedDiv = $('#bottom-fixed')
            const windowBottomOffest = bottomFixedDiv.offset().top + bottomFixedDiv.height()
            console.log(windowBottomOffest)
            console.log({tweetsIds})
            for (let i = 0; i < tweetsIds.length; i++) {
                const tweetId = tweetsIds[i]
                if (tweetId) {
                    console.log({i, tweetId})
                    const tweetDiv = $("#" + tweetId)
                    const tweetBottomOffest = tweetDiv.offset().top + tweetDiv.height()
                    if (tweetBottomOffest <= windowBottomOffest) {
                        delete tweetsIds[i]
                        seeTweet(tweetId)
                        console.log({seen: true, tweetId: tweetId})
                    }else {
                        console.log({seen: false, tweetId: tweetId})
                    }
                }
            }
        }
        $(document).ready(async function()
        {
            loadTweets(checkSeen)
            $(document).scroll(function()
            {
                checkSeen()
            });
        });
    </script>
@endsection
