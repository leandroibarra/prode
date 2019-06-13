@extends('layouts.game')

@section('content')
<div class="subNavWrapper">
    <div class="container px-0">
        <ul class="subNavContent mb-0 px-0">
            <li>
                <a href="javascript:void(0);">{{ $aCompetition['name'] }}</a>
            </li>
            <li class="activePage">
                <a href="javascript:void(0);">{{ __('game.match_prediction_legend', ['home'=>$aMatchSchedule['home_team']['name'], 'away'=>$aMatchSchedule['away_team']['name']]) }}</a>
            </li>
        </ul>
    </div>
</div>

<div class="row justify-content-center mx-auto py-4">
    <div class="col-10">

        @include('flash::message')

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('match-prediction.update', ['iCOmpetitionId'=>request()->route()->iCompetitionId, 'iMatchId'=>$aMatchSchedule['id']]) }}">
            @csrf

            <input type="hidden" name="match_prediction_id" value="{{ $aMatchPrediction['id'] }}" />

            <div class="form-group row mb-0">
                <div class="col-3 col-lg-5 text-right my-auto">
                    <input type="radio" name="result" value="home" {{ ($aMatchPrediction['result']=='home') ? 'checked' : '' }} />
                </div>
                <div class="col-3 col-lg-2 text-center">
                    <img src="{{ asset('images/flags/'.((!is_null($aMatchSchedule['home_team_id']))?$aMatchSchedule['home_team']['code']:'unknown').'.png') }}" class="border-0" />
                </div>
                <div class="col-6 col-lg-5 text-left my-auto">{{ $aMatchSchedule['home_team']['name'] }}</div>
            </div>
            @if ($aMatchSchedule['instance_id'] == 1)
            <div class="form-group row mb-0">
                <div class="col-3 col-lg-5 text-right my-auto">
                    <input type="radio" name="result" value="draw" {{ ($aMatchPrediction['result']=='draw') ? 'checked' : '' }} />
                </div>
                <div class="col-3 col-lg-2 text-center">
                    <img src="{{ asset('images/icons/draw.png') }}" class="border-0" />
                </div>
                <div class="col-6 col-lg-5 text-left my-auto">{{ ucfirst(__('game.result.draw')) }}</div>
            </div>
            @endif
            <div class="form-group row mb-0">
                <div class="col-3 col-lg-5 text-right my-auto">
                    <input type="radio" name="result" value="away" {{ ($aMatchPrediction['result']=='away') ? 'checked' : '' }} />
                </div>
                <div class="col-3 col-lg-2 text-center">
                    <img src="{{ asset('images/flags/'.((!is_null($aMatchSchedule['away_team_id']))?$aMatchSchedule['away_team']['code']:'unknown').'.png') }}" class="border-0" />
                </div>
                <div class="col-6 col-lg-5 text-left my-auto">{{ $aMatchSchedule['away_team']['name'] }}</div>
            </div>
            <div class="form-row mt-4">
                <div class="col-12 col-lg-6 mb-2 mb-lg-0">
                    <button type="button" name="cancel" id="cancel" class="btn btn-secondary btn-block" onclick="window.location='{{ route('dashboard.index', ['iCompetitionId'=>$aCompetition['id']]) }}'">{{ __('Cancel')  }}</button>
                </div>
                <div class="col-12 col-lg-6">
                    <button type="submit" name="submit" id="submit" class="btn btn-primary btn-block">{{ __('Save') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection