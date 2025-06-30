<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        <form @submit.prevent="formSubmit">
                        <div class="mb-5">
                            <h3 class="mb-4">📋 Información de Ventas Pendientes</h3>
                    
                            <table class="table table-bordered w-75 mx-auto text-center align-middle shadow">
                            <thead class="table-dark">
                                <tr>
                                <th>Campo</th>
                                <th>Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>Departamento</strong></td>
                                    <td><input v-model="form.departamento" type="text" class="form-control" required /></td>
                                </tr>
                                <tr>
                                    <td><strong>Provincia</strong></td>
                                    <td><input v-model="form.provincia" type="text" class="form-control" required /></td>
                                </tr>
                                <tr>
                                    <td><strong>Municipio</strong></td>
                                    <td><input v-model="form.municipio" type="text" class="form-control" required /></td>
                                </tr>
                                <tr>
                                    <td><strong>Direccion</strong></td>
                                    <td><input v-model="form.direccion" type="text" class="form-control" required /></td>
                                </tr>
                                <tr>
                                    <td><strong>Abonado</strong></td>
                                    <td><input v-model="form.abonado" type="text" class="form-control" required /></td>
                                </tr>
                                <tr>
                                    <td><strong>Nombres y Apellidos</strong></td>
                                    <td><input v-model="form.nombres" type="text" class="form-control" required /></td>
                                </tr>
                                <tr>
                                    <td><strong>Tlf. Habitación</strong></td>
                                    <td><input v-model="form.tlf_habitacion" type="text" class="form-control" required /></td>
                                </tr>
                                <tr>
                                    <td><strong>Tlf. Móvil</strong></td>
                                    <td><input v-model="form.tlf_movil" type="text" class="form-control" required /></td>
                                </tr>
                                <tr>
                                    <td><strong>DTH</strong></td>
                                    <td><input v-model="form.dth" type="text" class="form-control" required /></td>
                                </tr>
                                <tr>
                                    <td><strong>Cnt. Equipos</strong></td>
                                    <td><input v-model="form.cnt_equipos" type="text" class="form-control" required /></td>
                                </tr>
                                <tr>
                                    <td><strong>Tipo Instalación</strong></td>
                                    <td><input v-model="form.tipo_instalacion" type="text" class="form-control" required /></td>
                                </tr>
                                <tr>
                                    <td><strong>Fecha Ingreso</strong></td>
                                    <td><input v-model="form.fecha_ingreso" type="text" class="form-control" required /></td>
                                </tr>
                                <tr>
                                    <td><strong>Fecha Age.</strong></td>
                                    <td><input v-model="form.fecha_age" type="text" class="form-control" required /></td>
                                </tr>
                                <tr>
                                    <td><strong>Distribuidor Age.</strong></td>
                                    <td><input v-model="form.distribuidor_age" type="text" class="form-control" required /></td>
                                </tr>
                                <tr>
                                    <td><strong>Tipo Cliente-Grupo Afinidad</strong></td>
                                    <td><input v-model="form.tipo_cliente_grupo_afinidad" type="text" class="form-control" required /></td>
                                </tr>
                                <tr>
                                    <td><strong>Origen Abonado</strong></td>
                                    <td><input v-model="form.origen_abonado" type="text" class="form-control" required /></td>
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
            pendienteId: {
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
             this.getPendientes();
        },
        methods: {
            async getPendientes() {
                try {
                    const response = await axios.get(`/get/pendiente/${this.pendienteId}`);
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

                const response =  axios.post('/pendiente', this.form);                
                Swal.fire('Éxito', 'Venta registrada correctamente', 'success'); 

            } catch (error) {
                Swal.fire('Error', error.message, 'error');
            }               
        },
        regreso() {
            window.location.href = '/pendiente'; 
        },
    }

    }
</script>
