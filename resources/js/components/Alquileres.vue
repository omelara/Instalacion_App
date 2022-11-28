 <template>
  <div class="content">
    <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100">
      <v-overlay :value="loader" :z-index="'99999999'">
        <v-progress-circular indeterminate size="80" color="grey darken-4"></v-progress-circular>
      </v-overlay>
      <v-card>
 <v-card-title>
  Listado de equipos alquilados
 <div class="flex-grow-1"></div>
 <v-text-field v-model="search" label="Buscar" hide-details></v-text-field>
   </v-card-title>
     <v-data-table
       :headers="hTBAlquileres"
       :items="arrayAlquileres"
        :footer-props="{
        'items-per-page-options': [5,10, 20, 30,40],
         'items-per-page-text' : 'Registros Por Página'
          }"
          :items-per-page="5"
          :search="search"
           multi-sort
           class="elevation-1"
           >
          <!-- Template Para Modal de Actualizar y Agregar alquiler-->
          <template v-slot:top>
            <v-toolbar class="" flat color="white">

             <div class="flex-grow-1">
                <v-btn small elevation="4" color="#B22222" dark class="mb-2" href="alquileres/pdf" target="_blank ">
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
                  <v-card-text >
                    <v-container>
                  <!-- cambio para formulario-->
                      <v-form  style="background-color:" class="card-header text-center" ref="formAlquiler" v-model="validForm" :lazy-validation="true">
                       <v-row>
                         <v-row>
                         <v-col cols="12" md="6">
                          <date-picker
                           v-model="alquiler.fecha"
                          :editable="false"
                          lang="es"
                          value-type="format"
                          format="YYYY-MM-DD"
                          class="mt-3"
                          style="width: 100% !important"
                          placeholder="Fecha Alquiler"
                        ></date-picker>
                         </v-col>
                         <v-col cols="12" md="6">
                         <date-picker
                          v-model="alquiler.fecha_devuelto"
                          :editable="false"
                          lang="es"
                          value-type="format"
                          format="YYYY-MM-DD"
                          class="mt-3"
                          style="width: 100% !important"
                          placeholder="Fecha Devuelto"
                        ></date-picker>
                         </v-col>
                       </v-row> 
                     <v-col cols="12" md="6">
                      <v-text-field
                        append-icon="mdi-folder-outline"
                        v-model="alquiler.equipo"
                        @keyup="errorsEquipo = []"
                        :rules="[v => !!v || 'Equipo Es Requerido']"
                        label="Equipo"
                      ></v-text-field>
                     </v-col>
                     <v-col cols="12" md="6">
                     <v-text-field
                       append-icon="mdi-folder-outline"
                       v-model="alquiler.cantidad"
                       type="number"
                       @keyup="errorsCantidad = []"
                       :rules="[v => !!v || 'Cantidad Es Requerida',
                       v => (v && v.length <= 6) || 'El valor no debe tener mas de 6 caracteres']"
                       label="Cantidad"
                      ></v-text-field>
                         </v-col>
                       </v-row> 
                       <v-row>
                        <v-col cols="12" md="6">
                        <v-textarea
                            label="Propietario"
                            no-resize
                            rows="1"
                            v-model="alquiler.propietario"
                            @keyup="errorsPropietario = []"
                            :rules="[v => !!v || 'Propietario Es Requerido']"
                            required
                            :error-messages="errorsNombre"
                          ></v-textarea>
                          </v-col>
                            <v-col cols="12" md="6">
                                <v-select
                                   v-model="alquiler.proyecto_id"
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
                  <v-card-actions>
                    <div class="flex-grow-1"></div>
                    <v-btn color="red darken-1" text @click="cerrarModal">Cerrar</v-btn>
                    <v-btn
                      color="info darken-1"
                      :disabled="!validForm"
                      @click="saveAlquiler()"
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
                 @click="deleteAlquiler(item)"
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
      arrayAlquileres: [],
      arrayProyectos: [],
      hTBAlquileres: [
        { text: "Equipo", value: "equipo" },
        { text: "Cantidad", value: "cantidad" },
        { text: "Fecha Alquiler", value: "fecha" },
        { text: "Fecha Devuelto", value: "fecha_devuelto" },
        { text: "Propietario", value: "propietario"},
        { text: "Proyecto", value: "proyecto" },
        { text: "Acciones", value: "action", sortable: false, align: "center" }
      ],
      loader: false,
      search: "",
      dialog: false,
      alquiler: {
        id: null,
        equipo: "",
        cantidad: "",
        fecha: "",
        fecha_devuelto: "",
        propietario: "",
        proyecto_id: null,
        proyecto: null
      },
      validForm: true,
      snackbar: false,
      msjSnackBar: "",
      errorsNombre: [],
      editedAlquiler: -1
    };
  },
  computed: {
    formTitle() {
      return this.alquiler.id === null
        ? "Agregar  Alquiler"
        : "Actualizar Alquiler";
    },
    btnTitle() {
      return this.alquiler.id === null ? "Guardar" : "Actualizar";
    }
  },
  methods: {

    fetchAlquileres() {
      let me = this;
      me.loader = true;
      axios.get(`/alquileres/all`)
        .then(function(response) {
          me.arrayAlquileres = response.data;
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
        me.alquiler = {
            id: null,
            equipo: "",
            cantidad: "",
            fecha: "",
            fecha_devuelto: "",
            propietario: "",
            proyecto_id: null,
            proyecto: null,
        };
        me.resetValidation();
      }, 300);
    },
    resetValidation() {
      let me = this;
      me.errorsNombre = [];
      me.$refs.formAlquiler.resetValidation();
    },
    showModalEditar(alquiler) {
      console.log(alquiler);
      let me = this;
      me.editedAlquiler = me.arrayAlquileres.indexOf(alquiler);
      me.alquiler = Object.assign({}, alquiler);
      me.dialog = true;
    },

    saveAlquiler() {
      let me = this;
      if (me.$refs.formAlquiler.validate()) {
        let accion = me.alquiler.id == null ? "add" : "upd";
        me.loader = true;
        if(accion=="add"){
            axios.post(`alquileres/save`,me.alquiler)
            .then(function(response) {
                 me.verificarAccionDato(response.data, response.status, accion);
                 me.cerrarModal(); 
             })
            .catch(function(error){
                if(error.response.status == 409){
                   me.setMessageToSnackBar("El alquiler ya existe",true);
                   me.errorsNombre = ["Nombre de alquiler existente", "error"];
                }else{
                   Vue.swal("Error", "Ocurrio un error intente de nuevo","error"); 
                }
            })
        }else{
            //para actualizar
              axios.put(`/alquileres/update`,me.alquiler)
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
    
    deleteAlquiler(alquiler) {
      let me = this;
      me.editedAlquiler = me.arrayAlquileres.indexOf(alquiler);
      
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
        console.log(alquiler);
        Vue.swal.fire({
        title: 'Eliminar Alquiler',
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
            console.log(alquiler);
            axios.post(`alquileres/delete`,alquiler)
            .then(function(response) {
              console.log(response.data);
              me.verificarAccionDato(response.data.data, response.status, "del");
              me.loader = false;
            })
          }
        });
    },
     verificarAccionDato(alquiler, statusCode, accion) {
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
          this.fetchAlquileres(); 
          Toast.fire({
            icon: 'success',
            title: 'Alquiler Registrado con Exito'
           });
          me.loader = false;
          break;
        case "upd":
         
          this.fetchAlquileres(); 
          Toast.fire({
            icon: 'success',
            title: 'Alquiler Actualizado con Exito'
           }); 
            
          me.loader = false;
          break;
        case "del":
          if (statusCode == 200) {
            try {
              //Se elimina del array de alquileres Activos si todo esta bien en el backend
              me.arrayAlquileres.splice(me.editedAlquiler, 1);
              //Se Lanza mensaje Final
              Toast.fire({
                icon: 'success',
                title: 'Alquiler Eliminado...!!!'
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
    me.fetchAlquileres();
    me.fetchProyectos();
  }
};
</script>