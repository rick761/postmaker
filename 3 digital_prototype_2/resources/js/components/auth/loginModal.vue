<template>
    <v-dialog v-model="value" persistent absolute max-width="600px" @click:outside="closeDialog">       
        <form method="POST" :action="loginActionUrl()">        
            <input type="hidden" name="_token" v-bind:value="csrf">   
            <v-card>
                <v-card-title>Aanmelden</v-card-title>
                <v-card-text>                     
                      
                    <v-text-field placeholder=" " label="E-Mail" id="email" type="email" class=" @error('email') is-invalid @enderror" name="email" value="" required autocomplete="email" autofocus />
                    <v-text-field placeholder=" " label="Wachtwoord" id="password" type="password" class="@error('password') is-invalid @enderror" name="password" required autocomplete="current-password"/>
                            
                    <input class="ml-3"  type="checkbox" name="remember" id="remember">

                    <label class="form-check-label" for="remember">
                        Bewaar mijn gegevens
                    </label>    
                    
                    <br>         

                    <v-btn small text color="secondary" :href="forgetPasswordActionUrl()">
                        Wachtwoord vergeten?
                    </v-btn>

                </v-card-text>

                <v-card-actions>                
                    <v-spacer></v-spacer>
                    <v-btn type="submit" x-large class="primary">
                        Aanmelden
                    </v-btn>        
                </v-card-actions>
            </v-card>
        </form>        
    </v-dialog>
</template>
 
<script>
export default {    
    props: ['value','csrf'],
    created(){
        console.log(window.location.origin+'/login');
    },
    methods:{
        loginActionUrl(){
            return window.location.origin+'/login';
        },
        forgetPasswordActionUrl(){
            return window.location.origin+'/password/reset';
        },
        closeDialog(){
            this.$emit('input', !this.value );            
        }
    }
    
}
</script>