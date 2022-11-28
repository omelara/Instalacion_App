 <template>
  <div class="content">
    <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100">
      <v-overlay :value="loader" :z-index="'99999999'">
        <v-progress-circular indeterminate size="80" color="grey darken-4"></v-progress-circular>
      </v-overlay>
      <v-card>
        <v-card-title>
          {{titleList}}
          <div class="flex-grow-1"></div>
          
          <v-text-field v-model="search" label="Buscar" hide-details></v-text-field>
        </v-card-title>
        <v-data-table
          :headers="hTBPrestamos"
          :items="arrayPrestamos"
          :footer-props="{
            'items-per-page-options': [10, 20, 30,40],
            'items-per-page-text' : 'Registros Por Página'
          }"
          :items-per-page="10"
          :search="search"
          multi-sort
          class="elevation-1"
        >
          <template v-slot:top>
            <v-toolbar flat color="white">
                <v-checkbox v-model="mostrarPrestamos" class="mx-6" label="Préstamos" >value="false"</v-checkbox>  
                <v-checkbox v-model="mostrarAnulados" class="mx-6" label="Anulados" >value="false"</v-checkbox>  
               <v-checkbox v-model="mostrarDevoluciones" class="mx-6" label="Devoluciones" >value="false"</v-checkbox>
            <div class="flex-grow-1"></div>
            </v-toolbar>
          </template>

          <!-- template para las acciones -->
          <template v-slot:item.action="{item}">
            <v-tooltip top>
              <template v-slot:activator="{ on }">
                <v-btn
                  elevation="10"
                  :to="{name: 'prestamos.form', params: { prestamo:item, action : 'detail' } }"
                  color="success"
                  class="white--text mx-1"
                  small
                  v-on="on"
                >
                  <v-icon>pageview</v-icon>
                </v-btn>
              </template>
              <span>Ver Prestamos</span>
            </v-tooltip>
             <v-tooltip top>
              <template v-slot:activator="{ on }">
                <v-btn v-if="estado=='R'"
                  elevation="10"
                  color="#11992a"
                  class="white--text"
                  small
                  @click="cambiarEstado(item,'P')"
                  v-on="on"
                >
                  <v-icon>check</v-icon>
                </v-btn>
              </template>
              <span>Prestar</span>
            </v-tooltip>
            <v-tooltip top>
              <template v-slot:activator="{ on }">
                <v-btn v-if="estado=='R'"
                  color="red"
                  class="mx-1 white--text"
                  elevation="8"
                  small
                  v-on="on"
                  @click="cambiarEstado(item,'A')"
                >
                  <v-icon>close</v-icon>
                </v-btn>
              </template>
              <span>Anular</span>
            </v-tooltip>
            <v-tooltip top>
              <template v-slot:activator="{ on }">
                <v-btn v-if="estado=='C'"
                  color="deep-orange"
                  class="mx-1 white--text"
                  elevation="8"
                  small
                  v-on="on"
                  @click="cambiarEstado(item,'D')"
                >
                  <v-icon>mdi-cached</v-icon>
                </v-btn>
              </template>
              <span>Devolver</span>
            </v-tooltip>
          </template>
        </v-data-table>
      </v-card>
    </div>
  </div>
</template>
<script>
export default {
  name: "ListadoPrestamos",
  data: () => ({
    arrayPrestamos: [],
    hTBPrestamos: [
      { text: "No Préstamo", value: "correlativo" },
      { text: "Fecha Préstamo", value: "fecha_prestamo" },
      { text: "Fecha Devuelto", value: "fecha_devuelto" },
      //{ text: "Proyecto Orígen", value: "proyecto_origen" },
      //{ text: "Proyecto Destino", value: "proyecto_destino" },
      { text: "User", value: "name" },
      
      { text: "Acciones", value: "action", sortable: false, align: "center" }
    ],
    loader: false,
    search: "",
    estado:"R",
    mostrarPrestamos:false,
    mostrarAnulados:false,
    mostrarDevoluciones:false,
    mes: null,
    anio : null,
    titleList:"Listado de préstamos"
  }),
  watch:{
       mostrarPrestamos() {
        let me = this;
        if(me.mostrarPrestamos) {
            me.estado = 'P';
            me.titleList = "Listado de préstamos";
        }else{
            me.estado = 'R';
            me.titleList = "Listado de préstamos";
        }
        me.fetchPrestamos(me.estado);
      },
      mostrarAnulados() {
        let me = this;
        if(me.mostrarAnulados) {
            me.estado = 'A';
            me.titleList = "Listado de préstamos Anulados";
        }else{
            me.estado = 'R';
            me.titleList = "Listado de préstamos";
        }
        me.fetchPrestamos(me.estado);
      },
      mostrarDevoluciones() {
        let me = this;
        if(me.mostrarDevoluciones) {
            me.estado = 'D';
            me.titleList = "Listado de Devoluciones";
        }else{
            me.estado = 'R';
            me.titleList = "Listado de préstamos";
        }
        me.fetchPrestamos(me.estado);
      },
  },
  computed: {},
  methods: {
    fetchPrestamos(estado) {
      let me = this, state = estado;
      me.loader = true;
      axios.get(`/prestamos/state?state=`+me.estado)
        .then(function(response) {
          if(Object.keys(response.data).length==0){
              me.arrayPrestamos = [];
          }else{
              me.arrayPrestamos = response.data;
          }
          me.loader = false;
        })
        .catch(function(error) {
          me.loader = false;
          console.log(error);
        });
       me.loader = false;
    },
    contructFecha(){
      let me = this;
      if(me.mes != null && me.anio != null){
          let fecha = me.mes +"-"+ me.anio;
          return me.$moment(fecha, "DD-MM-YYYY").toDate();
      }else{
        return null;
      }
    },
    cambiarEstado(prestamo,estado) {
      let me = this;
      prestamo.estado = estado;
      const Toast = Vue.swal.mixin({
        toast: true,
        position: "bottom-end",
        showConfirmButton: true,
        timer: 8000
      });

      Vue.swal({
        title: "Esta Seguro/a de realiar esta acción?",
        text:
          "Una vez realizada la operación el registro desaparecerá de la tabla",
        type: "question",
        showCancelButton: true,
        confirmButtonText: "Si",
        cancelButtonText: "No",
        reverseButtons: true,
        focusConfirm: false,
        focusCancel: true,
        showCloseButton: true
      }).then(result => {
        if (result.value) {
          me.loader = true;
          axios.put(`prestamos/change`, prestamo)
            .then(function(response) {
              me.loader = false;
              if (response.status == 200) {
                Vue.swal(
                  "Confirmado",
                  "La operación ha sido realizada con Exito",
                  "success"
                );
                let estado = "R";
                me.fetchPrestamos(estado);   
              }
            })
            .catch(function(error) {
              console.log(error);  
              me.loader = false;
              Toast.fire({
                type: "error",
                title: "Ocurrio Un Error Intente Nuevamente"
              });
            });
        }
      });
    }
  },
  mounted() {
    let me = this;
    me.fetchPrestamos(me.estado);
  }
};
</script>
