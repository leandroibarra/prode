@extends('layouts.game')

@section('content')
<div class="container">
    <h4 class="mb-4">Ranking</h4>

    @include('flash::message')

    <div class="row">
        <div class="col-sm-10 col-md-10 col-lg-10 mx-auto">
            @if (count($aRanking['aRankingUsers']) > 0)
                @php
                $aPodium = array_slice($aRanking['aRankingUsers'], 0, 3, true);
                $aNoPodium = array_slice($aRanking['aRankingUsers'], 3, $aRanking['iTotalUsers'], true);
                @endphp
                <div class="rankingPodium d-flex">
                    <div class="mt-auto mb-0 h-100 w-35">
						@if (count($aPodium[1]) > 0)
                        <div class="card float-right rankingPodiumSecond">
                            <div class="card-header border-0 d-flex text-center fa-3x">
                                <span class="w-100 my-auto text-body">#2</span>
                            </div>
                            <a
                                href="{{ ($aPodium[1]['iUserId']==$iUserId)?'javascript:void(0);': route('user-statistics.index', ['iCompetitionId'=>1, 'iUserId'=>$aPodium[1]['iUserId']]) }}"
                                title="{{ ($aPodium[1]['iUserId']==$iUserId)?'':'View User Statistics' }}"
                            >
                                <div class="card-body p-3 text-center">
                                    <div class="font-weight-bold text-nowrap text-body">{{ $aPodium[1]['sUserName'] }}</div>
                                    <div class="font-weight-bold text-nowrap text-secondary py-1">
                                        {{ $aPodium[1]['iPoints'] }} point{{ ($aPodium[1]['iPoints']!=1)?'s':'' }}
                                    </div>
                                    <div class="text-success">{{ $aPodium[1]['iHits'] }} hits</div>
                                    <div class="text-danger">{{ $aPodium[1]['iMisses'] }} misses</div>
                                </div>
                            </a>
                        </div>
                        @endif
                    </div>
                    <div class="mt-auto mb-0 h-100 w-30">
                        @if (count($aPodium[0]) > 0)
                        <div class="card mx-auto rankingPodiumFirst">
                            <div class="card-header border-0 d-flex text-center fa-4x">
                                <span class="w-100 my-auto text-body">#1</span>
                            </div>
                            <a
                                href="{{ ($aPodium[0]['iUserId']==$iUserId)?'javascript:void(0);': route('user-statistics.index', ['iCompetitionId'=>1, 'iUserId'=>$aPodium[0]['iUserId']]) }}"
                                title="{{ ($aPodium[0]['iUserId']==$iUserId)?'':'View User Statistics' }}"
                            >
                                <div class="card-body p-3 text-center">
                                    <div class="font-weight-bold text-nowrap text-body">{{ $aPodium[0]['sUserName'] }}</div>
                                    <div class="font-weight-bold text-nowrap text-secondary py-1">
                                        {{ $aPodium[0]['iPoints'] }} point{{ ($aPodium[0]['iPoints']!=1)?'s':'' }}
                                    </div>
                                    <div class="text-success">{{ $aPodium[0]['iHits'] }} hits</div>
                                    <div class="text-danger">{{ $aPodium[0]['iMisses'] }} misses</div>
                                </div>
                            </a>
                        </div>
                        @endif
                    </div>
                    <div class="mt-auto mb-0 h-100 w-35">
                        @if (count($aPodium[2]) > 0)
                        <div class="card float-left rankingPodiumThird">
                            <div class="card-header border-0 d-flex text-center fa-2x">
                                <span class="w-100 my-auto text-body">#3</span>
                            </div>
                            <a
                                href="{{ ($aPodium[2]['iUserId']==$iUserId)?'javascript:void(0);': route('user-statistics.index', ['iCompetitionId'=>1, 'iUserId'=>$aPodium[2]['iUserId']]) }}"
                                title="{{ ($aPodium[2]['iUserId']==$iUserId)?'':'View User Statistics' }}"
                            >
                                <div class="card-body p-3 text-center">
                                    <div class="font-weight-bold text-nowrap text-body">{{ $aPodium[2]['sUserName'] }}</div>
                                    <div class="font-weight-bold text-nowrap text-secondary py-1">
                                        {{ $aPodium[2]['iPoints'] }} point{{ ($aPodium[2]['iPoints']!=1)?'s':'' }}
                                    </div>
                                    <div class="text-success">{{ $aPodium[2]['iHits'] }} hits</div>
                                    <div class="text-danger">{{ $aPodium[2]['iMisses'] }} misses</div>
                                </div>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

                @if (count($aNoPodium) > 0)
                <div class="mt-3 w-80 mx-auto">
                    <div class="list-group noPodiumContent">
                        @foreach ($aNoPodium as $iKey=>$aUser)
                        <a
                            href="{{ ($aUser['iUserId']==$iUserId)?'javascript:void(0);': route('user-statistics.index', ['iCompetitionId'=>1, 'iUserId'=>$aUser['iUserId']]) }}"
                            class="list-group-item list-group-item-action py-2"
                            title="{{ ($aUser['iUserId']==$iUserId)?'':'View User Statistics' }}"
                        >
                            <div class="row">
                                <div class="col-2 text-center fa-2x text-body">#{{ $iKey+1 }}</div>
                                <div class="col-5 text-left fa-2x font-weight-bold">{{ $aUser['sUserName'] }}</div>
                                <div class="col-5">
                                    <div class="float-left w-40 my-auto">
                                        <span class="text-success clearfix">{{ $aUser['iHits'] }} hits</span>
                                        <span class="text-danger">{{ $aUser['iMisses'] }} misses</span>
                                    </div>
                                    <div class="float-left w-60 my-auto fa-2x font-weight-bold text-secondary">{{ $aUser['iPoints'] }} point{{ ($aUser['iPoints']!=1)?'s':'' }}</div>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            @else
                <div class="alert alert-warning text-center">There are no users yet</div>
            @endif
        </div>
    </div>
</div>
@endsection