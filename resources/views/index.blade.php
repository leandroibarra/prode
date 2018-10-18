@extends('layouts.app')

@section('content')
<div class="text-center" style="margin:0 auto; max-width:71rem;">
    <h1 class="">Welcome to Prode.</h1>
    <h4 class="mb-4">The game of result predictions of FIFA World Cup 2018.</h4>
    <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-6">
            <div class="w-75 m-auto">
                <img src="{{ asset('images/icons/score.png') }}" border="0" class="mb-1" />
                <p>You can select or change the result until before the start time of the match between home, draw, or away.</p>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-6">
            <div class="w-75 m-auto">
                <img src="{{ asset('images/icons/award.png') }}" border="0" class="mb-1" />
                <p>If you hit the result, you win 1 point in group phase, 4 points in round of 16, 6 points in quarter-finals, 8 points in semi-finals, and 10 points in play-off for third place and final.</p>
            </div>
        </div>
    </div>
</div>
@endsection
