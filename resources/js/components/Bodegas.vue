<template>
  <div class="content">
    <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100">
      <v-overlay :value="loader" :z-index="'99999999'">
        <v-progress-circular indeterminate size="80" color="grey darken-4"></v-progress-circular>
      </v-overlay>
      <v-card>
        <v-card-title>
         Equipo en bodega
          <div class="flex-grow-1"></div>
          <v-text-field v-model="search" label="Buscar" hide-details></v-text-field>
        </v-card-title>
        <v-data-table
          :headers="hTBBodegas"
          :items="arrayBodegas"
          :footer-props="{
            'items-per-page-options': [5,10, 20, 30,40],
            'items-per-page-text' : 'Registros Por Página'
          }"
          :items-per-page="5"
          :search="search"
          multi-sort
          class="elevation-1"
        >
          <!-- Template Para Modal de Actualizar y Agregar productos-->

          <template v-slot:top>
            <v-toolbar flat color="white">

             <div class="flex-grow-1">
                <v-btn small elevation="4" color="#B22222" dark class="mb-2" href="bodegas/pdf" target="_blank ">
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
                    <v-container >
                      <v-form style="background-color:" class="card-header text-center" ref="formBodega" v-model="validForm" :lazy-validation="true">
                        <v-row>
                        <v-col cols="12" md="6">
                         <v-text-field
                          append-icon="mdi-folder-outline"
                          v-model="bodega.cantidad"
                          type="number"
                          label="Cantidad"
                          @keyup="errorsNombre = []"
                          :rules="[v => !!v || 'Cantidad Es Requerida',
                          v => (v && v.length <= 20) || 'El nombre debe tener maximo 20 caracteres']"
                        ></v-text-field>
                        </v-col>
                        <v-col cols="12" md="6">
                         <v-text-field
                          append-icon="mdi-folder-outline"
                          v-model="bodega.descripcion"
                          label="Descripción"
                         @keyup="errorsNombre = []"
                        :rules="[v => !!v || 'Descripción Es Requerida',
                         v => (v && v.length <= 100) || 'El nombre debe tener maximo 100 caracteres']"
                        ></v-text-field>
                        </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12" md="6">
                                <v-select
                                    v-model="bodega.equipo_id"
                                    :items="arrayEquipos"
                                    label="Seleccione Equipo"
                                    item-value="id"
                                    item-text="nombre"
                                    :rules="[v => !!v || 'Nombre Es Requerido']"
                                ></v-select>
                            </v-col>
                            <v-col cols="12" md="6">
                                <v-select
                                    v-model="bodega.marca_id"
                                    :items="arrayMarcas"
                                    label="Seleccione Marca"
                                    item-value="id"
                                    item-text="nombre"
                                    :rules="[v => !!v || 'Nombre Es Requerida']"
                                  ></v-select>
                            </v-col>
                        </v-row>
                         <v-col cols="12" md="6">
                         <v-text-field
                          append-icon="mdi-folder-outline"
                          v-model="bodega.codigo"
                          label="Código"
                          :rules="[v => !!v || 'Código Es Requerido',
                          v => (v && v.length <= 10) || 'El nombre debe tener maximo 10 caracteres']"
                        ></v-text-field>
                        </v-col>
                        
                      </v-form>
                    </v-container>
                  </v-card-text>
                  <v-card-actions>
                    <div class="flex-grow-1"></div>
                    <v-btn color="red darken-1" text @click="cerrarModal">Cerrar</v-btn>
                    <v-btn
                      color="info darken-1"
                      :disabled="!validForm"
                      @click="saveBodega()"
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
                  @click="deleteBodega(item)"
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
      arrayBodegas: [],
      arrayEquipos: [],
      arrayMarcas: [],
      hTBBodegas: [
        { text: "Cantidad", value: "cantidad" },
        { text: "Descripción", value: "descripcion" },
        { text: "Estado", value: "estado"},
        { text: "Código", value: "codigo" },
        { text: "Equipo", value: "equipo" },
        { text: "Marca", value: "marca" },
        { text: "Acciones", value: "action", sortable: false, align: "center" }
      ],
      loader: false,
      search: "",
      dialog: false,
      bodega: {
        id: null,
        cantidad: "",
        descripcion: "",
        estado: "",
        codigo: "",
        equipo_id: null,
        equipo: null,
        marca_id: null,
        marca: null
      },
      validForm: true,
      snackbar: false,
      msjSnackBar: "",
      errorsNombre: [],
      editedBodega: -1
    };
  },
  computed: {
    formTitle() {
      return this.bodega.id === null
        ? "Agregar a Bodega"
        : "Actualizar a Bodega";
    },
    btnTitle() {
      return this.bodega.id === null ? "Guardar" : "Actualizar";
    }
  },

  methods: {
    fetchBodegas() {
      let me = this;
      me.loader = true;
      axios.get(`/bodegas/all`)
        .then(function(response) {
          me.arrayBodegas = response.data;
          me.loader = false;
        })
        .catch(function(error) {
          me.loader = false;
          console.log(error);
        });
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

    fetchMarcas() {
      let me = this;
      me.loader = true;
      axios.get(`/marcas/all`)
        .then(function(response) {
          me.arrayMarcas = response.data;
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
        me.bodega = {
            id: null,
            cantidad: "",
            descripcion: "",
            estado: "",
            codigo: "",
            equipo_id: null,
            equipo: null,
            marca_id: null,
            marca: null
        };
        me.resetValidation();
      }, 300);
    },
    resetValidation() {
      let me = this;
      me.errorsNombre = [];
      me.$refs.formBodega.resetValidation();
    },
    showModalEditar(bodega) {
      console.log(bodega);
      let me = this;
      me.editedBodega = me.arrayBodegas.indexOf(bodega);
      me.bodega = Object.assign({}, bodega);
      me.dialog = true;
    },
    saveBodega() {
      let me = this;
      if (me.$refs.formBodega.validate()) {
        let accion = me.bodega.id == null ? "add" : "upd";
        me.loader = true;
        if(accion=="add"){
          me.bodega.estado = "D";
           axios.post('bodegas/save',me.bodega)
            .then(function (response) {
             // console.log(response.statusText);
              if(response.status==201){
              me.verificarAccionDato(response.data, response.status, accion);
              me.cerrarModal();
              }
            })
            .catch(function(error){
              Vue.swal("Error", "Ocurrio Un Error Intente Nuevamente", "error");
            });
            me.loader = false;
        }else{
            //para actualizar
            axios.put(`bodegas/update`,me.bodega)
               .then(function(response) {
              if(response.status==202){
              me.verificarAccionDato(response.data, response.status, accion);
              me.cerrarModal();
              }
            })
            .catch(function(error){
              Vue.swal("Error", "Ocurrio Un Error Intente Nuevamente", "error");
            });
            me.loader = false;
        }
      
      }
    },
    deleteBodega(bodega) {
      let me = this;
      me.editedBodega = me.arrayBodegas.indexOf(bodega);
      
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
        console.log(bodega);
        Vue.swal.fire({
        title: 'Eliminar bodega',
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
            console.log(bodega);
            axios.post(`bodegas/delete`,bodega)
            .then(function(response) {
              console.log(response.data);
              me.verificarAccionDato(response.data.data, response.status, "del");
              me.loader = false;
            })
          }
        });
    },
     verificarAccionDato(bodega, statusCode, accion) {
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
        
          this.fetchBodegas(); 
          Toast.fire({
            icon: 'success',
            title: 'Bodega Registrada con Exito'
           });
          me.loader = false;
          break;
        case "upd":
          //Actualizo al array de categorias el objecto que devuelve el Backend ya con los datos actualizados
          
          this.fetchBodegas(); 
          Toast.fire({
            icon: 'success',
            title: 'Bodega Actualizada con Exito'
           }); 
            
          me.loader = false;
          break;
        case "del":
          if (statusCode == 200) {
            try {
              //Se elimina del array de Categorias Activos si todo esta bien en el backend
              me.arrayBodegas.splice(me.editedBodega, 1);
              //Se Lanza mensaje Final
              Toast.fire({
                icon: 'success',
                title: 'Bodega Eliminada...!!!'
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
    me.fetchBodegas();
    me.fetchEquipos();
    me.fetchMarcas();
  }
};
</script>