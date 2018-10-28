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

    @include('flash::message')

    <div class="col-10">
    {{--<div class="col-sm-10 col-md-10 col-lg-10 mx-auto">--}}
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
                            href="{{ ($aPodium[$aPosition['iKey']]['iUserId']==$iUserId)?'javascript:void(0);': route('user-statistics.index', ['iCompetitionId'=>1, 'iUserId'=>$aPodium[$aPosition['iKey']]['iUserId']]) }}"
                            title="{{ ($aPodium[$aPosition['iKey']]['iUserId']==$iUserId)?'':__('View User Statistics') }}"
                        >
                            <div class="card-body p-3 text-center">
                                <div class="font-weight-bold text-nowrap text-body">{{ $aPodium[$aPosition['iKey']]['sUserName'] }}</div>
                                <div class="font-weight-bold text-nowrap text-secondary py-1">
                                    {{ $aPodium[$aPosition['iKey']]['iPoints'].' '.__('point'.(($aPodium[$aPosition['iKey']]['iPoints'] != 1) ? 's' : '')) }}
                                </div>
                                <div class="text-success">{{ $aPodium[$aPosition['iKey']]['iHits'].' '.__('hits') }}</div>
                                <div class="text-danger">{{ $aPodium[$aPosition['iKey']]['iMisses'].' '.__('misses') }}</div>
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
                        href="{{ ($aUser['iUserId']==$iUserId)?'javascript:void(0);': route('user-statistics.index', ['iCompetitionId'=>1, 'iUserId'=>$aUser['iUserId']]) }}"
                        class="list-group-item list-group-item-action py-2"
                        title="{{ ($aUser['iUserId']==$iUserId)?'':__('View User Statistics') }}"
                    >
                        <div class="row">
                            <div class="col-2 text-center text-body noPodiumPosition">#{{ $iKey+1 }}</div>
                            <div class="col-6 col-lg-7 noPodiumCounters">
                                <div class="row">
                                    <div class="col-12 col-lg-7 text-left font-weight-bold noPodiumUser">{{ $aUser['sUserName'] }}</div>
                                    <div class="col-12 col-lg-3">
                                        <span class="text-success clearfix">{{ $aUser['iHits'].' '.__('hits') }}</span>
                                        <span class="text-danger">{{ $aUser['iMisses'].' '.__('misses') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 col-lg-3 order-3 order-lg-4 font-weight-bold text-secondary noPodiumPoints">{{ $aUser['iPoints'].' '.__('point'.(($aUser['iPoints'] != 1) ? 's' : '')) }}</div>
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