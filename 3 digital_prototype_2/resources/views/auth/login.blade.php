@extends('layouts.app')

@section('content')

<h1>Oeps er ging iets fout. <a href="{{ url('/') }}">Terug</a>  </h1>


<!-- <landing-component>

    <static-modal-component title="Aanmelden">
        <form method="POST" action="{{ route('login') }}"> 

            @csrf

            <v-card-text>
                <v-row>
                    <v-col cols=12>
                        
                        <v-text-field placeholder="E-mail" label="{{ __('E-Mail ') }}" id="email" type="email" class=" @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus />
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </v-col>
                    
                    <v-col cols=12>                           
                        <v-text-field placeholder="Wachtwoord" label="{{ __('Wachtwoord') }}" id="password" type="password" class="@error('password') is-invalid @enderror" name="password" required autocomplete="current-password"/>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <v-input>test</v-input>
                    </v-col>

                    <v-col cols=12 >
                        <input class="ml-3"  type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            {{ __('Bewaar mijn gegevens ') }}
                        </label>
                    </v-col>   
                </v-row>          

                    @if (Route::has('password.request'))
                        <v-btn small text color="secondary" href="{{ route('password.request') }}">
                            {{ __('Wachtwoord vergeten?') }}
                        </v-btn>
                    @endif 
                    <br>
                    <v-btn small text color="secondary" href="{{ route('register') }}">
                            {{ __('Nog geen account? Registreren') }}
                    </v-btn>

            </v-card-text>

            <v-card-actions>                
                <v-spacer></v-spacer>                
                
                <v-btn type="submit" class="primary">
                    {{ __('Aanmelden') }}
                </v-btn>

                <v-btn href="{{url('/')}}" text color="primary">
                    {{ __('Sluiten') }}
                </v-btn>       
            </v-card-actions>

        </form>         

    </static-modal-component>    
</landing-component> -->



@endsection
