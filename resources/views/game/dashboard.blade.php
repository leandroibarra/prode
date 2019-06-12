@extends('layouts.game')

@section('content')
<div class="subNavWrapper">
    <div class="container px-0">
        <ul class="subNavContent mb-0 px-0">
            <li>
                <a href="javascript:void(0);">{{ $aCompetition['name'] }}</a>
            </li>
            <li class="activePage">
                <a href="javascript:void(0);">{{ __('Dashboard') }}</a>
            </li>
        </ul>
    </div>
</div>

<div class="row justify-content-center mx-auto py-4">
    <div class="col-10">

        @include('flash::message')

        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h4 class="mb-0">{{ __('Your Statistics')  }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mx-auto w-100">
                            <div class="col-12 text-center">
                                <span class="text-muted fa-2x">
                                    <span class="font-weight-bold">{{ $aStatistics['iPoints'] }}</span>
                                    <small>{{ trans_choice('game.points_1', $aStatistics['iPoints']) }}</small>
                                </span>
                            </div>
                        </div>
                        <div class="row w-100">
                            <div class="col-6 px-0">
                                <div id="statisticsHits"></div>
                            </div>
                            <div class="col-6 px-0">
                                <div id="statisticsFailures"></div>
                            </div>
                        </div>
                        <div class="row mx-auto w-100">
                            <div class="col-12 text-center">
                                <h5 class="text-muted mt-3 mb-0">{{ __('game.statistics_legend', ['predictions'=>$aStatistics['iHits']+$aStatistics['iMisses'], 'total'=>$aStatistics['iPredictions']]) }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h4 class="mb-0">{{ __('Top Users') }}</h4>
                    </div>
                    @if (count($aRanking['aRankingUsers']) > 0)
                    <ul class="list-group list-group-flush">
                        @foreach ($aRanking['aRankingUsers'] as $iKey=>$aUser)
                        <li class="list-group-item rankingItem" style="height:{{ ($aRanking['iTotalUsers']==$aRanking['iRankingUsers'])?'110':'102' }}px;">
                            <div class="rankingItemPosition">
                                <span class="w-100 my-auto">#{{ $iKey+1 }}</span>
                            </div>
                            <div class="rankingItemUser">
                                <div>
                                    <div>{{ $aUser['sUserName'] }}</div>
                                    <div>
                                        <span class="text-success">{{ trans_choice('game.hits', $aUser['iHits']) }}</span>
                                        <span class="text-danger">{{ trans_choice('game.misses', $aUser['iMisses']) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="rankingItemPoints">
                                <span class="w-100 my-auto font-weight-bold text-secondary">{{ $aUser['iPoints'] }}</span>
                            </div>
                        </li>
                        @endforeach
                        @if ($aRanking['iTotalUsers'] > $aRanking['iRankingUsers'])
                        <a href="{{ route('ranking.index', ['iCompetitionId'=>$aCompetition['id']]) }}" class="list-group-item list-group-item-action list-group-item-secondary text-uppercase text-center">
                            {{ __('Complete ranking') }} <i class="fa fa-chevron-right"></i>
                        </a>
                        @endif
                    </ul>
                    @else
                    <div class="card-body">
                        <div class="alert alert-warning mb-0 text-center">{{ __('There are no users yet') }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="row pt-lg-4">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="my-0 d-flex justify-content-between align-items-center">
                            {{ __('Next Matches')  }}
                            <span class="badge badge-secondary">{{ __('game.matches_count', ['matches'=>count($aNextMatches), 'total'=>$iTotalMatches]) }}</span>
                        </h4>
                    </div>
                    @if (count($aNextMatches) > 0)
                        @php
                        $sCurrentDate = '';
                        @endphp
                        <div class="list-group list-group-flush nextMatchesContainer">
                        @foreach ($aNextMatches as $aNextMatch)
                            @php
                            if ($sCurrentDate != date('d F', strtotime($aNextMatch['utc_datetime']))) {
                                $sCurrentDate = date('d F', strtotime($aNextMatch['utc_datetime']));
                            @endphp
                            <div class="list-group-item list-group-item-secondary font-weight-bold text-center">{{ Date::createFromFormat('Y-m-d H:i:s', $aNextMatch['utc_datetime'])->format(__('game.matches_dates')) }}</div>
                            @php
                            }
                            @endphp

                            <a href="{{ route('match-prediction.edit', ['iCompetitionId'=>$aNextMatch['competition_id'], 'iMatchId'=>$aNextMatch['id']]) }}" class="list-group-item list-group-item-action py-2" title="{{ __('Edit Prediction') }}">
                                <div class="row">
                                    <div class="col-6 col-lg-3 order-2 order-lg-1 text-left text-lg-right my-auto px-0 pr-lg-0">{{ $aNextMatch['home_team']['name'] }}</div>
                                    <div class="col-4 offset-2 col-lg-2 offset-lg-0 order-1 order-lg-2 text-right text-lg-center">
                                        <img src="{{ asset('images/flags/'.((!is_null($aNextMatch['home_team_id']))?$aNextMatch['home_team']['code']:'unknown').'.png') }}" class="border-0" />
                                    </div>
                                    <div class="col-12 col-lg-2 order-3 order-lg-3 text-center my-auto">{{ __('vs') }}</div>
                                    <div class="col-4 offset-2 col-lg-2 offset-lg-0 order-4 order-lg-4 text-right text-lg-center">
                                        <img src="{{ asset('images/flags/'.((!is_null($aNextMatch['away_team_id']))?$aNextMatch['away_team']['code']:'unknown').'.png') }}" class="border-0" />
                                    </div>
                                    <div class="col-6 col-lg-3 order-5 order-lg-5 text-left my-auto px-0 pl-lg-0">{{ $aNextMatch['away_team']['name'] }}</div>
                                </div>
                                <div class="row text-nowrap">
                                    <div class="col-4 text-left text-muted">
                                        <span>{{ __('Prediction') }}: </span>
                                        <span class="font-weight-bold">{{ (!is_null($aNextMatch['user_prediction']['result']))?ucfirst(__('game.result.'.$aNextMatch['user_prediction']['result'])):__('None') }}</span>
                                    </div>
                                    <div class="col-4 text-center text-points font-weight-bold">{{ trans_choice('game.points_3', $aNextMatch['points']) }}</div>
                                    <div class="col-4 text-right text-muted">
                                        {{ date('H:i', strtotime($aNextMatch['utc_datetime'])) }}
                                        <i class="far fa-clock text-black"></i>
                                    </div>
                                    <div class="col-12 text-center text-muted">
                                        <span>{{ ($aNextMatch['instance_id']==1)?__('game.matches_phase', ['instance'=>$aNextMatch['group']['name'], 'match_day'=>$aNextMatch['match_day']]):$aNextMatch['instance']['name'] }}</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                        </div>
                    @else
                    <div class="card-body">
                        <div class="alert alert-warning mb-0 text-center">{{ __('There are no more matches') }}</div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="my-0 d-flex justify-content-between align-items-center">
                            {{ __('Last Matches') }}
                            <span class="badge badge-secondary">{{ __('game.matches_count', ['matches'=>count($aLastMatches), 'total'=>$iTotalMatches]) }}</span>
                        </h4>
                    </div>
                    @if (count($aLastMatches) > 0)
                        @php
                        $sCurrentDate = '';
                        @endphp
                        <div class="list-group list-group-flush lastMatchesContainer">
                        @foreach ($aLastMatches as $aLastMatch)
                            @php
                            if ($sCurrentDate != date('d F', strtotime($aLastMatch['utc_datetime']))) {
                                $sCurrentDate = date('d F', strtotime($aLastMatch['utc_datetime']));
                            @endphp
                            <div class="list-group-item list-group-item-secondary font-weight-bold text-center">{{ Date::createFromFormat('Y-m-d H:i:s', $aLastMatch['utc_datetime'])->format(__('game.matches_dates')) }}</div>
                            @php
                            }
                            @endphp

                            <a href="{{ route('match-predictions.index', ['iCompetitionId'=>$aLastMatch['competition_id'], 'iMatchId'=>$aLastMatch['id']]) }}" class="list-group-item list-group-item-action py-2" title="{{ __('View Predictions') }}">
                                <div class="row">
                                    <div class="col-6 col-lg-3 order-2 order-lg-1 text-left text-lg-right my-auto px-0 pr-lg-0">{{ $aLastMatch['home_team']['name'] }}</div>
                                    <div class="col-4 offset-2 col-lg-2 offset-lg-0 order-1 order-lg-2 text-right text-lg-center">
                                        <img src="{{ asset('images/flags/'.((!is_null($aLastMatch['home_team_id']))?$aLastMatch['home_team']['code']:'unknown').'.png') }}" class="border-0" />
                                    </div>
                                    <div class="col-12 col-lg-2 order-3 order-lg-3 text-center my-auto">{{ __('vs') }}</div>
                                    <div class="col-4 offset-2 col-lg-2 offset-lg-0 order-4 order-lg-4 text-right text-lg-center">
                                        <img src="{{ asset('images/flags/'.((!is_null($aLastMatch['away_team_id']))?$aLastMatch['away_team']['code']:'unknown').'.png') }}" class="border-0" />
                                    </div>
                                    <div class="col-6 col-lg-3 order-5 order-lg-5 text-left my-auto px-0 pl-lg-0">{{ $aLastMatch['away_team']['name'] }}</div>
                                </div>
                                <div class="row text-nowrap">
                                    <div class="col-6 col-lg-4 order-1 order-lg-1 text-left text-lg-right text-muted">
                                        <span>{{ __('Result') }}: </span>
                                        <span class="font-weight-bold">{{ (!is_null($aLastMatch['final_result']))?ucfirst(__('game.result.'.$aLastMatch['final_result'])):__('None') }}</span>
                                    </div>
                                    <div class="col-12 col-lg-4 order-3 order-lg-2 text-center text-points font-weight-bold">{{ trans_choice('game.points_3', $aLastMatch['points'], ['value'=>$aLastMatch['points']]) }}</div>
                                    <div class="col-6 col-lg-4 order-2 order-lg-3 text-right text-lg-left text-muted">
                                        <span>{{ __('Prediction') }}: </span>
                                        @php
                                        $sText = __('None');
                                        $sClass = 'muted';

                                        if ((bool) $aLastMatch['user_prediction']) {
                                            if ($aLastMatch['final_result'] == $aLastMatch['user_prediction']['result']) {
                                                $sText = __('Hit');
                                                $sClass = 'success';
                                            } else if ($aLastMatch['final_result'] != $aLastMatch['user_prediction']['result']) {
                                                $sText = __('Miss');
                                                $sClass = 'danger';
                                            }
                                        }
                                        @endphp
                                        <span class="font-weight-bold text-{{ $sClass }}">{{ $sText }}</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                        </div>
                    @else
                    <div class="card-body">
                        <div class="alert alert-warning mb-0 text-center">{{ __('No matches played yet') }}</div>
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