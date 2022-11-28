  <template>
  <div class="content">
    <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100">
      <v-overlay :value="loader" :z-index="'99999999'">
        <v-progress-circular indeterminate size="80" color="grey darken-4"></v-progress-circular>
      </v-overlay>
      <v-card>
        <v-card-title>
Listado de equipo por empleado
          <div class="flex-grow-1"></div>
          <v-text-field v-model="search" label="Buscar" hide-details></v-text-field>
        </v-card-title>
        <v-data-table
          :headers="hTBRecursoes"
          :items="arrayRecursoes"
          :footer-props="{
            'items-per-page-options': [5,10, 20, 30,40],
            'items-per-page-text' : 'Registros Por Página'
          }"
          :items-per-page="5"
          :search="search"
          multi-sort
          class="elevation-1"
        >
          <!-- Template Para Modal de Actualizar y Agregar Recursoes-->

          <template v-slot:top>
            <v-toolbar flat color="white">

<!---         <div class="flex-grow-1">
                <v-btn small elevation="4" color="#B22222" dark class="mb-2" href="recursoes/pdf" target="_blank ">
                  Generar PDF&nbsp;
                  <v-icon rightdark>mdi-cloud-upload</v-icon>
                </v-btn>
              </div>-->

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
                      <v-form style="background-color:" class="card-header text-center" ref="formRecursoe" v-model="validForm" :lazy-validation="true">
                        <v-row>  
                        <v-col cols="12" md="6">
                        <v-text-field
                          append-icon="mdi-folder-outline"
                          v-model="recursoe.equipo"
                          :rules="[v => !!v || 'Equipo Es Requerido']"
                          label="Equipo"
                          required
                        ></v-text-field>
                        </v-col>
                        <v-col cols="12" md="6">
                        <v-text-field
                          append-icon="mdi-folder-outline"
                          v-model="recursoe.cantidad"
                          type="number"
                          :rules="[v => !!v || 'Cantidad Es Requerida',
                          v => (v && v.length <= 6) || 'El valor no debe tener mas de 6 caracteres']"
                          label="Cantidad"
                          required
                        ></v-text-field>
                        </v-col>
                        </v-row>  
                        <v-row>  
                            <v-col cols="12" md="6">
                                <v-select
                                    v-model="recursoe.empleado_id"
                                    :items="arrayEmpleados"
                                    label="Seleccione Empleado"
                                    item-value="id"
                                    item-text="nombre"
                                    :rules="[v => !!v || 'Empleado Es Requerido']"
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
                      @click="saveRecursoe()"
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
                  @click="deleteRecursoe(item)"
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
      arrayRecursoes: [],
      arrayEmpleados: [],
      hTBRecursoes: [
        { text: "Equipo", value: "equipo" },
        { text: "Cantidad", value: "cantidad" },
        { text: "Empleado", value: "empleado"},
        { text: "Acciones", value: "action", sortable: false, align: "center" }
      ],
      loader: false,
      search: "",
      dialog: false,
      recursoe: {
        id: null,
        equipo: "",
        cantidad: "",
        empleado_id: null,
        empleado: null
      },
      validForm: true,
      snackbar: false,
      msjSnackBar: "",
      errorsNombre: [],
      editedRecursoe: -1
    };
  },
  computed: {
    formTitle() {
      return this.recursoe.id === null
        ? "Agregar Recursoe"
        : "Actualizar Recursoe";
    },
    btnTitle() {
      return this.recursoe.id === null ? "Guardar" : "Actualizar";
    }
  },
  methods: {

    fetchRecursoes() {
      let me = this;
      me.loader = true;
      axios.get(`/recursoes/all`)
        .then(function(response) {
          me.arrayRecursoes = response.data;
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

    setMessageToSnackBar(msj, estado) {
      let me = this;
      me.snackbar = estado;
      me.msjSnackBar = msj;
    },
    cerrarModal() {
      let me = this;
      me.dialog = false;
      setTimeout(() => {
        me.recursoe = {
        id: null,
        equipo: "",
        cantidad: "",
        empleado_id: null,
        empleado: null
        };
        me.resetValidation();
      }, 300);
    },
    resetValidation() {
      let me = this;
      me.errorsNombre = [];
      me.$refs.formRecursoe.resetValidation();
    },
    showModalEditar(recursoe) {
      console.log(recursoe);
      let me = this;
      me.editedRecursoe = me.arrayRecursoes.indexOf(recursoe);
      me.recursoe = Object.assign({}, recursoe);
      me.dialog = true;
    },

     saveRecursoe() {
      let me = this;
      if (me.$refs.formRecursoe.validate()) {
        let accion = me.recursoe.id == null ? "add" : "upd";
        me.loader = true;
        if(accion=="add"){
            axios.post(`recursoes/save`,me.recursoe)
            .then(function(response) {
                 me.verificarAccionDato(response.data, response.status, accion);
                 me.cerrarModal(); 
             })
            .catch(function(error){
                if(error.response.status == 409){
                   me.setMessageToSnackBar("El recursoe ya existe",true);
                   me.errorsNombre = ["Nombre de recursoe existente", "error"];
                }else{
                   Vue.swal("Error", "Ocurrio un error intente de nuevo","error"); 
                }
            })
        }else{
            //para actualizar
                axios.put(`/recursoes/update`,me.recursoe)
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
    
    deleteRecursoe(recursoe) {
      let me = this;
      me.editedRecursoe = me.arrayRecursoes.indexOf(recursoe);
      
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
        console.log(recursoe);
        Vue.swal.fire({
        title: 'Eliminar Recursoe',
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
            console.log(recursoe);
            axios.post(`recursoes/delete`,recursoe)
            .then(function(response) {
              console.log(response.data);
              me.verificarAccionDato(response.data.data, response.status, "del");
              me.loader = false;
            })
          }
        });
    },
     verificarAccionDato(recursoe, statusCode, accion) {
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
          this.fetchRecursoes(); 
          Toast.fire({
            icon: 'success',
            title: 'Recursoe RegistradO con Exito'
           });
          me.loader = false;
          break;
        case "upd":

          this.fetchRecursoes(); 
          Toast.fire({
            icon: 'success',
            title: 'Recursoe  Actualizado con Exito'
           }); 
            
          me.loader = false;
          break;
        case "del":
          if (statusCode == 200) {
            try {
           
              me.arrayRecursoes.splice(me.editedRecursoe, 1);
              //Se Lanza mensaje Final
              Toast.fire({
                icon: 'success',
                title: 'Recursoe Eliminado...!!!'
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
    me.fetchRecursoes();
    me.fetchEmpleados();
  }
};
</script>