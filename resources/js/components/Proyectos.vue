 <template>
  <div class="content">
    <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100">
      <v-overlay :value="loader" :z-index="'99999999'">
        <v-progress-circular indeterminate size="80" color="grey darken-4"></v-progress-circular>
      </v-overlay>
      <v-card>
        <v-card-title>
          Listado de proyectos
          <div class="flex-grow-1"></div>
          <v-text-field v-model="search" label="Buscar" hide-details></v-text-field>
        </v-card-title>
        <v-data-table
          :headers="hTBProyectos"
          :items="arrayProyectos"
          :footer-props="{
            'items-per-page-options': [5,10, 20, 30,40],
            'items-per-page-text' : 'Registros Por Página'
          }"
          :items-per-page="5"
          :search="search"
          multi-sort
          class="elevation-1"
        >
          <!-- Template Para Modal de Actualizar y Agregar Proyectos-->

          <template v-slot:top>
            <v-toolbar flat color="white">

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
                      <v-form style="background-color:" class="card-header text-center" ref="formProyecto" v-model="validForm" :lazy-validation="true" >
                      <v-row>
                        <v-col cols="12" md="6">
                          <date-picker
                          v-model="proyecto.fecha_inicio"
                          :editable="false"
                          lang="es"
                          value-type="format"
                          format="YYYY-MM-DD"
                          class="mt-3"
                          style="width: 100% !important"
                          placeholder="Fecha Inicio"
                        ></date-picker>
                        </v-col>
                        <v-col cols="12" md="6">
                          <date-picker
                          v-model="proyecto.fecha_fin"
                          :editable="false"
                          lang="es"
                          value-type="format"
                          format="YYYY-MM-DD"
                          class="mt-3"
                          style="width: 100% !important"
                          placeholder="Fecha Fin"
                        ></date-picker>
                        </v-col>
                      </v-row>
                      <v-row>
                        <v-col cols="12" md="6">
                          <v-text-field
                          append-icon="mdi-folder-outline"
                          v-model="proyecto.nombre"
                          @keyup="errorsNombre = []"
                          :rules="[v => !!v || 'Nombre Es Requerido',
                          v => (v && v.length <= 70) || 'El nombre debe tener maximo 70 caracteres']"
                          label="Nombre"
                          required
                          :error-messages="errorsNombre"
                        ></v-text-field>
                        </v-col>
                       <v-col cols="12" md="6">
                        <v-text-field
                          append-icon="mdi-folder-outline"
                          v-model="proyecto.descripcion"
                          @keyup="errorsDescripcion = []"
                          :rules="[v => !!v || 'Descripción Es Requerida',
                          v => (v && v.length <= 70) || 'El nombre debe tener maximo 70 caracteres']"
                          label="Descripción"
                          required
                          :error-messages="errorsNombre"
                        ></v-text-field>
                        </v-col>
                     </v-row>
                     <v-row>
                        <v-col cols="12" md="6">
                        <v-text-field
                          append-icon="mdi-folder-outline"
                          v-model="proyecto.estado"
                          :rules="[v => !!v || 'Estado Es Requerido',
                          v => (v && v.length <= 30) || 'El nombre debe tener maximo 30 caracteres']"
                          label="Estado"
                          required
                        ></v-text-field>

                        <!--progreso--INICIO-->
                         <v-progress-linear
                          v-model="skill"
                          color="blue-grey"
                          height="25"
                          >
                         <template v-slot:default="{ value }">
                          <strong>{{ Math.ceil(value) }}%</strong>
                         </template>
                        </v-progress-linear>
                       <!--progreso--FIN-->

                        </v-col>
                            <v-col cols="12" md="6">
                                <v-select  
                                    v-model="proyecto.cliente_id"
                                    :items="arrayClientes"
                                    label="Seleccione Cliente"
                                    item-value="id"
                                    item-text="nombre"
                                    color="primary darken-1"
                                    :rules="[v => !!v || 'Cliente Es Requerido']"
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
                      @click="saveProyecto()"
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
                  @click="deleteProyecto(item)"
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
      arrayProyectos: [],
      arrayClientes: [],
      hTBProyectos: [
        { text: "Nombre", value: "nombre" },
        { text: "Descripción", value: "descripcion" },
        { text: "Fecha Inicio", value: "fecha_inicio"},
        { text: "Fecha Fin", value: "fecha_fin"},
        { text: "Estado", value: "estado"},
        { text: "Cliente", value: "cliente"},
        { text: "Acciones", value: "action", sortable: false, align: "center" }
      ],
      loader: false,
      search: "",
      dialog: false,
      proyecto: {
        id: null,
        nombre: "",
        descripcion: "",
        fecha_inicio: "",
        fecha_fin: "",
        estado: "",
        cliente_id: null,
        cliente: null
      },
      validForm: true,
      snackbar: false,
      msjSnackBar: "",
      errorsNombre: [],
      editedProyecto: -1
    };
  },
  computed: {
    formTitle() {
      return this.proyecto.id === null
        ? "Agregar Proyecto"
        : "Actualizar Proyecto";
    },
    btnTitle() {
      return this.proyecto.id === null ? "Guardar" : "Actualizar";
    }
  },
  methods: {

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
       
    fetchClientes() {
      let me = this;
      me.loader = true;
      axios.get(`/clientes/all`)
        .then(function(response) {
          me.arrayClientes = response.data;
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
        me.proyecto = {
        id: null,
        nombre: "",
        descripcion: "",
        fecha_inicio: "",
        fecha_fin: "",
        estado: "",
        cliente_id: null,
        cliente: null,
        };
        me.resetValidation();
      }, 300);
    },
    resetValidation() {
      let me = this;
      me.errorsNombre = [];
      me.$refs.formProyecto.resetValidation();
    },
    showModalEditar(proyecto) {
      console.log(proyecto);
      let me = this;
      me.editedProyecto = me.arrayProyectos.indexOf(proyecto);
      me.proyecto = Object.assign({}, proyecto);
      me.dialog = true;
    },

     saveProyecto() {
      let me = this;
      if (me.$refs.formProyecto.validate()) {
        let accion = me.proyecto.id == null ? "add" : "upd";
        me.loader = true;
        if(accion=="add"){
            axios.post(`proyectos/save`,me.proyecto)
            .then(function(response) {
                 me.verificarAccionDato(response.data, response.status, accion);
                 me.cerrarModal(); 
             })
            .catch(function(error){
                if(error.response.status == 409){
                   me.setMessageToSnackBar("El proyecto ya existe",true);
                   me.errorsNombre = ["Nombre de proyecto existente", "error"];
                }else{
                   Vue.swal("Error", "Ocurrio un error intente de nuevo","error"); 
                }
            })
        }else{
            //para actualizar
                axios.put(`/proyectos/update`,me.proyecto)
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
    
    deleteProyecto(proyecto) {
      let me = this;
      me.editedProyecto = me.arrayProyectos.indexOf(proyecto);
      
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
        console.log(proyecto);
        Vue.swal.fire({
        title: 'Eliminar Proyecto',
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
            console.log(proyecto);
            axios.post(`proyectos/delete`,proyecto)
            .then(function(response) {
              console.log(response.data);
              me.verificarAccionDato(response.data.data, response.status, "del");
              me.loader = false;
            })
          }
        });
    },
     verificarAccionDato(proyecto, statusCode, accion) {
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
          this.fetchProyectos(); 
          Toast.fire({
            icon: 'success',
            title: 'Proyecto Registrado con Exito'
           });
          me.loader = false;
          break;
        case "upd":

          this.fetchProyectos(); 
          Toast.fire({
            icon: 'success',
            title: 'Proyecto  Actualizado con Exito'
           }); 
            
          me.loader = false;
          break;
        case "del":
          if (statusCode == 200) {
            try {
           
              me.arrayProyectos.splice(me.editedProyecto, 1);
              //Se Lanza mensaje Final
              Toast.fire({
                icon: 'success',
                title: 'Proyecto Eliminado...!!!'
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
    me.fetchProyectos();
    me.fetchClientes();
  }
};
</script>