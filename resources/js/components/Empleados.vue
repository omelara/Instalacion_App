 <template>
  <div class="content">
    <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100">
      <v-overlay :value="loader" :z-index="'99999999'">
        <v-progress-circular indeterminate size="80" color="grey darken-4"></v-progress-circular>
      </v-overlay>
      <v-card>
        <v-card-title>
          Listado de empleados
          <div class="flex-grow-1"></div>
          <v-text-field v-model="search" label="Buscar" hide-details></v-text-field>
        </v-card-title>
        <v-data-table
          :headers="hTBEmpleados"
          :items="arrayEmpleados"
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
                <v-btn small elevation="4" color="#B22222" dark class="mb-2" href="empleados/pdf" target="_blank ">
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
                      <v-form style="background-color:" class="card-header text-center" ref="formEmpleado" v-model="validForm" :lazy-validation="true">
                      <!--  <link rel="stylesheet" href="css/empleados.css"> -->
                      <v-row>
                      <v-col cols="12" md="6"> 
                       <date-picker
                          v-model="empleado.fecha_registro"
                          :editable="false"
                          lang="es"
                          value-type="format"
                          format="YYYY-MM-DD"
                          style="width: 100% !important"
                          placeholder="Fecha Registro"
                        ></date-picker>
                      </v-col>  
                      <v-col cols="12" md="6">
                        <date-picker
                          v-model="empleado.fecha_nacimiento"
                          :editable="false"
                          lang="es"
                          value-type="format"
                          format="YYYY-MM-DD"
                          style="width: 100% !important"
                          placeholder="Fecha Nacimiento"
                        ></date-picker>
                      </v-col> 
                      </v-row>

                      <v-row>
                        <v-col cols="12" md="6"> 
                      <v-text-field
                          append-icon="mdi-folder-outline"
                          v-model="empleado.nombre"
                          @keyup="errorsNombre = []"  
                          :rules="[v => !!v || 'Nombre Es Requerido',
                          v => (v && v.length <= 40) || 'El nombre debe tener maximo 40 caracteres']"      
                          label="Nombre"
                          required
                          :error-messages="errorsNombre"
                        ></v-text-field>
                        </v-col> 
                         <v-col cols="12" md="6">
                          <v-text-field
                          append-icon="mdi-folder-outline"
                          v-model="empleado.correo"
                          @keyup="errorsNombre = []"
                          :rules="[ v => !!v || 'Correo Es Requerido',
                          v => /.+@.+\..+/.test(v) || 'El correo debe tener los signos @ y .',
                          v => (v && v.length <= 40) || 'El nombre debe tener maximo 40 caracteres']"
                          label="Correo"
                          required
                          :error-messages="errorsNombre"
                         ></v-text-field>
                       </v-col>  
                      </v-row>

                      <v-row>
                        <v-col cols="12" md="6">
                        <v-text-field
                          append-icon="mdi-folder-outline"
                          v-model="empleado.salario"
                          @keyup="errorsNombre = []"
                          :rules="[v => !!v || 'Salario Es Requerido',
                          v => Number(v) > 0 || 'El valor tiene que ser mayor a 0 y sin letras',
                          v => (v && v.length <= 5) || 'El campo no debe sobrepasar los 5 caracteres']"   
                          label="Salario"
                          required
                          :error-messages="errorsNombre"
                        ></v-text-field>
                       </v-col> 
                        <v-col cols="12" md="6"> 
                       <v-text-field
                          append-icon="mdi-folder-outline"
                          v-model="empleado.telefono"
                          :counter="9"
                          @keyup="errorsNombre = []"
                          :rules="[v => !!v || 'Teléfono Es Requerido',
                          v => Number(v) > 0 || 'El valor tiene que ser mayor a 0 y sin letras',
                          ]"
                           pattern="^228\d{8}$"
                          label="Télefono"
                          required
                          :error-messages="errorsNombre"
                         ></v-text-field>
                         </v-col> 
                     
                        </v-row> 
                      </v-form>
                    </v-container>
                  </v-card-text>

                  <v-card-actions>
                    <div class="flex-grow-1"></div>
                    <v-btn color="red" text @click="cerrarModal" >Cerrar</v-btn>
                    <v-btn
                      color="info darken-1"
                      :disabled="!validForm"
                      @click="saveEmpleado()"
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
                  color="green"
                  elevation="8"
                  small
                  dark
                  :disabled="item.id < 0"
                  v-on="on"
                  @click="showModalEditar(item)"
                >
                  <v-icon>fas fa-pencil-alt</v-icon>
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
                  @click="deleteEmpleado(item)"
                >
                  <v-icon>fas fa-trash-alt</v-icon>
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
      arrayEmpleados: [],
      hTBEmpleados: [
        { text: "Nombre", value: "nombre" },
        { text: "Fecha Nacimiento", value: "fecha_nacimiento" },
        { text: "Fecha Registro", value: "fecha_registro" },
        { text: "Teléfono", value: "telefono" },
        { text: "Correo", value: "correo" },
        { text: "Salario $", value: "salario" },
        { text: "Acciones", value: "action", sortable: false, align: "center" }
      ],
      loader: false,
      search: "",
      dialog: false,
      empleado: {
        id: null,
        fecha_registro: "",
        nombre: "",
        fecha_nacimiento:"",
        correo: "",
        salario: "",
      
      },
      validForm: true,
      snackbar: false,
      msjSnackBar: "",
      errorsNombre: [],
      editedEmpleado: -1
    };
  },
  computed: {
    formTitle() {
      return this.empleado.id === null
        ? "Agregar  Empleado"
        : "Actualizar Empleado";
    },
    btnTitle() {
      return this.empleado.id === null ? "Guardar" : "Actualizar";
    }
  },
  methods: {
    
    fetchEmpleados() {
      let me = this;
      me.loader = true;
      axios
      .get(`/empleados/all`)
        .then(function(response) {
          me.arrayEmpleados = response.data;
          me.loader = false;
        })
        .catch(function(error) {
          me.loader = false;
          console.log(error);
        });
      
     //me.arrayCategorias = [{"id":"1","nombre":"Hardware"},{"id":"2","nombre":"Accesorios"}];
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
        me.empleado = {
          id: null,
          nombre: ""
        };
        me.resetValidation();
      }, 300);
    },
    resetValidation() {
      let me = this;
      me.errorsNombre = [];
      me.$refs.formEmpleado.resetValidation();
    },
    showModalEditar(empleado) {
      let me = this;
      me.editedEmpleado = me.arrayEmpleados.indexOf(empleado);
      me.empleado = Object.assign({}, empleado);
      me.dialog = true;
    },
    saveEmpleado() {
      let me = this;
      if (me.$refs.formEmpleado.validate()) {
        let accion = me.empleado.id == null ? "add" : "upd";
        me.loader = true;
        if(accion=="add"){
            axios.post(`empleados/save`,me.empleado)
            .then(function(response) {
                 me.verificarAccionDato(response.data, response.status, accion);
                 me.cerrarModal(); 
             })
            .catch(function(error){
                if(error.response.status == 409){
                   me.setMessageToSnackBar("Empleado ya existe",true);
                   me.errorsNombre = ["Nombre De Empleado  Existente ", "error"];
                }else{
                   Vue.swal("Error", "Ocurrio un error intente de nuevo","error"); 
                }
            })
        }else{
            //para actualizar
                axios.put(`/empleados/update`,me.empleado)
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
    deleteEmpleado(empleado) {
      let me = this;
      me.editedEmpleado = me.arrayEmpleados.indexOf(empleado);
      
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
        title: 'Eliminar Empleado',
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
            axios.post(`/empleados/delete`, empleado)
            .then(function(response) { 
              console.log(response.data);
                me.verificarAccionDato(response.data, response.status, "del");
                me.loader = false;
            })
          }
        });
    },
     verificarAccionDato(empleado, statusCode, accion) {
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
          this.fetchEmpleados(); 
          Toast.fire({
            icon: 'success',
            title: 'Empleado Se Registro Con Exito'
           });
          me.loader = false;
          break;
        case "upd":
          //Actualizo al array de categorias el objecto que devuelve el Backend ya con los datos actualizados
          this.fetchEmpleados(); 
          Toast.fire({
            icon: 'success',
            title: 'Empleado Se Actualizo Con Exito'
           }); 
          me.loader = false;
          break;
        case "del":
          if (statusCode == 200) {
            try {
              //Se elimina del array de Categorias Activos si todo esta bien en el backend
              me.arrayEmpleados.splice(me.editedEmpleado, 1);
              //Se Lanza mensaje Final
              Toast.fire({
                icon: 'success',
                title: 'Empleado Se Elimino...!!!'
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
    me.fetchEmpleados();
  }
};
</script>