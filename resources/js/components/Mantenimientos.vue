  <template>
  <div class="content">
    <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100">
      <v-overlay :value="loader" :z-index="'99999999'">
        <v-progress-circular indeterminate size="80" color="grey darken-4"></v-progress-circular>
      </v-overlay>
      <v-card>
<v-card-title>
  Listado de mantenimientos
  <div class="flex-grow-1"></div>
  <v-text-field v-model="search" label="Buscar" hide-details></v-text-field>
</v-card-title>
        <v-data-table
          :headers="hTBMantenimientos"
          :items="arrayMantenimientos"
          :footer-props="{
            'items-per-page-options': [5,10, 20, 30,40],
            'items-per-page-text' : 'Registros Por Página'
          }"
          :items-per-page="5"
          :search="search"
          multi-sort
          class="elevation-1"
        >
          <!-- Template Para Modal de Actualizar y Agregar Categoria -->

          <template v-slot:top>
            <v-toolbar flat color="white">

             <div class="flex-grow-1">
                <v-btn small elevation="4" color="#B22222" dark class="mb-2" href="mantenimientos/pdf" target="_blank ">
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
                      <v-form style="background-color:" class="card-header text-center" ref="formMantenimiento" v-model="validForm" :lazy-validation="true">
                        <v-row>
                      <v-col cols="12" md="6">
                        <date-picker
                           v-model="mantenimiento.fecha"
                          :editable="false"
                          lang="es"
                          value-type="format"
                          format="YYYY-MM-DD"
                          class="mt-3"
                          style="width: 100% !important"
                          placeholder="Fecha Mantenimiento"
                        ></date-picker>
                      </v-col>
                        <v-col cols="12" md="6">
                        <v-text-field
                          append-icon="mdi-folder-outline"
                          v-model="mantenimiento.observacion"
                          @keyup="errorsNombre = []"
                          :rules="[v => !!v || 'Observación Es Requerida']"       
                          label="Observación"
                          required
                          :error-messages="errorsNombre"
                        ></v-text-field>
                        </v-col>
                        </v-row>
                        <v-row>
                        <v-col cols="12" md="6">
                        <v-text-field
                          append-icon="mdi-folder-outline"
                          v-model="mantenimiento.encargado"
                          @keyup="errorsNombre = []"
                          :rules="[v => !!v || 'Encargado Es Requerida']"
                          label="Encargado"
                          required
                          :error-messages="errorsNombre"
                        ></v-text-field>
                        </v-col>
                            <v-col cols="12" md="6">
                                <v-select
                                    v-model="mantenimiento.equipo_id"
                                    :items="arrayEquipos"
                                    label="Seleccione Equipo"
                                    item-value="id"
                                    item-text="nombre"
                                    :rules="[v => !!v || 'Nombre Es Requerido']"
                                  ></v-select>
                            </v-col>
                        </v-row>   
                      </v-form>
                    </v-container>
                  </v-card-text>
                  <v-card-actions>
                    <div class="flex-grow-1"></div>
                    <v-btn color="red darken-1" text @click="cerrarModal">Cerrar</v-btn>
                    <v-btn
                      color="info darken-1"
                      :disabled="!validForm"
                      @click="saveMantenimiento()"
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
                  color="#11992a"
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
                  @click="deleteMantenimiento(item)"
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
      arrayMantenimientos: [],
      arrayEquipos: [],
      hTBMantenimientos: [
        { text: "Observación", value: "observacion" },
        { text: "Fecha", value: "fecha" },
        { text: "Encargado", value: "encargado" },
        { text: "Equipo", value: "equipo" },
        { text: "Acciones", value: "action", sortable: false, align: "center" }
      ],
      loader: false,
      search: "",
      dialog: false,
      mantenimiento: {
        id: null,
        observacion: "",
        fecha: "",
        encargado:"",
        equipo_id: null,
        equipo: null
      },
      validForm: true,
      snackbar: false,
      msjSnackBar: "",
      errorsNombre: [],
      editedMantenimiento: -1
    };
  },
  computed: {
    formTitle() {
      return this.mantenimiento.id === null
        ? "Agregar Mantenimiento"
        : "Actualizar Mantenimiento";
    },
    btnTitle() {
      return this.mantenimiento.id === null ? "Guardar" : "Actualizar";
    }
  },
  methods: {
    
    fetchMantenimientos() {
      let me = this;
      me.loader = true;
      axios
      .get(`/mantenimientos/all`)
        .then(function(response) {
          me.arrayMantenimientos = response.data;
          me.loader = false;
        })
        .catch(function(error) {
          me.loader = false;
          console.log(error);
        });
      
     //me.arrayCategorias = [{"id":"1","nombre":"Hardware"},{"id":"2","nombre":"Accesorios"}];
     me.loader = false;
    },

    fetchEquipos() {
      let me = this;
      me.loader = true;
      axios.get(`/equipos/all`)
        .then(function(response) {
          me.arrayEquipos = response.data;
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
        me.mantenimiento = {
        id: null,
        observacion: "",
        fecha: "",
        encargado:"",
        equipo_id: null,
        equipo: null,
        };
        me.resetValidation();
      }, 300);
    },
    resetValidation() {
      let me = this;
      me.errorsNombre = [];
      me.$refs.formMantenimiento.resetValidation();
    },
    showModalEditar(mantenimiento) {
      let me = this;
      me.editedMantenimiento = me.arrayMantenimientos.indexOf(mantenimiento);
      me.mantenimiento = Object.assign({}, mantenimiento);
      me.dialog = true;
    },
    saveMantenimiento() {
      let me = this;
      if (me.$refs.formMantenimiento.validate()) {
        let accion = me.mantenimiento.id == null ? "add" : "upd";
        me.loader = true;
        if(accion=="add"){
            axios.post(`mantenimientos/save`,me.mantenimiento)
            .then(function(response) {
                 me.verificarAccionDato(response.data, response.status, accion);
                 me.cerrarModal(); 
             })
            .catch(function(error){
                if(error.response.status == 409){
                   me.setMessageToSnackBar("Mantenimiento ya existe",true);
                   me.errorsNombre = ["Nombre  Existente De Mantenimiento", "error"];
                }else{
                   Vue.swal("Error", "Ocurrio un error intente de nuevo","error"); 
                }
            })
        }else{
            //para actualizar
                axios.put(`/mantenimientos/update`,me.mantenimiento)
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
    deleteMantenimiento(mantenimiento) {
      let me = this;
      me.editedMantenimiento = me.arrayMantenimientos.indexOf(mantenimiento);
      
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
        title: 'Eliminar Mantenimiento',
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
            axios.post(`/mantenimientos/delete`, mantenimiento)
            .then(function(response) { 
              console.log(response.data);
                me.verificarAccionDato(response.data, response.status, "del");
                me.loader = false;
            })
          }
        });
    },
     verificarAccionDato(mantenimiento, statusCode, accion) {
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
          //Agrego al array de categorias el objecto que devuelve el Backend
          this.fetchMantenimientos(); 
          Toast.fire({
            icon: 'success',
            title: 'Mantenimiento Se Registro Con Exito'
           });
          me.loader = false;
          break;
        case "upd":
          //Actualizo al array de categorias el objecto que devuelve el Backend ya con los datos actualizados
          //Object.assign(me.arrayCategorias[me.editedCategoria], categoria);
          this.fetchMantenimientos(); 
          Toast.fire({
            icon: 'success',
            title: 'Mantenimiento Se Actualizo Con Exito'
           }); 
            
          me.loader = false;
          break;
        case "del":
          if (statusCode == 200) {
            try {
              //Se elimina del array de Categorias Activos si todo esta bien en el backend
              me.arrayMantenimientos.splice(me.editedMantenimiento, 1);
              //Se Lanza mensaje Final
              Toast.fire({
                icon: 'success',
                title: 'Mantenimiento Se Elimino...!!!'
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
    me.fetchMantenimientos();
    me.fetchEquipos();
  }
};
</script>