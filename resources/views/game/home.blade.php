@extends('layouts.game')

@section('content')
    @include('flash::message')
    <div class="row justify-content-center mx-auto py-4">
        <div class="col-10">
            <div class="row">
                @foreach ($aCompetitions as $aCompetition)
                <div class="col-12 col-lg-4">
                    <div class="card">
                        <img class="img-fluid mt-4 mx-auto" src="{{ asset('images/competitions/'.$aCompetition['icon']) }}" alt="{{ $aCompetition['name'] }}" />
                        <div class="card-body text-center">
                            <h3 class="card-title">{{ $aCompetition['name'] }}</h3>
                            <a href="{{ route('dashboard.index', ['iCompetitionId'=>$aCompetition['id']]) }}" class="btn btn-primary btn-block">{{ __('Enter') }}</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection