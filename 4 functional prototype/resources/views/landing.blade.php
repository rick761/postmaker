@extends('layouts.app')

@section('content')
    <landing-component guest="{{ Auth::guest() }}"  csrf="{{ csrf_token() }}" >     
        @if($errors->any())
            <v-alert dismissable type="error">
                {!! implode('', $errors->all('<div>:message</div>')) !!}
            </v-alert>                    
        @endif            
    </landing-component">
@endsection

