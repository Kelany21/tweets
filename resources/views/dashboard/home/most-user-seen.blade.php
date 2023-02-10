<div class="card card-custom bg-warning">
    <div class="card-header border-0">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon-users-1 text-white"></i>
            </span>
            <h3 class="card-label text-white">
                {{ trans('admin.most_user_have_seen_tweets') }}
            </h3>
        </div>
    </div>
    <div class="separator separator-solid separator-white opacity-20"></div>
    <div class="card-body text-white">
        <div class="d-flex align-items-center row">
            <div class="symbol symbol-150 symbol-light-warning flex-shrink-0 col-md-6">
                @if($mostUser->picture)
                <img class="" src="{{ $mostUser->picture }}" style="margin: auto" alt="photo">
                @else
                <span class="symbol-label font-weight-bold" style="font-size: 100px !important; margin: auto">{{ substr($mostUser->name, 0, 1) }}</span>
                @endif
            </div>
            <div class="col-md-6">
                <div class="font-weight-bolder font-size-lg mb-9 text-white">{{ $mostUser->name }}</div>
                <div class="font-weight-bolder font-size-lg mb-9 text-white">{{ $mostUser->email }}</div>
                <div class="font-weight-bolder font-size-lg mb-9 text-white">{{ trans("admin.tweets_count") . ': ' . count($mostUser->tweets) }}</div>
                <div class="font-weight-bolder font-size-lg mb-9 text-white">{{ trans("admin.seen_count") . ': ' . $mostUser->seenCount }}</div>
            </div>
        </div>
    </div>
</div>
