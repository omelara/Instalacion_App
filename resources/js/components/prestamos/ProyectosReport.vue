<template>
    <div class="content">
        <div 
        class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100"
        >
            <v-overlay :value="loader" :z-index="99999999">
                <v-progress-circular
                indeterminate
                size="80"
                color="grey darken-4"
                ></v-progress-circular>
            </v-overlay>
            <v-card>
                <v-card-title>Generar tus Reportes</v-card-title>
                <v-container fluid>
                    <!--v-model="validForm"-->
                    <v-form 
                     ref="formProyecto"
                     
                     :lazy-validation="true"
                    >
                      <v-row class="bg-black">
                        <v-col cols="12" md="1" align-self="center"><label for=""><strong>Desde</strong></label></v-col>
                        <v-col cols="12" md="2" align-self="center">
                             <date-picker
                                v-model="fechaInicio"
                                :editable="false"
                                lang="es"
                                value-type="format"
                                format="DD-MM-YYYY"
                                class="mt-3"
                                style="width: 100% !important"
                                placeholder="Fecha Uno"
                              ></date-picker>
                            </v-col>
                            <v-col cols="12" md="1" align-self="center"><label for=""><strong>Hasta</strong></label></v-col>
                        <v-col cols="12" md="2">
                             <date-picker
                                v-model="fechaFinal"
                                :editable="false"
                                lang="es"
                                value-type="format"
                                format="DD-MM-YYYY"
                                class="mt-3"
                                style="width: 100% !important"
                                placeholder="Fecha Dos"
                              ></date-picker>
                            </v-col>
                            
                      </v-row>
                      <v-divider class="bg-black"></v-divider>
                      
                      <v-row>
                            <v-col cols="12" md="1" align-self="center">
                                <v-btn small elevation="6" color="#B22222" dark class="mb-2" 
                               :href="'/reportes/proyectos/rango?fechaInicio='+fechaInicio+'&fechaFinal='+fechaFinal" target="_blank">
                               Generar
                               <v-icon>mdi-clipboard-arrow-down</v-icon></v-btn>
                            </v-col>
                        </v-row>
                 
                </v-form>
                </v-container>
            </v-card>
        </div>
    </div>
</template>
<script>

export default{
    name: "ProyectosReport",
    data(){
        return{
            loader: false,
             
            fechaInicio: new Date(
                Date.now() -new Date().getTimezoneOffset() * 60000
            )
                .toISOString()
                .substr(0,10),
            fechaFinal: new Date(
                Date.now() -new Date().getTimezoneOffset() * 60000
            )
                .toISOString()
                .substr(0,10),

            loader:false,

        };
    },
    computed: {},
    methods: {

    },
    mounted() {

    },
};
</script>