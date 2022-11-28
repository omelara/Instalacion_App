 <template>
  <div class="content">
    <div
      class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100"
    >
      <v-overlay :value="loader" :z-index="'99999999'">
        <v-progress-circular
          indeterminate
          size="80"
          color="grey darken-4"
        ></v-progress-circular>
      </v-overlay>
      <!--//cambio color de formulRIO DE PRESTAMO-->
      <v-card class="text-primary" color="bg-black">
        <v-card-title class="bg-white"
          v-text="
            action == 'add'
             //cambio-- esto  'Formulario De Solicitud De Prestamos' en  ''>
              ? 'Solicitud De Prestamos'
              : action == 'upd'
              ? 'Actualización de Prestamos'
              : 'Detalle de Reserva de Prestamos'
          "
           
        >
          <div class="flex-grow-1"></div>
          <v-text-field
            v-model="search"
            label="Buscar"
            hide-details
          ></v-text-field>
        </v-card-title>
        <v-container fluid>
          <v-form
            ref="formPrestamo"
            v-model="validForm"
            :lazy-validation="true"
          >             
            <v-row class="bg-white">
              <v-col cols="12" md="12" lg="12" sm="12">
                <v-col cols="12" md="12">
                  <v-alert
                    :value="noBodegas"
                    type="error"
                    border="left"
                    transition="scale-transition"
                    dismissible
                    elevation="2"
                    >Debe Agregar uno o mas Prestamos a la transaccion</v-alert
                  >
                </v-col>
              </v-col>
              <v-col cols="12" md="12" lg="12" sm="12">
                <v-card outlined>
                  <v-card-title class="mb-4 font-weight-medium subtitle-1">
                    Detalle del Prestamo
                    <div class="flex-grow-1"></div>
                    <v-text-field
                      v-model="searchInDetail"
                      label="Buscar"
                      hide-details
                    ></v-text-field>
                  </v-card-title>
                  <!-- bg-black para border del formulario del prestamo-->
                  <v-card-text class="bg-black" >
                      <template v-slot:top>
                        <v-toolbar flat color="grey">
                          <div class="flex-grow-1"></div>
                          <!-- MODAL PARA BODEGAS  -->
                          <v-dialog 
                            v-model="modalBodegas"
                            persistent
                            max-width="1150px"
                            scrollable
                          >
                            <template v-slot:activator="{ on }">
                              <v-btn
                                elevation="10"
                                color="black"
                                dark
                                v-if="action != 'detail'"
                                class="mb-2"
                                v-on="on"
                              >
                                Agregar bodega&nbsp;
                                <v-icon>library_add</v-icon>
                              </v-btn>
                            </template>
                            <v-card>
                              <v-card-title
                                class="headline grey lighten-2"
                                primary-titles
                              >
                                <span
                                  class="headline"
                                  v-text="formTitle"
                                ></span>
                              </v-card-title>
                              <v-card-text>
                                <BodegaList
                                  v-on:created="getItemsOfBodegasOfPrestamo()"
                                  @added="onAddedItem"
                                  ref="bodega"
                                />
                              </v-card-text>
                              <v-divider></v-divider>
                              <v-card-actions>
                                <div class="flex-grow-1"></div>
                                <v-btn
                                  color="red darken-1"
                                  text
                                  @click="modalBodegas = false"
                                  >Cerrar</v-btn
                                >
                                <v-btn
                                  color="primary"
                                  @click="getBodegaFromChild()"
                                  text
                                  v-text="'Agregar a prestamo'"
                                ></v-btn>
                              </v-card-actions>
                            </v-card>
                          </v-dialog>
                        </v-toolbar>
                      </template>
                      <!-- FIN DE MODAL PARA BODEGAS -->

                      <template v-slot:item="props">
                        <tr :key="props.item.id">
                          <td v-text="props.item.bodega.cantidad"/>
                          <td v-text="props.item.bodega.descripcion"/>
                          <td v-text="props.item.bodega.codigo" />
                          <td v-text="props.item.bodega.equipo" />
                          <td v-text="props.item.bodega.marca" />

                          <td class="text-center">
                            <v-btn
                              :disabled="!validForm"
                              color="red"
                              class="mx-1"
                              elevation="8"
                              v-if="action != 'detail'"
                              small
                              dark
                              @click="deleteBodegaFromPrestamo(props.item)"
                            >
                              <v-icon>delete</v-icon>
                            </v-btn>
                          </td>
                        </tr>
                      </template>

                      <template v-slot:body.append>
                        <tr class="grey lighten-5">
                          <td colspan="5">
                            <v-row v-if="action != 'detail'">
                              <v-col
                                cols="12"
                                class="d-flex flex-row-reverse"
                                md="12"
                              >
                                <v-btn
                                  :disabled="!validForm"
                                  @click="saveOrUpdate()"
                                  dark
                                  large
                                  color="black"
                                >
                                  {{
                                    action == "add"
                                      ? "Guardar Prestamo"
                                      : action == "upd"
                                      ? "Actualizar Prestamo"
                                      : ""
                                  }}&nbsp;
                                  <v-icon>save</v-icon>
                                </v-btn>
                              </v-col>
                            </v-row>
                          </td>
                        </tr>
                      </template>
                    </v-data-table>
                  </v-card-text>
                </v-card>
              </v-col>
            </v-row>
          </v-form>
        </v-container>
      </v-card>
    </div>
  </div>
</template>
<script>
import Vue from 'vue';
import BodegaList from "./BodegaList.vue";
export default {
  name: "PrestamoForm",
  props:['user'],
  //props: ["prestamo", "action"],
  data() {
    return {
      search: "",
      loader: false,
      fecha: null,
      prestamoForm: {
        id: null,

      },
      action:"add",
      headerTable: [
        { text: "Cantidad", value: "bodega.cantidad", align: "left" },
        { text: "Descripcion", value: "bodega.descripcion", align: "left" },
        { text: "Codigo", value: "bodega.codigo", align: "left" },
        { text: "Equipo", value: "bodega.equipo", align: "left" },
        { text: "Marca", value: "bodega.marca", align: "left" },
        { text: "Acción", value: "action", sortable: false, align: "center" },
      ],
      modalBodegas: false,
      validForm: true,
      noBodegas: false,
      accion: "",
      searchInDetail: "",
      formatted: "",
      loader: false,
      formTitle: "Agregar Items a Transaccion",
      date: new Date(Date.now() - new Date().getTimezoneOffset() * 60000)
        .toISOString()
        .substr(0, 10),
    };
  },
  computed: {},
  methods: {
    onAddedItem(value) {
      let me = this;
      if (value.length > 0) {
        me.formTitle = "Agregar Items a Transaccion";
      }
    },
    getItemsOfBodegasOfPrestamo() {
      let me = this,
        bodegas = [];
      me.prestamoForm.bodegas.map((detalle) => bodegas.push(detalle.bodega));
      me.$refs.bodega.item = bodegas;
    },
    getBodegaFromChild() {
      let me = this;
      me.$refs.bodega.item.forEach(function (bodega) {
        if (!me.containsObject(bodega, me.prestamoForm.bodegas)) {
          me.prestamoForm.bodegas.push({
            id: null,
            bodega: bodega,
          });
        }
      });
      me.modalBodegas = false;
    },
    containsObject(obj, list) {
      return list.some(
        (item) => JSON.stringify(item.bodega) === JSON.stringify(obj)
      );
    },
    //quitar un item del detalle
    deleteBodegaFromPrestamo(item) {
      let me = this,
        index;
      index = me.prestamoForm.bodegas.indexOf(item);
      me.prestamoForm.bodegas.splice(index, 1);
    },
    
    //guardar la reserva
   saveOrUpdate() {
      let me = this;
      if (me.$refs.formPrestamo.validate()) {
        if (me.prestamoForm.bodegas.length == 0) {
          me.noBodegas = true;
          me.validForm = false;
        } else {
          me.prestamoForm.user = this.user;
          console.log(me.prestamoForm);
          me.loader = true;
          axios.post(`/prestamos/save`, me.prestamoForm)
            .then(function (response) {
              console.log(response.data);
              if (response.status == 201) {
              } else {
                Vue.swal("Ok", "Prestamo registrado con exito", "success");
              }
              me.loader = false;
            })
           .catch(function (errror){
            Vue.swal(
                "Error", "Error al registrar el prestamo, intente de nuevo", "error");
           });
        }
      }
    },
  },

  components: {
    BodegaList,
  },
  mounted() {
    console.log(this.user);
  },
};
</script>
<style scope>
.centered-input >>> input {
  text-align: center;
}
</style>