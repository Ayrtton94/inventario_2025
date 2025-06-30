<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        <form @submit.prevent="formSubmit">
                        <div class="mb-5">
                            <h3 class="mb-4">📋 Productos</h3>
                    
                            <table class="table table-bordered w-75 mx-auto text-center align-middle shadow">
                            <thead class="table-dark">
                                <tr>
                                <th>Campo</th>
                                <th>Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>COD_PRODUCTO</strong></td>
                                    <td><input v-model="form.cod_producto" type="text" class="form-control" required /></td>
                                </tr>
                                <tr>
                                    <td><strong>PRODUCTO</strong></td>
                                    <td><input v-model="form.nombre" type="text" class="form-control" required /></td>
                                </tr>
                                <tr>
                                    <td><strong>CANTIDAD</strong></td>
                                    <td><input v-model="form.cantidad" type="number" class="form-control" required /></td>
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
                productoId: {
                type: [Number, String],
                required: true,
                },
            },

            data(){
                return {
                    form: {},         
                }
            }, 

            mounted() {
             this.getProductos();
            },

            methods: {
                async getProductos() {
                    try {
                        const response = await axios.get(`/get/producto/${this.productoId}`);
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

                formSubmit(){
                    try {       

                        const response =  axios.post('/productos', this.form);                
                        Swal.fire('Éxito', 'Producto registrado correctamente', 'success'); 

                    } catch (error) {
                        Swal.fire('Error', error.message, 'error');
                    }               
                },

                regreso() {
                    window.location.href = '/productos'; 
                },
            }
    }
</script>
