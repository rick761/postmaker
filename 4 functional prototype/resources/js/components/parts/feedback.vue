<template>
    <div v-if="hide==0 " style="margin: 10vh 0 5vh; position:absolute; right:0; margin-right:10px; z-index:30000;" :class="{ 'bottom-0' : (this.$vuetify.breakpoint.name == 'xs')}">

            <modal title="Te volgens instructies"  width="1024" v-model="show_feedback">
                
                <v-container>                    
                    <v-row justify="center">
                        <v-col>
                        <v-expansion-panels v-model="modal_current_step"  dark accordion >
                            <v-expansion-panel class="primary" v-for="(task,key) in tasks" :key="key" >
                                <v-expansion-panel-header>
                                    {{key+1}} - {{task.title}}
                                </v-expansion-panel-header>
                                <v-expansion-panel-content class="secondary">                                    
                                    <h5 class="mt-2"><i>{{task.scenario}}</i></h5> 
                                    <br>
                                    <h5 class="mt-2">Taken:</h5>
                                    <p v-for="(todo,key2) in task.todos" :key="key2">{{todo}}</p> 
                                </v-expansion-panel-content>
                            </v-expansion-panel>
                        </v-expansion-panels>

                        </v-col>

                        <v-col>
                            <v-card class="pa-2">
                                <div v-if="!show_feedback">
                                    <v-tooltip left>
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-btn  icon  color="warning" dark v-bind="attrs" v-on="on" @click=" show_feedback = ! show_feedback ">
                                                <v-icon large>mdi-comment-edit</v-icon>
                                            </v-btn>                                         
                                        </template>
                                        <span>Feedback</span>
                                    </v-tooltip>              
                                </div>

                                <div v-if="show_feedback">
                                    <!-- <v-btn icon color="primary" class="float-right  ml-2" @click=" show_feedback = ! show_feedback " ><v-icon>mdi-close</v-icon></v-btn> -->
                                    <v-card-subtitle>
                                        Testen
                                    </v-card-subtitle>
                                    <v-card-text> 

                                        <v-select     
                                            style="clear:both;"
                                            class="mb-3"                                                                     
                                            append-icon="mdi-gesture-tap"
                                            v-model="selected_story"                                
                                            :items="stories"
                                            label="kies een onderwerp"
                                        ></v-select>                       

                                        <v-slider
                                            v-model="slider"
                                            :thumb-size="24"
                                            thumb-label="always"
                                            v-if="selected_story!=''"
                                            style="display:none"
                                        >                                    
                                            <template v-slot:thumb-label="{ value }">
                                                {{ satisfactionEmojis[Math.min(Math.floor(value / 10), 9)] }}
                                            </template>
                                        </v-slider>

                                        <v-textarea
                                            v-if="selected_story!=''"
                                            filled
                                            name="input-7-4"
                                            label="Commentaar"
                                            v-model="comment"
                                        ></v-textarea>

                                        <v-textarea
                                            v-if="selected_story!=''"
                                            filled
                                            name="input-7-4"
                                            label="Notities"
                                            v-model="notation"
                                        ></v-textarea>

                                    </v-card-text>
                                    <v-card-actions>
                                        <v-btn  v-if="selected_story!=''" class="success" block @click="submitFeedback()"> 
                                            <v-icon>mdi-check</v-icon>
                                        </v-btn>
                                    </v-card-actions>
                                </div>                        
                            </v-card>

                        </v-col>
                    </v-row>
                </v-container>
                <template slot="actions"><v-icon>mdi-clock</v-icon>&nbsp; +- 15 minuten</template>
            </modal>

                <v-card class="pa-2 mb-1 d-none" v-if="show_feedback == 0">
                    <div class="text-center">
                        <v-btn @click="hide=1" icon><v-icon>mdi-minus</v-icon></v-btn>
                    </div>
                </v-card>

                <v-card class="pa-2 mb-1">
                    <div class="text-center">
                        <v-tooltip left>
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn  @click="show_feedback = true" icon  color="primary" dark v-bind="attrs" v-on="on">
                                    <!-- <v-icon large>mdi-crosshairs-question</v-icon> -->
                                    <v-icon large>mdi-comment-edit</v-icon>
                                </v-btn>                                         
                            </template>
                            <span>TESTEN</span>
                        </v-tooltip>              
                    </div>                    
                </v-card>

                
            </div>
</template>

<script>
export default {
     data(){return{
        show_feedback : false,
        satisfactionEmojis: ['😭', '😢', '☹️', '🙁', '😐', '🙂', '😊', '😁', '😄', '😍'],
        slider: 50,
        hide:0,
        stories: [            
            '1 Aanmelden',
            '2 Nieuwe opdracht aanmaken',
            '3 Bekijk en controleer de nieuwe opdracht',
            '4 De Postmaker in Postmaker vraagt aan',
            '5 De aanvrager accepteert de aanvraag',
            '6 De postmaker maakt de post',
            '7 De aanvrager keurt de oplevering',
            '8 De Postmaker doet een eindoplevering',
            '9 Download de oplevering',
           

        ], 
        stories_old:[
            '10 Presenteer je werk op je profiel ',
            '11 Extra',
        ],
        selected_story : '',
        version : 2,
        comment:'',
        instructions_modal : false,
        modal_current_step: '',
        notation : '',
        tasks:[
            {
                title:'Aanmelden',
                scenario : 'In dit scenario doen we het aanmelden.',
                todos: [
                    'start: landingspagina',
                    'optioneel: registreren',
                    'eindsituatie: Het hoofdscherm (als postmaker)'
                ]
            },
            {
                title:'Nieuwe opdracht aanmaken',
                scenario : 'Opdracht aanmaken en publiceren',
                todos: [
                    'start: (als aanvrager) Hoofdscherm',
                    'optioneel: opdracht aanvulling geven',
                    'eindsituatie: Nieuwe gepubliceerde opdracht zien'
                ]
            },
            {
                title:'Bekijk en controleer de nieuwe opdracht',
                scenario : 'Nu een nieuwe opdracht is gemaakt. Gaan we controleren of alles goed is ingevuld.',
                todos: [
                    'start: De aangemaakte opdracht',
                    'optioneel: bekijk de opdracht zelf',
                    'eindsituatie: Zien bij mijn projecten '
                ]
            },
            {
                title:'De Postmaker in Postmaker vraagt aan',
                scenario : 'Nu gaan we de rol van postmaker aannemen. Meld aan als postmaker en solliciteerd voor je eerder gemaakte opdracht',
                todos: [
                    'start:  (als postmaker) Hoofdscherm',
                    'optioneel: Andere prijs, en commentaar toevoegen',
                    'eindsituatie: Opdracht is aangevraagd'
                ]
            },
            {
                title:'De aanvrager accepteert de aanvraag',
                scenario : 'Nu gaan we de sollicitatie accepteren. Log in al aanvrager en accepteer de aanvraag.',
                todos: [
                    'start: (als aanvrager) Hoofdscherm',
                    'optioneel: ',
                    'eindsituatie: Opdracht is van Start gegaan'
                ]
            },
            {
                title:'De postmaker maakt de post',
                scenario : 'Nu gaan we een oplevering doen. log in als postmaker, ga naar de opdracht en doe een oplevering',
                todos: [
                    'start: (als aanvrager) Hoofdscherm',
                    'optioneel: ',
                    'eindsituatie: Oplevering is gedaan'
                ]
            },
            {
                title:'De aanvrager keurt de (tussen) oplevering',
                scenario : 'Nu gaan we de opdracht keuren, login als de aanvrager, zie de oplevering en accepteer de (tussen) oplevering ',
                todos: [
                    'start:  (als aanvrager) Hoofdscherm',
                    'optioneel: Oplevering een duim geven',
                    'eindsituatie: Oplevering accepteren'
                ]
            },
            {
                title:'De Postmaker doet een eindoplevering',
                scenario : 'Login al postmaker, doe de eindoplevering oplevering en geef aan dat er betaald is.',
                todos: [
                    'start: (als postmaker) Hoofdscherm',
                    'optioneel: ',
                    'eindsituatie: Eind oplevering is gedaan en de Betaling is ontvangen.'
                ]
            },
            {
                title:'Download de oplevering',
                scenario : 'ga naar archief en download je opgeleverde resultaat ',
                todos: [
                    'start: Archief',
                    'optioneel: als aanvrager downloaden',
                    'eindsituatie: Klikt op download'
                ]
            },
           
        ],
        tasks_old:[
            {
                title:'Aanmelden',
                scenario : 'Welkom bij Postmaker applicatie. eerst gaan we inloggen als aanvrager.  Als aanvrager kunnen we content aanvragen, postmakers kunnen dit voor ons maken.  (Binnen de test gaan we gebruik maken van meerdere accounts, onthoud ze of gebruik test accounts.)',
                todos: [
                    '- Login of registreer als aanvrager.',
                    '- Bekijk de applicatie na het inloggen.',
                    '- Geef je bevindingen door in het feedback paneel.'
                ]
            },
            {
                title:'Nieuwe opdracht aanmaken',
                scenario : 'Als aanvrager is de wens om ‘content’ te krijgen. Dit kan in de applicatie door een nieuw project te maken en deze openbaar te zetten.',
                todos: [
                    '- Maak een nieuw project',
                   '- Maak het project ‘Fotoshoot over [jouw onderwerp]',
                    '- Geef de aanvulling. “belafspraak: 06 12 34 56 78” ',
                   '- Geef een deadline',
                   '- Geef een vergoeding van 100 euro',
                   '- Aanmaken en publiceren',
                   '- Geef je bevindingen door in het feedback paneel.'
                ]
            },
            {
                title:'Bekijk en controleer de nieuwe opdracht',
                scenario : 'Nu een nieuwe opdracht is gemaakt. Gaan we controleren of alles goed is ingevuld. Nu kunnen we wachten op een aanvraag door een postmaker',
                todos: [
                    '- Ga naar opdrachten',
                    '- Zie de opdracht staan',
                    '- Open de opdracht',
                    '- (optie )Pas eventueel aan en her publiceer',
                    '- Geef je bevindingen door in het feedback paneel.',
                    '- Log uit'
                ]
            },
            {
                title:'De Postmaker in Postmaker vraagt aan',
                scenario : 'We hebben een opdracht aangemaakt. Nu gaan we de rol van postmaker aannemen. Dit doen we door opnieuw te registreren of een voorbeeldprofiel te kiezen. We willen als postmaker een opdracht. Dus we gaan hem aanvragen!',
                todos: [
                    '-- login of registreer als postmaker',
                    ' - Ga opzoek naar de opdracht ‘Fotoshoot over [jouw onderwerp]‘ binnen de applicatie.',
                    ' - Vraag hem aan voor een redelijk bedrag.',
                    '- Geef je bevindingen door in het feedback paneel.',                    
                    '- Log uit'
                ]
            },
            {
                title:'De aanvrager accepteert de aanvraag',
                scenario : 'De volgende stap is het accepteren van de aanvraag. Ga opzoek binnen de applicatie naar je projecten en aanvragen.',
                todos: [
                    '- Login als de aanvrager ',
                    '- Zoek de binnengekomen aanvraag en accepteer deze. ',
                    '- Schrijf een welkomst bericht naar de postmaker.',
                    '- Geef je bevindingen door in het feedback paneel.',
                    '- Log uit'
                ]
            },
            {
                title:'De postmaker maakt de post',
                scenario : 'De volgende stap in de opdracht is het maken van een test oplevering. Deze oplevering is ter indicatie van de eind opleveringen. Zo kan de postmaker een aantal pogingen doen om aan de wens te voldoen.',
                todos: [
                    '- Login als postmaker',
                    '- schrijf een welkomstbericht terug',
                    '- Doe een tijdelijke oplevering ',
                    '- Geef je bevindingen door in het feedback paneel.',
                    '- Log uit',
                ]
            },
            {
                title:'De aanvrager keurt de oplevering',
                scenario : 'Bij het zien van de oplevering wordt je helemaal enthousiast. Je vind het voorlopige resultaat erg mooi en geeft aan te willen betalen voor het hele eindresultaat.',
                todos: [
                    '- Login als de aanvrager',
                    '- Accepteer de oplevering',
                    '- Geef positieve feedbackback op de oplevering',
                    '- Waardeer de samenwerking',
                    '- Geef je bevindingen door in het feedback paneel.',
                    '- Log uit',
                ]
            },
            {
                title:'De Postmaker doet een eindoplevering',
                scenario : 'Nu de aanvrager blij is met de tijdelijke oplevering kunnen we de eindoplevering gaan sturen samen met de factuur',
                todos: [
                    '- Login als postmaker',
                    '- Doe een eindoplevering',
                    '- Stuur de factuur en bestanden.',
                    '- Geef aan dat het afgesproken bedrag ontvangen is.',
                    '- Bekijk het afgeronde project in het archief',
                    '- Geef je bevindingen door in het feedback paneel.',
                ]
            },
            {
                title:'Download de oplevering',
                scenario : 'Leuk, de bestanden zijn opgestuurd. Nu nog downloaden en blij zijn met je resultaat. ',
                todos: [
                    '- (optioneel) als aanvrager inloggen',
                    '- download de bestanden uit het archief',
                    '- Geef je bevindingen door in het feedback paneel.',]
            },
            {
                title:' (WERKT NIET) Presenteer je werk op je profiel',
                scenario : 'Voor het opbouwen van een aantrekkelijk profiel is het mogelijk om je geleverde werk te presenteren.',
                todos: [
                    '- Login als postmaker',
                    '- Bekijk je profiel en maak deze naar wens',
                    '- presenteer opleveringen van het afgeronde project op je profiel.',
                    '- Geef je bevindingen door in het feedback paneel.',
                ]
            },
            {
                title:'Extra',
                scenario : 'Zijn er nog een aantal onderdelen waar je iets over kwijt wilt?',
                todos: ['- Geef je bevindingen door in het feedback paneel.']
            }
        ]

     }},
     watch:{
        modal_current_step : function(){
            localStorage.setItem('modal_current_step', this.modal_current_step);
        } 
    },
    methods:{
        submitFeedback(){          

            var data = {
                version: this.version,
                story: this.selected_story,
                rate : this.slider,
                feedback : this.comment,
                notation: this.notation
            };

            this.$store.dispatch('api/post',{data: data, url: '/send/feedback'}).then(()=>{
                // console.log(this.$store.rootState.api.response);
            })

            this.show_feedback = ! this.show_feedback;
            this.slider=50;
            this.selected_story='';
            this.comment="";
            this.notation = "";
        }
    },
    created(){
        this.modal_current_step = localStorage.getItem('modal_current_step');
        this.$forceUpdate();
        
    }    
}
</script>

<style scoped>
    .bottom{

    }
</style>