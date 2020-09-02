<template>
    <v-dialog v-model="value" persistent absolute max-width="600px" @click:outside="closeDialog">       
        <form method="POST" autocomplete="off" :action="loginActionUrl()">        
            <input type="hidden" name="_token" v-bind:value="csrf">   
            <card>
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

                    

                    
                    
                </v-card-text>

                <v-card-actions>                
                    <v-spacer></v-spacer>
                    <v-btn type="submit" x-large class="primary">
                        Aanmelden
                    </v-btn>        
                </v-card-actions>

                <v-card-text style="opacity: 0.3">
                    <h3>Test gebruikers</h3>
                    <v-row>
                        <v-col>
                            <p>Postmakers:</p>

                            <v-btn  color="secondary" block @click="postmakerAcc(1)">Piet Pieterse</v-btn><br>
                            <v-btn  color="secondary" block @click="postmakerAcc(2)">Henk de Jong</v-btn><br>
                            <v-btn   color="secondary" block @click="postmakerAcc(3)">Will Smit</v-btn><br>
                            <v-btn   color="secondary" block @click="postmakerAcc(4)">Henk de Jong</v-btn><br>

                        </v-col>
                        <v-col>
                            <p>Content aanvragers:</p>

                            <v-btn   color="secondary" block @click="requesterAcc(1)">Jan Jansen</v-btn><br>
                            <v-btn   color="secondary" block @click="requesterAcc(2)">Willem van de Berg</v-btn><br>
                            <v-btn   color="secondary" block @click="requesterAcc(3)">Pieter Post</v-btn><br>
                            <v-btn   color="secondary" block @click="requesterAcc(4)">Freek de Bruin</v-btn><br>

                        </v-col>                        
                    </v-row>
                </v-card-text>
            </card>
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
        postmakerAcc(nr){
            this.username = 'postmaker'+nr+'@postmaker.nl'
            this.password = 'postmaker'
        },
        requesterAcc(nr){
            this.username = 'requester'+nr+'@requester.nl'
            this.password = 'requester'
        }
    }
    
}
</script>