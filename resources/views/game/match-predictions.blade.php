@extends('layouts.game')

@section('content')
<div class="subNavWrapper">
    <div class="container px-0">
        <ul class="subNavContent mb-0 px-0">
            <li>
                <a href="javascript:void(0);">{{ $aCompetition['name'] }}</a>
            </li>
            <li class="activePage">
                <a href="javascript:void(0);">{{ __('game.match_predictions_legend', ['home'=>$aMatchSchedule['home_team']['name'], 'away'=>$aMatchSchedule['away_team']['name']]) }}</a>
            </li>
        </ul>
    </div>
</div>

<div class="row justify-content-center mx-auto py-4">
    <div class="col-10">

        @if (count($aMatchPredictions) > 0)
        <ul class="list-group viewPredictionsContent">
            @foreach ($aMatchPredictions as $iKey=>$aMatchPrediction)
            <li class="list-group-item py-2">
                <div class="row">
                    <div class="col-12 col-md-5 text-left font-weight-bold my-auto viewPredictionUser">{{ $aMatchPrediction['sUserName'] }}</div>
                    @php
                    $sText = __('None');
                    $sClass = 'muted';

                    if ((bool) $aMatchPrediction['user_prediction']) {
                        if ($aMatchSchedule['final_result'] == $aMatchPrediction['user_prediction']['result']) {
                            $sText = __('Hit');
                            $sClass = 'success';
                        } else if ($aMatchSchedule['final_result'] != $aMatchPrediction['user_prediction']['result']) {
                            $sText = __('Miss');
                            $sClass = 'danger';
                        }
                    }
                    @endphp
                    <div class="col-6 col-md-4">
                        <div class="float-left w-50 my-auto" title="{{ $sText }}">
                            <small class="clearfix">{{ __('Prediction') }}:</small>
                            <span class="font-weight-bold text-{{ $sClass }} viewPredictionPrediction">{{ ((bool) $aMatchPrediction['user_prediction']) ? ucfirst(__('game.result.'.$aMatchPrediction['user_prediction']['result'])) : $sText }}</span>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="float-left w-50 my-auto">
                            <small class="clearfix">{{ __('Result') }}:</small>
                            <span class="font-weight-bold viewPredictionFinalResult">{{ ucfirst(__('game.result.'.$aMatchSchedule['final_result'])) }}</span>
                        </div>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
        @else
        <div class="alert alert-warning text-center">{{ __('There were no predictions') }}</div>
        @endif
    </div>
</div>
@endsection