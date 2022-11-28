<template>
  <v-container>
    <v-row>
      <div class="flex-grow-1"></div>
      <v-text-field v-model="search" label="Buscar Bodega" hide-details />
      <v-col cols="12" md="12" sm="12" lg="12">
        <v-data-table
          :headers="hTBBodegas"
          :items.sync="arrayBodegas"
          :items-per-page="10"
          :footer-props="{
            'items-per-page-options': [5, 10, 15, 20],
          }"
          :search="search"
          :single-select="false"
          show-select
          v-model="item"
          :dense="true"
          multi-sort
        >
        </v-data-table>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
export default {
  data: () => ({
    item: {},
    arrayBodegas: [],
    hTBBodegas: [
      { text: "Cantidad", value: "cantidad" },
      { text: "Descripcion", value: "descripcion" },
      { text: "Codigo", value: "cantidad" },
      { text: "Equipo", value: "equipo" },
      { text: "Marca", value: "marca" },
    ],

    loader: false,
    modalBodegas: false,
    errorsNombre: [],
    search: "",
    editedBodega: -1,
    alert: false,
    BodegasCb: true,
    loadData: false,
  }),
  watch: {
    item: function () {
      this.$emit("added", this.item);
    },
  },
  computed: {},
  methods: {
    fetchBodegas() {
      let me = this;
      return axios.get(`/bodegas/all`);
    },
    fetchData() {
      let me = this;
      me.loader = true;
      axios
        .all([me.fetchBodegas()])
        .then(
          axios.spread((bodegas) => {
            me.arrayBodegas = bodegas.data;
            me.loader = false;
          })
        )
        .catch(function (error) {
          console.log(error);
          me.loader = false;
          Vue.swal("Error", "Ocurrio Un Error Intente Nuevamente", "error");
        });
    },
  },
  components: {},
  mounted() {
    let me = this;
    me.fetchData();
    me.$emit("created");
  },
};
</script>
