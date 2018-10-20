@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Dashboard</h4>

    @include('flash::message')

    <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-6">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="mb-0">Your Statistics</h4>
                </div>
                <div class="card-body">
                    <div class="row mx-auto w-100">
                        <div class="col-12 text-center">
                            <span class="text-muted fa-2x">
                                <span class="font-weight-bold">{{ $aStatistics['iPoints'] }}</span>
                                <small>point{{ ($aStatistics['iPoints']!=1)?'s':'' }}</small>
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
                            <h5 class="text-muted mb-0">In {{ $aStatistics['iHits']+$aStatistics['iMisses'] }} predictions of {{ $aStatistics['iPredictions'] }} in total</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-6">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="mb-0">Top Users</h4>
                </div>
                @if (count($aRanking['aRankingUsers']) > 0)
                <ul class="list-group list-group-flush">
                    @foreach ($aRanking['aRankingUsers'] as $iKey=>$aUser)
                    <li class="list-group-item p-0 rankingItem" style="height:{{ ($aRanking['iTotalUsers']==$aRanking['iRankingUsers'])?'110':'102' }}px;">
                        <div class="float-left h-100 w-20 d-flex text-center rankingItemPosition">
                            <span class="w-100 my-auto fa-4x">#{{ $iKey+1 }}</span>
                        </div>
                        <div class="float-left h-100 w-60 rankingItemUser">
                            <div class="h-100 d-flex pl-2 text-left">
                                <div class="float-left w-75 my-auto fa-2x">{{ $aUser['sUserName'] }}</div>
                                <div class="float-left w-25 my-auto">
                                    <span class="text-success clearfix">{{ $aUser['iHits'] }} hits</span>
                                    <span class="text-danger">{{ $aUser['iMisses'] }} misses</span>
                                </div>
                            </div>
                        </div>
                        <div class="float-left h-100 w-20 d-flex text-center rankingItemUser">
                            <span class="w-100 my-auto fa-4x font-weight-bold text-secondary">{{ $aUser['iPoints'] }}</span>
                        </div>
                    </li>
                    @endforeach
                    @if ($aRanking['iTotalUsers'] > $aRanking['iRankingUsers'])
                    <a href="{{ route('ranking.index', ['iCompetitionId'=>1]) }}" class="list-group-item list-group-item-action list-group-item-secondary text-uppercase text-center">
                        Complete ranking <i class="fa fa-chevron-right"></i>
                    </a>
                    @endif
                </ul>
                @else
                <div class="card-body">
                    <div class="alert alert-warning mb-0 text-center">There are no users yet</div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="row pt-4">
        <div class="col-sm-12 col-md-6 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="my-0 d-flex justify-content-between align-items-center">
                        Next Matches
                        <span class="badge badge-secondary">{{ count($aNextMatches) }} of {{ $iTotalMatches }}</span>
                    </h4>
                </div>
                @if (count($aNextMatches) > 0)
                    @php
                    $sCurrentDate = '';
                    @endphp
                    <div class="list-group list-group-flush nextMatchesContent">
                    @foreach ($aNextMatches as $aNextMatch)
                        @php
                        if ($sCurrentDate != date('d F', strtotime($aNextMatch['utc_datetime']))) {
                            $sCurrentDate = date('d F', strtotime($aNextMatch['utc_datetime']));
                        @endphp
                        <div class="list-group-item list-group-item-secondary font-weight-bold text-center">{{ date('l jS \of F', strtotime($aNextMatch['utc_datetime'])) }}</div>
                        @php
                        }
                        @endphp

                        <a href="{{ route('match-prediction.edit', ['iCompetitionId'=>1, 'iMatchId'=>$aNextMatch['id']]) }}" class="list-group-item list-group-item-action py-2" title="Edit Prediction">
                            <div class="row">
                                <div class="col-3 text-right my-auto pr-0">{{ $aNextMatch['home_team']['name'] }}</div>
                                <div class="col-2 text-center">
                                    <img src="{{ asset('images/flags/'.((!is_null($aNextMatch['home_team_id']))?$aNextMatch['home_team']['code']:'unknown').'.png') }}" class="w-100 border-0" />
                                </div>
                                <div class="col-2 text-center my-auto">vs</div>
                                <div class="col-2 text-center">
                                    <img src="{{ asset('images/flags/'.((!is_null($aNextMatch['away_team_id']))?$aNextMatch['away_team']['code']:'unknown').'.png') }}" class="w-100 border-0" />
                                </div>
                                <div class="col-3 text-left my-auto pl-0">{{ $aNextMatch['away_team']['name'] }}</div>
                            </div>
                            <div class="row text-nowrap">
                                <div class="col-4 text-right text-muted">
                                    <span>Prediction: </span>
                                    <span class="font-weight-bold">{{ (!is_null($aNextMatch['user_prediction']['result']))?ucfirst($aNextMatch['user_prediction']['result']):'Any' }}</span>
                                </div>
                                <div class="col-2 text-left text-center text-points font-weight-bold">{{ $aNextMatch['points'] }} point{{ ($aNextMatch['points']>1) ? 's' : '' }}</div>
                                <div class="col-4 text-left text-muted">
                                    <span>{{ ($aNextMatch['instance_id']==1)?"Group {$aNextMatch['group']['name']} - {$aNextMatch['match_day']}":$aNextMatch['instance']['name'] }}</span>
                                </div>
                                <div class="col-2 text-left text-muted">
									{{ date('H:i', strtotime($aNextMatch['utc_datetime'])) }}
                                    <i class="far fa-clock text-black"></i>
                                </div>
                            </div>
                        </a>
                    @endforeach
                    </div>
                @else
                <div class="card-body">
                    <div class="alert alert-warning mb-0 text-center">There are no more matches</div>
                </div>
                @endif
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="my-0 d-flex justify-content-between align-items-center">
                        Last Matches
                        <span class="badge badge-secondary">{{ count($aLastMatches) }} of {{ $iTotalMatches }}</span>
                    </h4>
                </div>
                @if (count($aLastMatches) > 0)
                    @php
                    $sCurrentDate = '';
                    @endphp
                    <div class="list-group list-group-flush lastMatchesContent">
                    @foreach ($aLastMatches as $aLastMatch)
                        @php
                        if ($sCurrentDate != date('d F', strtotime($aLastMatch['utc_datetime']))) {
                            $sCurrentDate = date('d F', strtotime($aLastMatch['utc_datetime']));
                        @endphp
                        <div class="list-group-item list-group-item-secondary font-weight-bold text-center">{{ date('l jS \of F', strtotime($aLastMatch['utc_datetime'])) }}</div>
                        @php
                        }
                        @endphp

                        <a href="{{ route('match-predictions.index', ['iCompetitionId'=>1, 'iMatchId'=>$aLastMatch['id']]) }}" class="list-group-item list-group-item-action py-2" title="View Predictions">
                            <div class="row">
                                <div class="col-3 text-right my-auto pr-0">{{ $aLastMatch['home_team']['name'] }}</div>
                                <div class="col-2 text-center">
                                    <img src="{{ asset('images/flags/'.((!is_null($aLastMatch['home_team_id']))?$aLastMatch['home_team']['code']:'unknown').'.png') }}" class="w-100 border-0" />
                                </div>
                                <div class="col-2 text-center my-auto">vs</div>
                                <div class="col-2 text-center">
                                    <img src="{{ asset('images/flags/'.((!is_null($aLastMatch['away_team_id']))?$aLastMatch['away_team']['code']:'unknown').'.png') }}" class="w-100 border-0" />
                                </div>
                                <div class="col-3 text-left my-auto pl-0">{{ $aLastMatch['away_team']['name'] }}</div>
                            </div>
                            <div class="row text-nowrap">
                                <div class="col-4 text-right text-muted">
                                    <span>Result: </span>
                                    <span class="font-weight-bold">{{ (!is_null($aLastMatch['final_result']))?ucfirst($aLastMatch['final_result']):'Any' }}</span>
                                </div>
                                <div class="col-4 text-left text-center text-points font-weight-bold">{{ $aLastMatch['points'] }} point{{ ($aLastMatch['points'] > 1) ? 's' : '' }}</div>
                                <div class="col-4 text-left text-muted">
                                    <span>Prediction: </span>
                                    @php
                                    $sText = 'None';
                                    $sClass = 'muted';

                                    if ((bool) $aLastMatch['user_prediction']) {
                                        if ($aLastMatch['final_result'] == $aLastMatch['user_prediction']['result']) {
                                            $sText = 'Hit';
                                            $sClass = 'success';
                                        } else if ($aLastMatch['final_result'] != $aLastMatch['user_prediction']['result']) {
                                            $sText = 'Miss';
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
                    <div class="alert alert-warning mb-0 text-center">No matches played yet</div>
                </div>
                @endif
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
        text: '{{ "{$aStatistics['iHits']} hits" }}',
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
        text: '{{ "{$aStatistics['iMisses']} misses" }}',
        textBelow: false,
        textColor: '#DC3545'
    });

    // Align circliful text vertically
    jQuery('[id^=statistics]').find('text:eq(0)').attr('y', 105);
});
</script>
@endsection