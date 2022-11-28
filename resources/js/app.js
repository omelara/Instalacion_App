/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

 require('./bootstrap');

 window.Vue = require('vue').default;
 import vue from 'vue';
 
 import Vuetify from 'vuetify'
 Vue.use(Vuetify);
 
 import VueSweetalert2 from 'vue-sweetalert2';
 
 import 'sweetalert2/dist/sweetalert2.min.css';
 Vue.use(VueSweetalert2);
 import Vue from 'vue';
 
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';

Vue.use(DatePicker);


import 'material-icons/iconfont/material-icons.css';
 
 
 
 
 /**
  * The following block of code may be used to automatically register your
  * Vue components. It will recursively scan this directory for the Vue
  * components and automatically register them with their "basename".
  *
  * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
  */
 
 // const files = require.context('./', true, /\.vue$/i)
 // files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
 
 //Vue.component('example-component', require('./components/ExampleComponent.vue').default);

 Vue.component('proveedores', require('./components/Proveedores.vue').default);
 Vue.component('marcas', require('./components/Marcas.vue').default);
 Vue.component('bodegas', require('./components/Bodegas.vue').default);
 Vue.component('prestamo-form', require('./components/prestamos/PrestamosForm.vue').default);
 Vue.component('bodega-list', require('./components/prestamos/BodegaList.vue').default);
 Vue.component('prestamos', require('./components/prestamos/PrestamosList.vue').default);
 Vue.component('clientes', require('./components/Clientes.vue').default);
 Vue.component('descargos', require('./components/Descargos.vue').default);
 Vue.component('cargos', require('./components/Cargos.vue').default);
 Vue.component('empleados', require('./components/Empleados.vue').default);
 Vue.component('proyectos', require('./components/Proyectos.vue').default);
 Vue.component('compras', require('./components/Compras.vue').default);
 Vue.component('categorias', require('./components/Categorias.vue').default);
 Vue.component('equipos', require('./components/Equipos.vue').default);
 Vue.component('asignaciones', require('./components/Asignaciones.vue').default);
 Vue.component('alquileres', require('./components/Alquileres.vue').default);
 Vue.component('grupos', require('./components/Grupos.vue').default);
 Vue.component('mantenimientos', require('./components/Mantenimientos.vue').default);
 Vue.component('recursoes', require('./components/Recursoes.vue').default);
 Vue.component('tipos', require('./components/Tipos.vue').default);
 Vue.component('reservas-user', require('./components/ReservasUser.vue').default);


 //reportes parametrizados
 Vue.component('prestamo-report', require('./components/prestamos/PrestamosReport.vue').default);
 Vue.component('alquiler-report', require('./components/prestamos/AlquileresReport.vue').default);
 Vue.component('proyecto-report', require('./components/prestamos/ProyectosReport.vue').default);
 Vue.component('mantenimiento-report', require('./components/prestamos/MantenimientosReport.vue').default);
 Vue.component('descargo-report', require('./components/prestamos/DescargosReport.vue').default);
 Vue.component('compra-report', require('./components/prestamos/ComprasReport.vue').default);
 

  
 



 /**
  * Next, we will create a fresh Vue application instance and attach it to
  * the page. Then, you may begin adding components to this application
  * or customize the JavaScript scaffolding to fit your unique needs.
  */
 
 const app = new Vue({
     el: '#app',
     vuetify: new Vuetify()
 });
 