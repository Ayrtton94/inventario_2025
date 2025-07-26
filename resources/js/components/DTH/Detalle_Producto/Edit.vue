<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Detalle del producto</div>

                    <div class="card-body">
                        <form @submit.prevent="formSubmit">
                        <div class="mb-5">
                            <h3 class="mb-4">📋Detalle productos</h3>
                    
                            <table class="table table-bordered w-75 mx-auto text-center align-middle shadow">
                            <thead class="table-danger">
                                <tr>
                                <th>Campo</th>
                                <th>Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>PRODUCTO</strong></td>
                                    <td>
                                        <select v-model="form.producto_id" @change="cargarProduct" class="form-select" :disabled="cargandoProductos">
                                        <option value="">Seleccione producto</option>
                                        <option v-for="producto in productos" :key="producto.id" :value="producto.id">
                                            {{ producto.nombre }}
                                        </option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>FECHA INGRESO</strong></td>
                                    <td><input v-model="form.fecha_ingreso" type="date" class="form-control" required /></td>
                                </tr>
                                <tr>
                                    <td><strong>STB</strong></td>
                                    <td><input v-model="form.stb" type="text" class="form-control" required /></td>
                                </tr>
                                <tr>
                                    <td><strong>COD_ART</strong></td>
                                    <td><input v-model="form.cod_art" type="number" class="form-control" required /></td>
                                </tr>
                                <tr>
                                    <td><strong>ESTADO</strong></td>
                                    <td><input v-model="form.estado" type="text" class="form-control" required /></td>
                                </tr>
                            </tbody>
                            </table>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" @click="regreso" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Regresar
                                </button>
                            
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Guardar
                                </button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Swal from 'sweetalert2';
import axios from 'axios';

    export default {
         name: "Editar",
            props: {
                detailproductId: {
                type: [Number, String],
                required: true,
                },
            },

            data(){
                return {
                    form: {},
                    productos:[],
                    cargandoProductos: false,       
                }
            }, 

            mounted() {    
                this.cargarProduct();
                this.getDetalles();
            },

            methods: {
                regreso() {
                    window.location.href = '/detalle_productos'; 
                },

                async getDetalles() {
                    try {
                        const response = await axios.get(`/get/detailproduct/${this.detailproductId}`);
                        this.form = response.data;
                        console.log(this.form);
                    } catch (error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: error.response?.data?.error || 'No se pudo cargar el vehículo',
                            timer: 2000
                        });
                    }
                },

                async cargarProduct() {
                    this.cargandoProductos = true;
                    try {
                        const response = await axios.get('/listar/producto');
                        this.productos = response.data;
                    } catch (error) {
                        console.error('Error cargando producto:', error);
                    } finally {
                        this.cargandoProductos = false;
                    }
                },                

                formSubmit(){
                    try {       

                        const response =  axios.post('/detalle_productos', this.form);                
                        Swal.fire('Éxito', 'Venta registrada correctamente', 'success'); 

                    } catch (error) {
                        Swal.fire('Error', error.message, 'error');
                    }               
                },
        },
    }
</script>
