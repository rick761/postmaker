<template>
    <v-dialog v-model="value" persistent absolute max-width="600px" @click:outside="closeDialog">       
        <form method="POST" autocomplete="off" :action="loginActionUrl()">        
            <input type="hidden" name="_token" v-bind:value="csrf">   
            <v-card>
                <v-card-title>Aanmelden</v-card-title>
                <v-card-text>                     
                      
                    <v-text-field autocomplete="off" v-model="username" placeholder="" label="E-Mail" id="email" type="email" class=" @error('email') is-invalid @enderror" name="email" value="" required autofocus />
                    <v-text-field autocomplete="off" v-model="password" placeholder="" label="Wachtwoord" id="password" type="password" class="@error('password') is-invalid @enderror" name="password" required />
                            
                    <input  v-model="remember" @change="checkRemember($event.target.checked)"  class="mt-3"  type="checkbox" name="remember" id="remember">

                    <label class="mt-3 form-check-label" for="remember">
                        Bewaar mijn gegevens
                    </label>    
                    
                    <br>         

                    <v-btn small text class="mt-3" color="secondary" :href="forgetPasswordActionUrl()">
                        Wachtwoord vergeten?
                    </v-btn>

                    <v-btn @click="postmakerAcc()">postmaker</v-btn>
                    <v-btn @click="requesterAcc()">requester</v-btn>

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
    data(){return{
        username:'',
        password:'',
        remember: 0
    }},
    created(){
         this.username = localStorage.getItem('username');
        this.password = localStorage.getItem('password');
        this.remember = localStorage.getItem('remember');

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
        },
        checkRemember(isChecked){            
            if(isChecked){
                localStorage.setItem("username", this.username);
                localStorage.setItem("password", this.password);
                localStorage.setItem("remember", 1);
            } else {
                localStorage.setItem("username", '');
                localStorage.setItem("password", '');
                localStorage.setItem("remember", 0);
            }
        },
        postmakerAcc(){
            this.username = 'postmaker@postmaker.nl'
            this.password = 'postmaker'
        },
        requesterAcc(){
            this.username = 'requester@requester.nl'
            this.password = 'requester'
        }
    }
    
}
</script>