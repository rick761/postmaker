@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <a href="{{ url('/debug/events') }}"> launch test event -> {{ url('/debug/events') }} </a>

        </div>
        <div class="col-md-12">
            <passport-clients class="mb-3"></passport-clients>      
            <passport-authorized-clients class="mb-3" ></passport-authorized-clients>
            <passport-personal-access-tokens class="mb-3"></passport-personal-access-tokens>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">My orders</div>
                <div class="card-body">       
                    <table  class="table">
                        <thead>
                            <tr>                        
                            <th scope="col">Van</th>
                            <th scope="col">Naam</th>
                            <th scope="col">Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($myOrders as $order)
                                <tr>                               
                                    <td>{{$order->user->first_name}} {{$order->user->last_name}}</td>
                                    <td>{{$order->title}}</td>
                                    <td>{{$order->description}}</td>
                                </tr>   
                            @endforeach                     
                        </tbody>                    
                    </table>
                   
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Open orders</div>
                <div class="card-body">                    
                <table class="table">
                    <thead>
                        <tr>                        
                        <th scope="col">Van</th>
                        <th scope="col">Naam</th>
                        <th scope="col">Description</th>
                        </tr>
                    </thead>
                    <tbody>
                         @foreach ($openOrders as $order)
                            <tr>                               
                                <td>{{$order->user->first_name}} {{$order->user->last_name}}</td>
                                <td>{{$order->title}}</td>
                                <td>{{$order->description}}</td>
                            </tr>   
                        @endforeach                     
                    </tbody>
                    </table>
                                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
