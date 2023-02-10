<div class="card card-custom bg-primary">
    <div class="card-header border-0">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon-twitter-logo text-white"></i>
            </span>
            <h3 class="card-label text-white">
                {{ trans('admin.most_tweet_have_sees') }}
            </h3>
        </div>
    </div>
    <div class="separator separator-solid separator-white opacity-20"></div>
    <div class="card-body text-white">
        <p style="text-align: justify">{{ $mostTweet->text }}</p>
        <div class="separator separator-solid separator-white opacity-20"></div>
        <div>
            <div class="row mt-9" style="margin: 0 auto">
                <div class="font-weight-bolder ml-9 mr-18 font-size-lg text-white">{{ trans("admin.created_at") . ': ' . $mostTweet->created_at }} </div>
                <div class="font-weight-bolder mr-18 font-size-lg text-white">{{ trans("admin.update_count") . ': ' . $mostTweet->update_count }} </div>
                <div class="font-weight-bolder font-size-lg text-white">{{ trans("admin.seen_count") . ': ' . $mostTweet->seenCount }} </div>
            </div>
        </div>
    </div>
</div>
