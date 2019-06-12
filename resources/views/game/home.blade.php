@extends('layouts.game')

@section('content')
<div class="row justify-content-center mx-auto py-4">
    <div class="col-10">
        @include('flash::message')

        <div class="card-deck">
            @foreach ($aCompetitions as $aCompetition)
            <div class="card">
                <img class="img-fluid mt-4 mx-auto" src="{{ asset('images/competitions/'.$aCompetition['icon']) }}" alt="{{ $aCompetition['name'] }}" />
                <div class="card-body text-center">
                    <h3 class="card-title">{{ $aCompetition['name'] }}</h3>
                </div>
                <div class="card-footer bg-white border-top-0">
                    <a href="{{ route('dashboard.index', ['iCompetitionId'=>$aCompetition['id']]) }}" class="btn btn-primary btn-block text-uppercase">
                        {{ __('Enter') }}
                        <i class="fa fa-chevron-right"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection