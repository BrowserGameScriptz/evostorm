@extends('app')

@section('content')
            <div class="row">
                <div class="col-md-8">
                    <stats-box></stats-box>
                </div>
                <div class="col-md-4">
                    <logout-box></logout-box>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <main-menu></main-menu>
                </div>
                <div class="col-md-10">
                    <div ng-view></div> 
                </div>
            </div>
@endsection