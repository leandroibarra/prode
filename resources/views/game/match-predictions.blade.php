@extends('layouts.game')

@section('content')
<div class="container">
    <h4 class="mb-4">Predictions of <span class="font-weight-bold">{{ $aMatchSchedule['home_team']['name'] }} vs {{ $aMatchSchedule['away_team']['name'] }}</span></h4>

    @if (count($aMatchPredictions) > 0)
    <ul class="list-group viewPredictionsContent">
        @foreach ($aMatchPredictions as $iKey=>$aMatchPrediction)
        <li class="list-group-item py-2">
            <div class="row">
                <div class="col-5 text-left fa-2x font-weight-bold my-auto">{{ $aMatchPrediction['sUserName'] }}</div>
                @php
                $sText = 'None';
                $sClass = 'muted';

                if ((bool) $aMatchPrediction['user_prediction']) {
                    if ($aMatchSchedule['final_result'] == $aMatchPrediction['user_prediction']['result']) {
                        $sText = 'Hit';
                        $sClass = 'success';
                    } else if ($aMatchSchedule['final_result'] != $aMatchPrediction['user_prediction']['result']) {
                        $sText = 'Miss';
                        $sClass = 'danger';
                    }
                }
                @endphp
                <div class="col-4">
                    <div class="float-left w-50 my-auto" title="{{ $sText }}">
                        <small class="clearfix">Prediction:</small>
                        <span class="fa-2x font-weight-bold text-{{ $sClass }}">{{ ((bool) $aMatchPrediction['user_prediction']) ? ucfirst($aMatchPrediction['user_prediction']['result']) : $sText }}</span>
                    </div>
                </div>
                <div class="col-3">
                    <div class="float-left w-50 my-auto">
                        <small class="clearfix">Result:</small>
                        <span class="fa-2x font-weight-bold">{{ ucfirst($aMatchSchedule['final_result']) }}</span>
                    </div>
                </div>
            </div>
        </li>
        @endforeach
    </ul>
    @else
    <div class="alert alert-warning text-center">There were no predictions</div>
    @endif
</div>
@endsection