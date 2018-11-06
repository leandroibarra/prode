@extends('layouts.game')

@section('content')
<div class="subNavWrapper">
    <div class="container px-0">
        <ul class="subNavContent mb-0 px-0">
            <li>
                <a href="javascript:void(0);">{{ $aCompetition['name'] }}</a>
            </li>
            <li class="activePage">
                <a href="javascript:void(0);">{{ __('Ranking') }}</a>
            </li>
        </ul>
    </div>
</div>

<div class="row justify-content-center mx-auto py-4">

    <div class="col-10">
        @include('flash::message')

        @if (count($aRanking['aRankingUsers']) > 0)
            @php
            $aPodium = array_slice($aRanking['aRankingUsers'], 0, 3, true);
            $aNoPodium = array_slice($aRanking['aRankingUsers'], 3, $aRanking['iTotalUsers'], true);

            $aPositions = [
                [
                    'iKey' => 1,
                    'iWidth' => 35,
                    'sCardClasses' => 'float-left float-md-right rankingPodiumSecond'
                ],
                [
                    'iKey' => 0,
                    'iWidth' => 30,
                    'sCardClasses' => 'mx-auto rankingPodiumFirst'
                ],
                [
                    'iKey' => 2,
                    'iWidth' => 35,
                    'sCardClasses' => 'float-right float-md-left rankingPodiumThird'
                ]
            ];
            @endphp
            <div class="rankingPodium d-flex">
                @foreach ($aPositions as $aPosition)
                <div class="mt-auto mb-0 h-100 w-{{ $aPosition['iWidth'] }}">
                    @if (count($aPodium[$aPosition['iKey']]) > 0)
                    <div class="card {{ $aPosition['sCardClasses'] }}">
                        <div class="card-header border-0 d-flex text-center">
                            <span class="w-100 my-auto text-body">#{{ $aPosition['iKey'] + 1 }}</span>
                        </div>
                        <a
                            href="{{ ($aPodium[$aPosition['iKey']]['iUserId']==$iUserId)?'javascript:void(0);': route('user-statistics.index', ['iCompetitionId'=>$aCompetition['id'], 'iUserId'=>$aPodium[$aPosition['iKey']]['iUserId']]) }}"
                            title="{{ ($aPodium[$aPosition['iKey']]['iUserId']==$iUserId)?'':__('game.view_statistics_legend', ['user'=>$aPodium[$aPosition['iKey']]['sUserName']]) }}"
                        >
                            <div class="card-body p-3 text-center">
                                <div class="font-weight-bold text-nowrap text-body">{{ $aPodium[$aPosition['iKey']]['sUserName'] }}</div>
                                <div class="font-weight-bold text-nowrap text-secondary py-1">
                                    {{ trans_choice('game.points_4', $aPodium[$aPosition['iKey']]['iPoints']) }}
                                </div>
                                <div class="text-success">{{ trans_choice('game.hits', $aPodium[$aPosition['iKey']]['iHits']) }}</div>
                                <div class="text-danger">{{ trans_choice('game.misses', $aPodium[$aPosition['iKey']]['iMisses']) }}</div>
                            </div>
                        </a>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>

            @if (count($aNoPodium) > 0)
            <div class="mt-3 w-80 mx-auto">
                <div class="list-group noPodiumContent">
                    @foreach ($aNoPodium as $iKey=>$aUser)
                    <a
                        href="{{ ($aUser['iUserId']==$iUserId)?'javascript:void(0);': route('user-statistics.index', ['iCompetitionId'=>$aCompetition['id'], 'iUserId'=>$aUser['iUserId']]) }}"
                        class="list-group-item list-group-item-action py-2"
                        title="{{ ($aUser['iUserId']==$iUserId)?'':__('game.view_statistics_legend', ['user'=>$aUser['sUserName']]) }}"
                    >
                        <div class="row">
                            <div class="col-2 text-center text-body noPodiumPosition">#{{ $iKey+1 }}</div>
                            <div class="col-6 col-lg-7 noPodiumCounters">
                                <div class="row">
                                    <div class="col-12 col-lg-7 text-left font-weight-bold noPodiumUser">{{ $aUser['sUserName'] }}</div>
                                    <div class="col-12 col-lg-3">
                                        <span class="text-success clearfix">{{ trans_choice('game.hits', $aUser['iHits']) }}</span>
                                        <span class="text-danger">{{ trans_choice('game.misses', $aUser['iMisses']) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 col-lg-3 order-3 order-lg-4 font-weight-bold text-secondary noPodiumPoints">{{ trans_choice('game.points_2', $aUser['iPoints']) }}</div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        @else
            <div class="alert alert-warning text-center">{{ __('There are no users yet') }}</div>
        @endif
    </div>
</div>
@endsection