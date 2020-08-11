<template>    
    <div> 
        <transition name="collapse"> 
            <div id="error_popdown_wrapper"     v-if="errors._tmp" >                
                <div id="error_popdown"         v-if="errors._tmp" >                    
                    <p  v-for="(item,key) in errors._tmp" :key="key"  >
                        Er is een fout bij  {{key}} - {{item}}
                    </p>
                </div>           
            </div>
        </transition>

        <transition name="collapse"> 
            <div class="card-box card errorbox" v-if="value" > 

                <div class="">    
                    <a href="javascript:void(0)" @click="emit" class="close float-right">
                        <b>
                            <span class="text-danger mdi mdi-close"></span>
                        </b>
                    </a>   
                </div>
            
            
                <ul class="list-group list-group-flush">
                    <transition-group name="collapse">   
                        <li v-for="(item,key) in errors.list" :key="key" class="list-group-item">

                            <a @click="remove(key)" href="javascript:void(0)">
                                <span class=" text-primary mdi mdi-minus mr-3"></span>
                            </a>

                            <span v-for="(item2,key2) in item" :key ="key2">
                                <small >Fout bij "{{key2}}"  </small>,  {{item2}}
                            </span>                        

                        </li>    
                    </transition-group>               
                </ul>
            
                <div class="card-body">                
                    <a href="#" @click="clear"  class="card-link text-danger">Verwijder alle foutmeldingen</a>
                    <a href="#" @click="emit" class="card-link text-primary">Sluit</a>
                </div>
            </div>  

        </transition>   
    </div>    

</template>

<script>
import {mapState} from 'vuex'

export default {
    props:['value'],        
        
    methods:{

        emit(){            
            this.$emit('input', false);
        },
        
        remove(index){            
            this.$store.dispatch('errors/remove',index);            
            if(! this.errors.list.length){
                this.emit();
            }
        },

        clear(){
            this.$store.dispatch('errors/clear');
            this.emit();
        }

    },
    
    computed:{
        ...mapState({
            errors : state => state.errors
        })
    },  

}
</script>

<style scoped>    
    #error_popdown_wrapper{
        position: absolute;        
        z-index: 999;
        left:0;
        top:0;
    }

    #error_popdown{
        display: inline-block;    
        min-height: 50px;
        padding: 0 33px;
        /* margin: 0 0 0 30px; */
        /* border-radius: 0 0 10px 10px; */
        line-height: 50px;
        background-color:gray;
    }


    .errorbox{
        color:black;
        padding:15px;
        position: absolute;
        z-index: 10;
        
    }

    .close{
        text-align: right;
        height: 65px;
        width: 65px;
        padding-right: 10px;
        line-height: 60px;
        margin-right:20px
        /* padding-bottom: 10px;         */
    }
    .card-box, .card{
        margin:0;
        padding:0;
    }

</style>