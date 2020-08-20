import Vue from 'vue';
import Vuex from 'vuex';
// import * as mutations from './mutation-types'

Vue.use(Vuex);

export default {
    namespaced: true,
    strict: true, //Alleen op false zetten als de data in deze module vanuit de component gemanipuleerd mag worden
    state: () => ({}),
    mutations: {},
    actions: {
        async upload( /* { state, commit, dispatch }*/ { state }, payload) {

            if (!payload.folder) {
                payload.folder = 'no extra folder';
            }

            //single file to array
            if (!(payload.files instanceof Array)) {
                var _tmp = payload.files;
                payload.files = [];
                payload.files.push(_tmp);
            }

            let formData = new FormData();
            for (var i = 0; i < payload.files.length; i++) {
                let file = payload.files[i];
                formData.append('files[' + i + ']', file);
            }

            var config = {
                method: 'post',
                url: 'file/upload/' + payload.type + '/' + payload.folder,
                headers: {
                    'Content-Type': 'multipart/form-data'
                },
                data: formData
            }

            await axios(config).then(
                response => {
                    if (response.data.errors) {

                    }
                    if (!response.data.errors) {

                    }
                },
                error => {

                }
            );

        },
    },

};