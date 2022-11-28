<template>
  <div class="content">
    <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100">
      <v-overlay :value="loader" :z-index="'99999999'">
        <v-progress-circular indeterminate size="80" color="grey darken-4"></v-progress-circular>
      </v-overlay>
      <v-card>
        <v-card-title>
          Listado de compras
          <div class="flex-grow-1"></div>
          <v-text-field v-model="search" label="Buscar" hide-details></v-text-field>
        </v-card-title>
        <v-data-table
          :headers="hTBCompras"
          :items="arrayCompras"
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
                <v-btn small elevation="4" color="#B22222" dark class="mb-2" href="compras/pdf" target="_blank ">
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
                      <v-form style="background-color:" class="card-header text-center" ref="formCompra" v-model="validForm" :lazy-validation="true">
                        <v-row>
                        <v-col cols="12" md="6">
                        <date-picker
                          v-model="compra.fecha"
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
                        <v-text-field
                          append-icon="mdi-folder-outline"
                          v-model="compra.comprobante"
                          @keyup="errorsComprobante = []"
                          :rules="[v => !!v || 'Comprobante Es Requerido',
                          v => Number(v) > 0 || 'El valor tiene que ser mayor a 0 y sin letras',
                          v => (v && v.length <= 10) || 'El valor no debe tener mas de 10 caracteres']"
                          label="Comprobante "
                          required
                          :error-messages="errorsNombre"
                        ></v-text-field>
                        </v-col>

                        </v-row>
                        <v-row>
                        <v-col cols="12" md="6">
                        <v-text-field
                          append-icon="mdi-folder-outline"
                          v-model="compra.precio"
                          @keyup="errorsPrecio = []"
                          :rules="[v => !!v || 'Precio Es Requerido',
                          v => Number(v) > 0 || 'El valor tiene que ser mayor a 0 y sin letras',
                          v => (v && v.length <= 10) || 'El valor no debe tener mas de 10 caracteres']"
                          label="Precio"
                          required
                          :error-messages="errorsNombre"
                        ></v-text-field>
                        </v-col>
                        <v-col cols="12" md="6">
                        <v-text-field
                          append-icon="mdi-folder-outline"
                          v-model="compra.cantidad"
                          type="number"
                          @keyup="errorsCantidad = []"
                          :rules="[v => !!v || 'Cantidad Es Requerida',
                          v => (v && v.length <= 6) || 'El valor no debe tener mas de 6 caracteres']"
                          label="Cantidad"
                          required
                          :error-messages="errorsNombre"
                        ></v-text-field>
                        </v-col>
                        </v-row>
                        
                         <v-row>
                           <v-col cols="12" md="6">
                                <v-select
                                    v-model="compra.equipo_id"
                                    :items="arrayEquipos"
                                    label="Seleccione Equipo"
                                    item-value="id"
                                    item-text="nombre"
                                    :rules="[v => !!v || 'Equipo Es Requerido']"
                                  ></v-select>
                            </v-col>
                            <v-col cols="12" md="6">
                                <v-select
                                    v-model="compra.proveedor_id"
                                    :items="arrayProveedores"
                                    label="Seleccione Proveedor"
                                    item-value="id"
                                    item-text="nombre"
                                    :rules="[v => !!v || 'Proveedor Es Requerido']"
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
                      @click="saveCompra()"
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
                  @click="deleteCompra(item)"
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
      arrayCompras: [],
      arrayEquipos: [],
      arrayProveedores: [],
      hTBCompras: [
        { text: "Fecha", value: "fecha" },
        { text: "Comprobante", value: "comprobante" },
        { text: "Precio $", value: "precio" },
        { text: "Cantidad", value: "cantidad" },
        { text: "Equipo", value: "equipo" },
        { text: "Proveedor", value: "proveedor"},
        { text: "Acciones", value: "action", sortable: false, align: "center" }
      ],
      loader: false,
      search: "",
      dialog: false,
      compra: {
        id: null,
        fecha: "",
        comprobante: "",
        precio: "",
        cantidad: "",
        equipo_id: null,
        equipo: null,
        proveedor_id: null,
        proveedor: null
      },
      validForm: true,
      snackbar: false,
      msjSnackBar: "",
      errorsNombre: [],
      editedCompra: -1
    };
  },
  computed: {
    formTitle() {
      return this.compra.id === null
        ? "Agregar Compra"
        : "Actualizar Compra";
    },
    btnTitle() {
      return this.compra.id === null ? "Guardar" : "Actualizar";
    }
  },
  methods: {

    fetchCompras() {
      let me = this;
      me.loader = true;
      axios.get(`/compras/all`)
        .then(function(response) {
          me.arrayCompras = response.data;
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

    fetchProveedores() {
      let me = this;
      me.loader = true;
      axios.get(`/proveedores/all`)
        .then(function(response) {
          me.arrayProveedores = response.data;
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
        me.compra = {
            id: null,
            fecha: "",
            comprobante: "",
            precio: "",
            cantidad: "",
            equipo_id: null,
            equipo: null,
            proveedor_id: null,
            proveedor: null,
        };
        me.resetValidation();
      }, 300);
    },
    resetValidation() {
      let me = this;
      me.errorsNombre = [];
      me.$refs.formCompra.resetValidation();
    },
    showModalEditar(compra) {
      console.log(compra);
      let me = this;
      me.editedCompra = me.arrayCompras.indexOf(compra);
      me.compra = Object.assign({}, compra);
      me.dialog = true;
    },

     saveCompra() {
      let me = this;
      if (me.$refs.formCompra.validate()) {
        let accion = me.compra.id == null ? "add" : "upd";
        me.loader = true;
        if(accion=="add"){
            axios.post(`compras/save`,me.compra)
            .then(function(response) {
                 me.verificarAccionDato(response.data, response.status, accion);
                 me.cerrarModal(); 
             })
            .catch(function(error){
                if(error.response.status == 409){
                   me.setMessageToSnackBar("La compra ya existe",true);
                   me.errorsNombre = ["Nombre de compra existente", "error"];
                }else{
                   Vue.swal("Error", "Ocurrio un error intente de nuevo","error"); 
              }
            })
        }else{
            //para actualizar
              axios.put(`/compras/update`,me.compra)
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
    
    deleteCompra(compra) {
      let me = this;
      me.editedCompra = me.arrayCompras.indexOf(compra);
      
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
        console.log(compra);
        Vue.swal.fire({
        title: 'Eliminar Compra',
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
            console.log(compra);
            axios.post(`compras/delete`,compra)
            .then(function(response) {
              console.log(response.data);
              me.verificarAccionDato(response.data.data, response.status, "del");
              me.loader = false;
            })
          }
        });
    },
     verificarAccionDato(compra, statusCode, accion) {
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
          this.fetchCompras(); 
          Toast.fire({
            icon: 'success',
            title: 'Compra Registrada con Exito'
           });
          me.loader = false;
          break;
        case "upd":

          this.fetchCompras(); 
          Toast.fire({
            icon: 'success',
            title: 'Compra  Actualizada con Exito'
           }); 
            
          me.loader = false;
          break;
        case "del":
          if (statusCode == 200) {
            try {
           
              me.arrayCompras.splice(me.editedCompra, 1);
              //Se Lanza mensaje Final
              Toast.fire({
                icon: 'success',
                title: 'Compra Eliminada...!!!'
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
    me.fetchCompras();
    me.fetchEquipos();
    me.fetchProveedores();
  }
};
</script>