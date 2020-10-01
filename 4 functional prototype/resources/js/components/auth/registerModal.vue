<template>
    <v-dialog v-model="value" persistent absolute max-width="600px" @click:outside="closeDialog">         
        <v-card>
            <v-card-title>Registreren</v-card-title>

            <v-form lazy-validation id="registerForm" ref="form" v-model="valid" method="POST" :action="registerActionUrl()">

            <v-card-text>                
                <input  type="hidden" name="_token" v-bind:value="csrf" />  

                <v-row>
                    <v-col>
                        <v-text-field 
                            v-model="first_name"
                            label="Voornaam"
                            placeholder=" "
                            id="first_name"
                            type="text"
                            name="first_name"
                            counter="50" 
                            :rules="[
                                    v => !!v || 'Een voornaam is verplicht',
                                    v => v.length <= 50 || 'Max 50 karakters']"
                            autocomplete="name" autofocus />
                    </v-col>
                    
                    <v-col>
                        <v-text-field
                            v-model="last_name"
                            label="Achternaam" 
                            placeholder=" "
                            id="last_name"  
                            type="text"  
                            name="last_name"
                            value="" 
                            counter="50" 
                            :rules="[v => !!v || 'Een achternaam is verplicht',
                            v => v.length <= 50 || 'Max 50 karakters'
                            ]"
                            autocomplete="name"
                            />
                    </v-col>
                </v-row>
               

                <v-text-field
                    v-model="display_name"
                    label="Naam van profiel" 
                    hint="Andere gebruikers kunnen dit zien"
                    id="display_name"  
                    type="text"  
                    name="display_name"
                    counter="50" 
                    value="" 
                    :rules="[
                        v => !!v || 'Dit veld is verplicht',
                        v => v.length > 6 || 'Moet langer zijn dan 6 tekens',
                        v => v.length <= 50 || 'Max 50 karakters'
                    ]"
                    autocomplete=""
                />
                

               <v-text-field 
               :rules="
                    [
                        v => !!v || 'E-mail adres is verplicht',                        
                        v => /.+@.+\..+/.test(v) || 'E-mail adres moet valide zijn',
                        v => v.length <= 255 || 'Max 255 karakters'
                    ]"
                v-model="email" 
                label="E-mail" placeholder=" " 
                id="email" 
                type="email" 
                name="email" 
                value="" 
                required 
                counter="255"
                autocomplete="email" /> 

                <v-text-field 
                :rules="        [
                                    v => !!v || 'Het wachtwoord is verplicht',
                                    v => v.length > 8 || 'Moet langer zijn dan 8 tekens',
                                    v => v.length <= 255 || 'Max 255 karakters'
                                ]"

                v-model="password" 
                label="wachtwoord" 
                placeholder=" " 
                id="password" 
                type="password" 
                name="password" 
                counter="255"
                required 
                autocomplete="new-password" />

                <v-text-field
                :rules="[
                v => !!v || 'Dit kan niet leeg zijn',
                v => v.length <= 255 || 'Max 255 karakters'
                ]"
                v-model="password_c" 
                label="Herhaal wachtwoord" 
                placeholder=" " 
                id="password-confirm" 
                type="password" 
                class="" 
                name="password_confirmation" 
                counter="255"
                required 
                autocomplete="new-password" /> 

                <span class="error--text">{{confirmedPasswordsText}}</span>

                <v-select
                    required
                    :items="[{ text: 'Postmaker', value: 'postmaker' },{text: 'Aanvrager', value: 'requester' }]"
                    item-text="text"
                    item-value="value"                
                    name="type"
                    label="Ben jij een postmaker of aanvrager?"
                    :rules="[v => !!v || 'Verplicht']"
                ></v-select>
                <span></span>

            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn @click="validate" type="button" class="primary register-button-confirm" >
                    Registreren
                </v-btn>
            </v-card-actions>

            </v-form>
        </v-card>        
    </v-dialog>
</template>

<script>
export default {
    props: ['value','csrf'],
    data(){return{
        valid: false,
        confirmedPasswordsText : '',
        first_name:     '',
        last_name:      '',
        email:          '',
        password:       '',
        password_c:     '',
        display_name: '',
    }},
   
    methods:{
        registerActionUrl(){
            return window.location.origin+'/register';
        },
        closeDialog(){
            this.$emit('input', !this.value );            
        },
        validate(){           
            this.confirmedPasswordsText = '' 
            var validated = this.$refs.form.validate()            
            var confirmedPasswords = this.password == this.password_c;            
            if(!confirmedPasswords){ this.confirmedPasswordsText = 'Passwords zijn niet gelijk.' };
            if(validated && confirmedPasswords)
                document.getElementById("registerForm").submit();            
        }
    }
}
</script>