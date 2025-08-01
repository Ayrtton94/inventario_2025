/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';

// Importar dependencias principales
import 'jquery';
import 'popper.js';
import 'bootstrap';

// Estilos y scripts de AdminLTE
import 'admin-lte';
import 'admin-lte/dist/css/adminlte.min.css';

// Este es el nuevo correcto
import '@fortawesome/fontawesome-free/css/all.min.css';


/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});

import ExampleComponent from './components/ExampleComponent.vue';
app.component('example-component', ExampleComponent);

///Users
import IndexUsers from './components/Users/Index.vue';
app.component('index-users', IndexUsers);

import EditUsers from './components/Users/Edit.vue';
app.component('edit-users', EditUsers);

///Roles
import IndexRoles from './components/Roles/Index.vue';
app.component('index-roles', IndexRoles);

import CreateRoles from './components/Roles/Create.vue';
app.component('create-roles', CreateRoles);

import EditRoles from './components/Roles/Edit.vue';
app.component('edit-roles', EditRoles);

///Clientes
import IndexPendiente from './components/tvHD/Pendiente/Index.vue';
app.component('index-pendiente', IndexPendiente);

import CreatePendiente from './components/tvHD/Pendiente/Create.vue';
app.component('create-pendiente', CreatePendiente);

import EditarPendiente from './components/tvHD/Pendiente/Edit.vue';
app.component('editar-pendiente', EditarPendiente);

//Tecnico
import IndexTecnico from './components/tvHD/Tecnico/Index.vue';
app.component('index-tecnico', IndexTecnico);

import CreateTecnico from './components/tvHD/Tecnico/Create.vue';
app.component('create-tecnico', CreateTecnico);

import EditTecnico from './components/tvHD/Tecnico/Edit.vue';
app.component('edit-tecnico', EditTecnico);

///Productos
import IndexProducts from './components/tvHD/Productos/Index.vue';
app.component('index-product', IndexProducts);

import CreateProducts from './components/tvHD/Productos/Create.vue';
app.component('create-product', CreateProducts);

import EditarProducts from './components/tvHD/Productos/Edit.vue';
app.component('editar-product', EditarProducts);

///Detalles del Producto
import IndexDetailProducts from './components/tvHD/Detalle_Producto/Index.vue';
app.component('index-detail-product', IndexDetailProducts);

import CreateDetailProducts from './components/tvHD/Detalle_Producto/Create.vue';
app.component('create-detail-product', CreateDetailProducts);

import EditDetailProducts from './components/tvHD/Detalle_Producto/Edit.vue';
app.component('edit-detail-product', EditDetailProducts);

///Import
import ImportExcel from './components/Excel/Index.vue';
app.component('import-excel', ImportExcel);

///Asignacion
import AsignarIndex from './components/tvHD/Asignacion/Index.vue';
app.component('asignar-index', AsignarIndex);

///Asignar Producto
import IndexAsignarProducto from './components/tvHD/Asignar_Producto/Index.vue';
app.component('index-ap', IndexAsignarProducto);

import AsignarProducto from './components/tvHD/Asignar_Producto/Form.vue';
app.component('asignar-producto', AsignarProducto);

///Pendientedth
import IndexPendienteDth from './components/DTH/Pendiente/Index.vue';
app.component('index-pendiente-dth', IndexPendienteDth);

import CreatePendienteDth from './components/DTH/Pendiente/Create.vue';
app.component('create-pendiente-dth', CreatePendienteDth);

import EditPendienteDth from './components/DTH/Pendiente/Edite.vue';
app.component('edite-pendiente-dth', EditPendienteDth);

///Asignadoth
import AsignarDthIndex from './components/DTH/Asignacion/Index.vue';
app.component('asignar-dth-index', AsignarDthIndex);

///ProductosDth
import IndexProductsDth from './components/DTH/Productos/Index.vue';
app.component('index-products-dth', IndexProductsDth);

import CreateProductsDth from './components/DTH/Productos/Create.vue';
app.component('create-products-dth', CreateProductsDth);

import EditProductsDth from './components/DTH/Productos/Edit.vue';
app.component('edit-products-dth', EditProductsDth);

///Detalles del Producto DTH
import IndexDetailProductsDth from './components/DTH/Detalle_Producto/Index.vue';
app.component('index-detail-products-dth', IndexDetailProductsDth);

import CreateDetailProductsDth from './components/DTH/Detalle_Producto/Create.vue';
app.component('create-detail-products-dth', CreateDetailProductsDth);

import EditDetailProductsDth from './components/DTH/Detalle_Producto/Edit.vue';
app.component('edit-detail-products-dth', EditDetailProductsDth);

///Formularios Tecnicos DTH
import IndexFormTecnicoDth from './components/DTH/Tecnico/Index.vue';
app.component('index-form-tecnico-dth', IndexFormTecnicoDth);

import CreateFormTecnicoDth from './components/DTH/Tecnico/Create.vue';
app.component('create-form-tecnico-dth', CreateFormTecnicoDth);

import EditFormTecnicoDth from './components/DTH/Tecnico/Edite.vue';
app.component('edit-form-tecnico-dth', EditFormTecnicoDth);

///pendiente producto dth
import IndexPendienteProductoDth from './components/DTH/Asignar_Producto/Index.vue';
app.component('index-pendiente-producto-dth', IndexPendienteProductoDth);

import CreatePendienteProductoDth from './components/DTH/Asignar_Producto/Create.vue';
app.component('create-pendiente-producto-dth', CreatePendienteProductoDth);

///Importar DTH
import IndexImportarDth from './components/DTH/Importar/Index.vue';
app.component('index-importar-dth', IndexImportarDth);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

app.mount('#app');
