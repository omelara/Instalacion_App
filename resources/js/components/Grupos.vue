<template>
  <div class="content">
    <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100">
      <v-overlay :value="loader" :z-index="'99999999'">
        <v-progress-circular indeterminate size="80" color="grey darken-4"></v-progress-circular>
      </v-overlay>
      <v-card>
        <v-card-title>
  Listado Personal de proyecto
          <div class="flex-grow-1"></div>
          <v-text-field v-model="search" label="Buscar" hide-details></v-text-field>
        </v-card-title>
        <v-data-table
          :headers="hTBGrupos"
          :items="arrayGrupos"
          :footer-props="{
            'items-per-page-options': [5,10, 20, 30,40],
            'items-per-page-text' : 'Registros Por Página'
          }"
          :items-per-page="5"
          :search="search"
          multi-sort
          class="elevation-1"
        >
          <!-- Template Para Modal de Actualizar y Agregar Equipo -->

          <template v-slot:top>
            <v-toolbar flat color="white">
              <!--boton-->
              
              
               <div class="flex-grow-1">
                <v-btn small elevation="4" color="#B22222" dark class="mb-2" href="grupos/pdf" target="_blank ">
                  Generar PDF&nbsp;
                  <v-icon rightdark>mdi-cloud-upload</v-icon>
                </v-btn>
              </div>

              <div class="flex-grow-1"></div>
              <v-dialog v-model="dialog" persistent max-width="700px">
                <template v-slot:activator="{ on }">
                  <v-btn elevation="10" color="#11992a" dark class="mb-2" v-on="on">
                    Agregar&nbsp;
                    <v-icon>mdi-plus-box-multiple-outline</v-icon>
                  </v-btn>
                </template>
                <v-card>
                  <v-card-title class="headline primary lighten-2" primary-titles>
                    <span class="headline" v-text="formTitle"></span>
                  </v-card-title>
                  <v-card-text>
                    <v-container>
                      <v-form style="background-color:" class="card-header text-center" ref="formGrupo" v-model="validForm" :lazy-validation="true">
                        <v-row>
                        <v-col cols="12" md="6">
                          <date-picker
                          v-model="grupo.fecha"
                          :editable="false"
                          lang="es"
                          value-type="format"
                          format="YYYY-MM-DD"
                          class="mt-3"
                          style="width: 100% !important"
                          placeholder="Fecha Registro"
                         ></date-picker>
                         </v-col>
                          <v-col cols="12" md="6">
                            <v-select
                                v-model="grupo.cargo_id"
                                :items="arrayCargos"
                                label="Seleccione Cargo"
                                item-value="id"
                                item-text="nombre"
                                :rules="[v => !!v || 'Cargo Es Requerido']"
                                ></v-select>
                          </v-col>
                        </v-row>

                        <v-row>
                          <v-col cols="12" md="6">
                            <v-select
                                v-model="grupo.empleado_id"
                                :items="arrayEmpleados"
                                label="Seleccione Empleado"
                                item-value="id"
                                item-text="nombre"
                                :rules="[v => !!v || 'Empleado Es Requerido']"
                                ></v-select>
                          </v-col>
                          <v-col cols="12" md="6">
                            <v-select
                                v-model="grupo.proyecto_id"
                                :items="arrayProyectos"
                                label="Seleccione Proyecto"
                                item-value="id"
                                item-text="nombre"
                                :rules="[v => !!v || 'Proyecto Es Requerido']"
                                ></v-select>
                          </v-col>
                        </v-row>
                      </v-form>
                    </v-container>
                  </v-card-text>
                  <v-divider class="bg-primary"></v-divider>
                  <v-card-actions>
                    <div class="flex-grow-1"></div>
                    <v-btn color="red darken-1" text @click="cerrarModal">Cerrar</v-btn>
                    <v-btn
                      color="info darken-1"
                      :disabled="!validForm"
                      @click="saveGrupo()"
                      text
                      v-text="btnTitle"
                    ></v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
            </v-toolbar>
          </template>
         
          <!-- Template que va en la tabla en la columna de Acciones (Editar,Desactivar) -->
        
          <template v-slot:item.action="{item}" v-slot:activator="{ on }">
            <v-tooltip top>
              <template v-slot:activator="{ on }">
                <v-btn
                  color="success"
                  elevation="8"
                  small
                  dark
                  :disabled="item.id < 0"
                  v-on="on"
                  @click="showModalEditar(item)"
                >
                  <v-icon>mdi-pencil</v-icon>
                </v-btn>
              </template>
              <span>Actualizar Datos</span>
            </v-tooltip>
            <v-tooltip top >
              <template v-slot:activator="{ on }" >
                <v-btn
                  color="red"
                  class="mx-1"
                  elevation="8"
                  small
                  dark
                  :disabled="item.id < 0"
                  v-on="on"
                  @click="deleteGrupo(item)"
                >
                  <v-icon>mdi-delete</v-icon>
                </v-btn>
              </template>
              <span>Eliminar Registro</span>
            </v-tooltip>
          </template>
        </v-data-table>
        <v-snackbar v-model="snackbar">
          {{ msjSnackBar }}
          <v-btn color="red" text @click="snackbar = false">Cerrar</v-btn>
        </v-snackbar>
      </v-card>
    </div>
  </div>
</template>
<script>
export default {
  data() {
     return {
      arrayGrupos: [],
      arrayCargos: [],
      arrayEmpleados: [],
      arrayProyectos: [],
      hTBGrupos: [,
        { text: "Fecha", value: "fecha" },
        { text: "Cargo", value: "cargo" },
        { text: "Empleado", value: "empleado" },
        { text: "Proyecto", value: "proyecto" },
        { text: "Acciones", value: "action", sortable: false, align: "center" }
      ],
      loader: false,
      search: "",
      dialog: false,
      grupo: {
        id: null,
        fecha:"",
        cargo_id: null,
        cargo: null,
        empleado_id: null,
        empleado: null,
        proyecto_id: null,
        proyecto: null
      },
      validForm: true,
      snackbar: false,
      msjSnackBar: "",
      errorsNombre: [],
      editedGrupo: -1
    };
  },
  computed: {
    formTitle() {
      return this.grupo.id === null
        ? "Agregar Personal"
        : "Actualizar Personal";
    },
    btnTitle() {
      return this.grupo.id === null ? "Guardar" : "Actualizar";
    }
  },
  methods: {

    fetchGrupos() {
      let me = this;
      me.loader = true;
      axios.get(`/grupos/all`)
        .then(function(response) {
          me.arrayGrupos = response.data;
          me.loader = false;
        })
        .catch(function(error) {
          me.loader = false;
          console.log(error);
        });
     me.loader = false;
    },

    fetchCargos() {
      let me = this;
      me.loader = true;
      axios.get(`/cargos/all`)
        .then(function(response) {
          me.arrayCargos = response.data;
          me.loader = false;
        })
        .catch(function(error) {
          me.loader = false;
          console.log(error);
        });
     me.loader = false;
    },

    fetchEmpleados() {
      let me = this;
      me.loader = true;
      axios.get(`/empleados/all`)
        .then(function(response) {
          me.arrayEmpleados = response.data;
          me.loader = false;
        })
        .catch(function(error) {
          me.loader = false;
          console.log(error);
        });
     me.loader = false;

    },

      fetchProyectos() {
      let me = this;
      me.loader = true;
      axios.get(`/proyectos/all`)
        .then(function(response) {
          me.arrayProyectos = response.data;
          me.loader = false;
        })
        .catch(function(error) {
          me.loader = false;
          console.log(error);
        });
     me.loader = false;
    },
    
    setMessageToSnackBar(msj, estado) {
      let me = this;
      me.snackbar = estado;
      me.msjSnackBar = msj;
    },
    cerrarModal() {
      let me = this;
      me.dialog = false;
      setTimeout(() => {
        me.grupo = {
          id: null,
          fecha:"",
          cargo: null,
          empleado: null,
          proyecto: null,
        };
        me.resetValidation();
      }, 300);
    },
    resetValidation() {
      let me = this;
      me.errorsNombre = [];
      me.$refs.formGrupo.resetValidation();
    },

    showModalEditar(grupo) {
      console.log(grupo);
      let me = this;
      me.editedGrupo = me.arrayGrupos.indexOf(grupo);
      me.grupo = Object.assign({}, grupo);
      me.dialog = true;
    },
    
    saveGrupo() {
      let me = this;
      if (me.$refs.formGrupo.validate()) {
        let accion = me.grupo.id == null ? "add" : "upd";
        me.loader = true;
        if(accion=="add"){
            axios.post(`grupos/save`,me.grupo)
            .then(function(response) {
                 me.verificarAccionDato(response.data, response.status, accion);
                 me.cerrarModal(); 
             })
            .catch(function(error){
                if(error.response.status == 409){
                   me.setMessageToSnackBar("El grupo ya existe",true);
                   me.errorsNombre = ["Nombre de grupo existente", "error"];
                }else{
                   Vue.swal("Error", "Ocurrio un error intente de nuevo","error"); 
              }
            })
        }else{
            //para actualizar
              axios.put(`/grupos/update`,me.grupo)
               .then(function(response) {
                 me.verificarAccionDato(response.data, response.status, accion);
                 me.cerrarModal();  
                })
          .catch(function(error) {
            console.log(error);
            me.loader = false;
          });
        } 
      }
    },  

    deleteGrupo(grupo) {
      let me = this;
      me.editedGrupo = me.arrayGrupos.indexOf(grupo);
      
      const Toast = Vue.swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        onOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
        });
        //personalizando nueva confirmacion
        Vue.swal.fire({
        title: 'Eliminar personal',
        text: "Una vez realizada la acción no se podra revertir !",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#11992a',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: "No"
        }).then((result) => {
        if (result.value) {
            me.loader = true;
            axios.post(`/grupos/delete`, grupo)
            .then(function(response) {
                me.verificarAccionDato(response.data, response.status, "del");
                me.loader = false;
            })
          }
        });
    },
     verificarAccionDato(grupo, statusCode, accion) {
      let me = this;
      
      const Toast = Vue.swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        onOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
        }); 
      switch (accion) {
        case "add":
          //Agrego al array de horarios el objecto que devuelve el Backend
          //me.arrayHorarios.unshift(horario);
          this.fetchGrupos(); 
          Toast.fire({
            icon: 'success',
            title: 'Grupo registrado con Exito'
           });
          me.loader = false;
          break;
        case "upd":
          //Actualizo al array de horarios el objecto que devuelve el Backend ya con los datos actualizados
          this.fetchGrupos(); 
          Toast.fire({
            icon: 'success',
            title: 'Personal actualizado con Exito'
           }); 
            
          me.loader = false;
          break;
        case "del":
          if (statusCode == 200) {
            try {
              //Se elimina del array de Horarios Activos si todo esta bien en el backend
              me.arrayGrupos.splice(me.editedGrupo, 1);
              //Se Lanza mensaje Final
              Toast.fire({
                icon: 'success',
                title: 'Personal Eliminado!'
              });
            } catch (error) {
              console.log(error);
            }
          } else {
             Toast.fire({
                icon: 'error',
                title: 'Ocurrió un error, intente de nuevo'
              });
          }
          break;
      }
    }
  },
  mounted() {
    let me = this;
    me.fetchGrupos();
    me.fetchCargos();
    me.fetchEmpleados();
    me.fetchProyectos();
  }
};
</script>