@extends('layouts.web')

@section('content')
<div class="container">
    <h4 class="mb-4">User Statistics</h4>

    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 mx-auto">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="mb-0">Statistics of <span class="font-weight-bold">{{ $aUser['name'] }}</span></h4>
                </div>
                <div class="card-body">
                    <div class="row w-100">
                        <div class="col-2 text-center">
                            <div class="d-flex h-100">
                                <div class="my-auto mx-auto fa-3x">
                                    <span class="text-muted mb-0">
                                        <span class="clearfix fa-2x font-weight-bold">{{ $aStatistics['iPoints'] }}</span>
                                        <small>point{{ ($aStatistics['iPoints']!=1)?'s':'' }}</small>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-10">
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
                            <h5 class="text-muted mb-0 fa-2x">In {{ $aStatistics['iHits']+$aStatistics['iMisses'] }} predictions of {{ $aStatistics['iPredictions'] }} in total</h5>
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
                        Hits
                        <span class="badge bg-white text-success">{{ count($aHitsAndMisses['hits']) }} of {{ $iTotalMatches }}</span>
                    </h4>
                </div>
                @if (count($aHitsAndMisses['hits']) > 0)
                    <div class="list-group list-group-flush hitsContent">
                    @foreach ($aHitsAndMisses['hits'] as $aHit)
                        <div class="list-group-item list-group-item-action py-2">
                            <div class="row">
                                <div class="col-3 text-right my-auto pr-0">{{ $aHit['home_team']['name'] }}</div>
                                <div class="col-2 text-center">
                                    <img src="{{ asset('images/flags/'.((!is_null($aHit['home_team_id']))?$aHit['home_team']['code']:'unknown').'.png') }}" class="w-100 border-0" />
                                </div>
                                <div class="col-2 text-center my-auto">vs</div>
                                <div class="col-2 text-center">
                                    <img src="{{ asset('images/flags/'.((!is_null($aHit['away_team_id']))?$aHit['away_team']['code']:'unknown').'.png') }}" class="w-100 border-0" />
                                </div>
                                <div class="col-3 text-left my-auto pl-0">{{ $aHit['away_team']['name'] }}</div>
                            </div>
                            <div class="row text-nowrap">
                                <div class="col-4 text-right">
                                    <span class="text-muted">Prediction: </span>
                                    <span class="text-success font-weight-bold">{{ ucfirst($aHit['user_prediction']['result']) }}</span>
                                </div>
                                <div class="col-4 text-left text-center text-points font-weight-bold">{{ $aHit['points'] }} points</div>
                                <div class="col-4 text-left text-muted">
                                    <span>Result: </span>
                                    <span class="font-weight-bold">{{ ucfirst($aHit['final_result']) }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </div>
                @else
                <div class="card-body">
                    <div class="alert alert-warning mb-0 text-center">There are no hits</div>
                </div>
                @endif
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-6">
            <div class="card">
                <div class="card-header text-white bg-danger">
                    <h4 class="my-0 d-flex justify-content-between align-items-center">
                        Misses
                        <span class="badge bg-white text-danger">{{ count($aHitsAndMisses['misses']) }} of {{ $iTotalMatches }}</span>
                    </h4>
                </div>
                @if (count($aHitsAndMisses['misses']) > 0)
                    <div class="list-group list-group-flush missesContent">
                    @foreach ($aHitsAndMisses['misses'] as $aMiss)
                        <div class="list-group-item list-group-item-action py-2">
                            <div class="row">
                                <div class="col-3 text-right my-auto pr-0">{{ $aMiss['home_team']['name'] }}</div>
                                <div class="col-2 text-center">
                                    <img src="{{ asset('images/flags/'.((!is_null($aMiss['home_team_id']))?$aMiss['home_team']['code']:'unknown').'.png') }}" class="w-100 border-0" />
                                </div>
                                <div class="col-2 text-center my-auto">vs</div>
                                <div class="col-2 text-center">
                                    <img src="{{ asset('images/flags/'.((!is_null($aMiss['away_team_id']))?$aMiss['away_team']['code']:'unknown').'.png') }}" class="w-100 border-0" />
                                </div>
                                <div class="col-3 text-left my-auto pl-0">{{ $aMiss['away_team']['name'] }}</div>
                            </div>
                            <div class="row text-nowrap">
                                <div class="col-4 text-right">
                                    <span class="text-muted">Prediction: </span>
                                    <span class="text-danger font-weight-bold">{{ ucfirst($aMiss['user_prediction']['result']) }}</span>
                                </div>
                                <div class="col-4">&nbsp;</div>
                                <div class="col-4 text-right text-muted">
                                    <span>Result: </span>
                                    <span class="font-weight-bold">{{ ucfirst($aMiss['final_result']) }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </div>
                @else
                <div class="card-body">
                    <div class="alert alert-warning mb-0 text-center">There are no misses</div>
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