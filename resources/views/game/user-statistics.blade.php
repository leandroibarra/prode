@extends('layouts.game')

@section('content')
<div class="subNavWrapper">
    <div class="container px-0">
        <ul class="subNavContent mb-0 px-0">
            <li>
                <a href="javascript:void(0);">{{ $aCompetition['name'] }}</a>
            </li>
            <li class="activePage">
                <a href="javascript:void(0);">{{ __('game.user_statistics_legend', ['user'=>$aUser['name']]) }}</a>
            </li>
        </ul>
    </div>
</div>

<div class="row justify-content-center mx-auto py-4">
    <div class="col-10">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row w-100">
                            <div class="col-12 col-md-2 text-center">
                                <div class="d-flex h-100">
                                    <div class="my-auto mx-auto userStatisticsPoints">
                                        <span class="text-muted mb-0">
                                            <span class="clearfix font-weight-bold">{{ $aStatistics['iPoints'] }}</span>
                                            <small>{{ trans_choice('game.points_1', $aStatistics['iPoints']) }}</small>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-10">
                                <div class="row">
                                    <div class="col-6 px-0">
                                        <div id="statisticsHits"></div>
                                    </div>
                                    <div class="col-6 px-0">
                                        <div id="statisticsFailures"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mx-auto w-100">
                            <div class="col-12 text-center">
                                <h5 class="text-muted mb-0 userStatisticsSummary">{{ __('game.statistics_legend', ['predictions'=>$aStatistics['iHits']+$aStatistics['iMisses'], 'total'=>$aStatistics['iPredictions']]) }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row pt-4">
            <div class="col-sm-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header text-white bg-success">
                        <h4 class="my-0 d-flex justify-content-between align-items-center">
                            {{ __('Hits') }}
                            <span class="badge bg-white text-success">{{ __('game.matches_count', ['matches'=>count($aHitsAndMisses['hits']), 'total'=>$iTotalMatches]) }}</span>
                        </h4>
                    </div>
                    @if (count($aHitsAndMisses['hits']) > 0)
                        <div class="list-group list-group-flush hitsContent">
                        @foreach ($aHitsAndMisses['hits'] as $aHit)
                            <div class="list-group-item list-group-item-action py-2">
                                <div class="row">
                                    <div class="col-6 col-lg-3 order-2 order-lg-1 text-left text-lg-right my-auto px-0 pr-lg-0">{{ $aHit['home_team']['name'] }}</div>
                                    <div class="col-4 offset-2 col-lg-2 offset-lg-0 order-1 order-lg-2 text-right text-lg-center">
                                        <img src="{{ asset('images/flags/'.((!is_null($aHit['home_team_id']))?$aHit['home_team']['code']:'unknown').'.png') }}" class="border-0" />
                                    </div>
                                    <div class="col-12 col-lg-2 order-3 order-lg-3 text-center my-auto">{{ __('vs') }}</div>
                                    <div class="col-4 offset-2 col-lg-2 offset-lg-0 order-4 order-lg-4 text-right text-lg-center">
                                        <img src="{{ asset('images/flags/'.((!is_null($aHit['away_team_id']))?$aHit['away_team']['code']:'unknown').'.png') }}" class="border-0" />
                                    </div>
                                    <div class="col-6 col-lg-3 order-5 order-lg-5 text-left my-auto px-0 pl-lg-0">{{ $aHit['away_team']['name'] }}</div>
                                </div>
                                <div class="row text-nowrap">
                                    <div class="col-6 col-lg-4 order-1 order-lg-1 text-left text-lg-right">
                                        <span class="text-muted">{{ __('Prediction') }}: </span>
                                        <span class="text-success font-weight-bold">{{ ucfirst(__('game.result.'.$aHit['user_prediction']['result'])) }}</span>
                                    </div>
                                    <div class="col-12 col-lg-4 order-3 order-lg-2 text-center text-points font-weight-bold">{{ trans_choice('game.points_3', $aHit['points']) }}</div>
                                    <div class="col-6 col-lg-4 order-2 order-lg-3 text-right text-lg-left text-muted">
                                        <span>{{ __('Result') }}: </span>
                                        <span class="font-weight-bold">{{ ucfirst(__('game.result.'.$aHit['final_result'])) }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </div>
                    @else
                    <div class="card-body">
                        <div class="alert alert-warning mb-0 text-center">{{ __('There are no hits') }}</div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header text-white bg-danger">
                        <h4 class="my-0 d-flex justify-content-between align-items-center">
                            {{ __('Misses') }}
                            <span class="badge bg-white text-danger">{{ __('game.matches_count', ['matches'=>count($aHitsAndMisses['misses']), 'total'=>$iTotalMatches]) }}</span>
                        </h4>
                    </div>
                    @if (count($aHitsAndMisses['misses']) > 0)
                        <div class="list-group list-group-flush missesContent">
                        @foreach ($aHitsAndMisses['misses'] as $aMiss)
                            <div class="list-group-item list-group-item-action py-2">
                                <div class="row">
                                    <div class="col-6 col-lg-3 order-2 order-lg-1 text-left text-lg-right my-auto px-0 pr-lg-0">{{ $aMiss['home_team']['name'] }}</div>
                                    <div class="col-4 offset-2 col-lg-2 offset-lg-0 order-1 order-lg-2 text-right text-lg-center">
                                        <img src="{{ asset('images/flags/'.((!is_null($aMiss['home_team_id']))?$aMiss['home_team']['code']:'unknown').'.png') }}" class="border-0" />
                                    </div>
                                    <div class="col-12 col-lg-2 order-3 order-lg-3 text-center my-auto">{{ __('vs') }}</div>
                                    <div class="col-4 offset-2 col-lg-2 offset-lg-0 order-4 order-lg-4 text-right text-lg-center">
                                        <img src="{{ asset('images/flags/'.((!is_null($aMiss['away_team_id']))?$aMiss['away_team']['code']:'unknown').'.png') }}" class="border-0" />
                                    </div>
                                    <div class="col-6 col-lg-3 order-5 order-lg-5 text-left my-auto px-0 pl-lg-0">{{ $aMiss['away_team']['name'] }}</div>
                                </div>
                                <div class="row text-nowrap">
                                    <div class="col-6 col-lg-4 order-1 order-lg-1 text-left text-lg-right">
                                        <span class="text-muted">{{ __('Prediction') }}: </span>
                                        <span class="text-danger font-weight-bold">{{ ucfirst(__('game.result.'.$aMiss['user_prediction']['result'])) }}</span>
                                    </div>
                                    <div class="col-12 col-lg-4 order-3 order-lg-2">&nbsp;</div>
                                    <div class="col-6 col-lg-4 order-2 order-lg-3 text-right text-lg-left text-muted">
                                        <span>{{ __('Result') }}: </span>
                                        <span class="font-weight-bold">{{ ucfirst(__('game.result.'.$aMiss['final_result'])) }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </div>
                    @else
                    <div class="card-body">
                        <div class="alert alert-warning mb-0 text-center">{{ __('There are no misses') }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
jQuery(document).ready(function() {
    // Execute circlifuls
    jQuery('#statisticsHits').circliful({
        animation: 1,
        animationStep: {{ round($aStatistics['fAccuracy'] / 10) }},
        foregroundColor: '#28A745',
        foregroundBorderWidth: 15,
        backgroundColor: '#E7E7E7',
        backgroundBorderWidth: 15,
        percent: {{ $aStatistics['fAccuracy'] }},
        fontColor: '#28A745',
        iconPosition: 'middle',
        text: '{{ trans_choice('game.hits', $aStatistics['iHits']) }}',
        textBelow: false,
        textColor: '#28A745'
    });

    jQuery('#statisticsFailures').circliful({
        animation: 1,
        animationStep: {{ round((100 - $aStatistics['fAccuracy']) / 10) }},
        foregroundColor: '#DC3545',
        foregroundBorderWidth: 15,
        backgroundColor: '#E7E7E7',
        backgroundBorderWidth: 15,
        percent: {{ ($aStatistics['fAccuracy'] > 0) ? 100 - $aStatistics['fAccuracy'] : $aStatistics['fAccuracy'] }},
        fontColor: '#DC3545',
        iconPosition: 'middle',
        text: '{{ trans_choice('game.misses', $aStatistics['iMisses']) }}',
        textBelow: false,
        textColor: '#DC3545'
    });

    // Align circliful text vertically
    jQuery('[id^=statistics]').find('text:eq(0)').attr('y', 105);
});
</script>
@endsection