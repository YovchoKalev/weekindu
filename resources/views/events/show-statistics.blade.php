@extends('layouts.app')
@section('content')

<link rel="stylesheet" href="/css/custom/show.css">
<style>
    body {
        background: url('/images/event-backgrounds/{{ $event->background_photo }}') no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
    }
</style>

{{--<form action="{{ url('/invitation/get-guest-details') }}"--}}
      {{--method="post">--}}
    {{--{{ csrf_field() }}--}}
    {{--<input type="number" name="guestId">--}}
    {{--<input type="text" name="eventInvitationCode">--}}
    {{--<input type="submit">--}}
{{--</form>--}}

<div class="container custom-container">
    <h4 class="primary-text-color">{{ session('message') }}</h4>
    <div>
        <div class="row">
            <div class="col s12 m4 l2">
                <a class="btn waves-effect waves-light modal-trigger orange" href="#modal1">What?</a>
            </div>
            <div class="col s12 m4 l2 offset-l6">
                <a class="btn invitation-button" href="{{ url('/invitation/'.$event->invitation_code) }}">Invitation</a>
            </div>
            <div class="col s12 m4 l2">
                <form action="{{url('/event/'.$event->id )}}" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}

                    <button type="submit" class="waves-effect waves-light btn">
                        Delete event
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Structure -->
    <div id="modal1" class="modal">
        <div class="modal-content">
            <h3>Why do I need to enter the title, date and the description?</h3>
            <p style="font-weight: 700">On this page you see all the information which your guests provided.Navigate through the tabs to see different information.You can delete a user along with all the info he/she provided </p>
        </div>
        <div class="modal-footer">
            <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Ok</a>
        </div>
    </div>
    @php
        $counter = 5
    @endphp
    <div class="">
        <br>
        <div class="row center">
            <h4>{{ $event->title }}</h4>
        </div>
        <div class="row z-depth-2 white">
            <div class="col s12">
                <ul class="tabs">
                    <li class="tab col s3"><a id="active" href="#test1">Guests</a></li>
                    @foreach($stats as $key => $values)
                        <li class="tab col s3">
                            <a href="#test{{ $counter }}"
                               class="tooltipped"
                               data-position="top"
                               data-delay="50"
                               data-tooltip="{{ $key }}">
                                {{ $key }}
                            </a>
                        </li>
                        @php
                            $counter++
                        @endphp
                    @endforeach
                </ul>
            </div>
            <div id="test1" class="col s12">
                <table class="centered">
                    <thead>
                    <tr>
                        <th data-field="delete"></th>
                        <th data-field="id">Name</th>
                        <th data-field="name">Attending</th>
                        <th data-field="time">Sent</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($guests as $guest)
                        <tr>
                            <td>
                                <form action="{{url('/invitation/'.$guest->id )}}" method="post">
                                    {{ method_field('delete') }}
                                    {{ csrf_field() }}
                                    <button type="submit" class="deletebut" value=>
                                        <i class="material-icons">delete</i>
                                    </button>
                                </form>
                            </td>
                            <td class="tooltipped"
                                data-position="top"
                                data-delay="500"
                                data-tooltip="Click for details"
                                style="cursor: pointer">
                                <span class="blue-text">
                                    <a href="#modal-{{ $guest->id }}"
                                       class="modal-trigger guest-name-container"
                                       data-guest-id="{{ $guest->id }}"
                                       data-event-invitation-code="{{ $event->invitation_code }}">{{ $guest->guest_name }}</a>
                                    <div class="modal-container"></div>
                                </span>
                            </td>

                            @if($guest->accepted)
                                <td class="green-text">Yes</td>
                            @else
                                <td class="red-text">No</td>
                            @endif

                            <td>{{$guest->created_at}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            @php
                $counter = 5
            @endphp

            @foreach($stats as $key => $values)
                <div id="test{{ $counter }}" class="col s12">
                    <table class="centered">
                        <thead>
                            <tr>
                                <th data-field="name">Parameters</th>
                                <th data-field="quantity">Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($values as $value => $quantity)
                                <tr>
                                    <td>
                                        {{ $value }}
                                    </td>
                                    <td>
                                        {{ $quantity }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @php
                    $counter++
                @endphp
            @endforeach
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('ul.tabs').tabs('select_tab', 'tab_id');
    });
</script>
@endsection
