<template>
    <v-data-table
    color="info"
    :headers="headers"
    :items="desserts"
    :items-per-page="20"
    class="elevation-1"
    ></v-data-table>
</template>
<script>
export default {
    props:['user'],
    data () {
        return {
            headers:[
                {
                 text: 'Dessert  ',
                 align: 'start',
                 sortable: false,
                 value: 'name',
                },
               { text: "Cantidad", value: "cantidad" },
               { text: "Descripción", value: "descripcion" },
               { text: "Estado", value: "estado"},
               { text: "Código", value: "codigo" },
               { text: "Equipo", value: "equipo" },
               { text: "Marca", value: "marca" },
            ],
            desserts: [
                {
                    name: 'Frozen Yogurt',
                    calories: 159,
                    fat: 6.0,
                    carbs: 24,
                    protein: 4.0,
                    iron: '1%',
                },
                {
                    name: 'Eclair',
                    calories: 262,
                    fat: 16.0,
                    carbs: 23,
                    protein: 6.0,
                    iron: '7%',  
                },
                {
                    name: 'Cupcake',
                    calories: 305,
                    fat: 3.7,
                    carbs: 67,
                    protein: 4.0,
                    iron: '9%',  
                },
                {
                    name: 'Gingerbread',
                    calories: 356,
                    fat: 16.0,
                    carbs: 49,
                    protein: 3.9,
                    iron: '16%',  
                },
                {
                    name: 'Jelly bean',
                    calories: 375,
                    fat: 0.0,
                    carbs: 94,
                    protein: 0.0,
                    iron: '0%',  
                },
                {
                    name: 'Lollipop',
                    calories: 392,
                    fat: 0.2,
                    carbs: 98,
                    protein: 0,
                    iron: '2%',  
                },
                {
                    name: 'Honeycomb',
                    calories: 408,
                    fat: 3.2,
                    carbs: 87,
                    protein: 6.2,
                    iron: '45%',  
                },
                {
                    name: 'Donut',
                    calories: 452,
                    fat: 25.0,
                    carbs: 51,
                    protein: 4.0,
                    iron: '22%',  
                },
                {
                    name: 'KitKat',
                    calories: 518,
                    fat: 26.0,
                    carbs: 65,
                    protein: 7,
                    iron: '6%',  
                },
            ],
          }
        },
        methods:{

        },
        mounted(){
            console.log(this.user);
        }
    }
</script>
