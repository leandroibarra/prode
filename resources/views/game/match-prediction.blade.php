@extends('layouts.game')

@section('content')
<div class="container">
    <h4 class="mb-4">Edit prediction of <span class="font-weight-bold">{{ $aMatchSchedule['home_team']['name'] }} vs {{ $aMatchSchedule['away_team']['name'] }}</span></h4>

    @include('flash::message')

    <div class="row">
        <div class="col-sm-10 col-md-10 col-lg-10 mx-auto">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('match-prediction.update') }}">
                @csrf

                <input type="hidden" name="match_schedule_id" value="{{ $aMatchSchedule['id'] }}" />
                <input type="hidden" name="match_prediction_id" value="{{ $aMatchPrediction['id'] }}" />

                <div class="form-group row mb-0">
                    <div class="w-40 text-right my-auto">
                        <input type="radio" name="result" value="home" {{ ($aMatchPrediction['result']=='home') ? 'checked' : '' }} />
                    </div>
                    <div class="w-20 text-center">
                        <img src="{{ asset('images/flags/'.((!is_null($aMatchSchedule['home_team_id']))?$aMatchSchedule['home_team']['code']:'unknown').'.png') }}" class="w-50 border-0" />
                    </div>
                    <div class="w-40 text-left my-auto">{{ $aMatchSchedule['home_team']['name'] }}</div>
                </div>
                @if ($aMatchSchedule['instance_id'] == 1)
                <div class="form-group row mb-0">
                    <div class="w-40 text-right my-auto">
                        <input type="radio" name="result" value="draw" {{ ($aMatchPrediction['result']=='draw') ? 'checked' : '' }} />
                    </div>
                    <div class="w-20 text-center">
                        <img src="{{ asset('images/icons/draw.png') }}" class="w-50 border-0" />
                    </div>
                    <div class="w-40 text-left my-auto">Draw</div>
                </div>
                @endif
                <div class="form-group row mb-0">
                    <div class="w-40 text-right my-auto">
                        <input type="radio" name="result" value="away" {{ ($aMatchPrediction['result']=='away') ? 'checked' : '' }} />
                    </div>
                    <div class="w-20 text-center">
                        <img src="{{ asset('images/flags/'.((!is_null($aMatchSchedule['away_team_id']))?$aMatchSchedule['away_team']['code']:'unknown').'.png') }}" class="w-50 border-0" />
                    </div>
                    <div class="w-40 text-left my-auto">{{ $aMatchSchedule['away_team']['name'] }}</div>
                </div>
                <div class="form-row mt-4">
                    <div class="col-6">
                        <button type="button" name="cancel" id="cancel" class="btn btn-secondary btn-block" onclick="window.location='{{ route('dashboard.index', ['iCompetitionId'=>1]) }}'">Cancel</button>
                    </div>
                    <div class="col-6">
                        <button type="submit" name="submit" id="submit" class="btn btn-primary btn-block">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection