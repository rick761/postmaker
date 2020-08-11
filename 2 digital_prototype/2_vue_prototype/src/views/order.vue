<template>
    
    <v-row>
        <v-col cols="12">
            <v-btn to="ordercreate" class="primary mr-2">*createorderexample</v-btn>
            <v-btn to="orderpostmaker" class="primary mr-2">*postmakerorderexample</v-btn>
            <v-btn to="orderaanvrager" class="primary mr-2">*aanvragerorderexample</v-btn>
        </v-col>
        


        <v-col cols="8">   
                <preview-description v-if="!(isContentaanvragerOwner && !hasPostmaker)"   /> <!-- v-if="!(isContentaanvragerOwner && !hasPostmaker)" -->  <!--DONE-->
                <edit-description v-if="!hasPostmaker && isContentaanvragerOwner"  />       <!--v-if="isContentaanvragerOwner && !hasPostmaker" -->      <!--DONE-->
                <incoming-applys v-if="!hasPostmaker && isContentaanvragerOwner && stateOpen"  /> <!--v-if="isContentaanvragerOwner && !hasPostmaker-->                  
                
                <v-row>
                    <v-col>
                        <v-card style="height:100%" flat tile >
                            <edit-extra-description v-if="!hasPostmaker && isContentaanvragerOwner " /> <!-- v-if="isContentaanvragerOwner && !hasPostmaker" -->     <!--DONE-->
                            <preview-statistics v-if="!(isContentaanvragerOwner && !hasPostmaker)"   /> <!--v-if="!(isContentaanvragerOwner && !hasPostmaker)"  -->   <!--DONE-->
                        </v-card>
                    </v-col>
                    <v-col>
                        <v-card flat style="height:100%" tile >
                            <communication v-if="(isContentaanvragerOwner || isPostmakerOwner) && hasPostmaker"  /> <!-- v-if="((isContentaanvragerOwner || isPostmakerOwner ) && hasPostmaker ) || (isPostmaker && !hasPostmaker) " -->
                            <edit-images v-if="!hasPostmaker && isContentaanvragerOwner"  />            <!--v-if="isContentaanvragerOwner && !hasPostmaker"-->       <!--DONE-->
                        </v-card>
                    </v-col>
                </v-row>

            
        </v-col >
        
        <v-col cols="4">
            <v-card style="height:100%" flat tile>
                <actions v-if="(isContentaanvragerOwner || isPostmakerOwner)" />
                <apply  v-if="isPostmaker && !hasPostmaker && !isPostmakerOwner && !isContentaanvragerOwner" /> <!-- v-if="isPostmaker && !hasPostmaker"--> 
                <edit-statistics v-if="!hasPostmaker && isContentaanvragerOwner" /> <!-- v-if="isContentaanvragerOwner && !hasPostmaker" -->                
                <delivery v-if="(isContentaanvragerOwner || isPostmakerOwner) && hasPostmaker" />    
            </v-card>
        </v-col>

      

    </v-row>
    
</template>

<script>
import previewDescription from '../components/order/previewDescription';//
import previewStatistics from '../components/order/previewStatistics';//
import editDescription from '../components/order/editDescription';//
import editExtraDescription from '../components/order/editExtraDescription';//
import editImages from '../components/order/editImages';//
import editStatistics from '../components/order/editStatistics';//
import actions from '../components/order/actions';//
import communication from '../components/order/communication';
import apply from '../components/order/apply';
import incomingApplys from '../components/order/incomingApplys';
import delivery from '../components/order/delivery';
import {mapState} from 'vuex'

export default {
    components:{
        previewDescription,
        previewStatistics,
        editDescription,
        editExtraDescription,
        editImages,
        editStatistics,
        actions,
        communication,
        apply,
        incomingApplys,
        delivery
    },
    computed:{
        ...mapState({  
            order : state => state.order_page.order, 
            authUser: state => state.auth.user,
        }),

        stateOpen:function(){
            return this.order.state == 'open'
        },

        isContentaanvragerOwner:function(){                              
            return this.order.user.id == this.authUser.id;                                      
        },

        isPostmakerOwner:function(){            
            return this.order.postmaker.id == this.authUser.id;              
        },

        isContentaanvrager:function(){
            return this.authUser.type == 'Contentaanvrager';
        },

        isPostmaker:function(){
            return this.authUser.type == 'Postmaker';
        },

        hasPostmaker:function(){
            return this.order.postmaker.id != null;
        }
    },
    created(){
        this.$store.dispatch('order_page/load', this.$route.params.id )
    }
}
</script>

<style scoped>

</style>