<template>
    <div class="container">
        <div class="row justify-content-center">
            <div>
                <div class="card">
                    <div class="card-header">Roles</div>                    
                    <div class="card-body table-responsive">
                        <button @click="irCrear" class="btn btn-success shadow-sm" v-if="can('roles.create')">
                            Crear Nuevo
                        </button>
                        <table class="table table-hover table-bordered align-middle text-center">
                        <thead class="thead-dark">
                            <tr>
                                <th colspan="2">ACCION</th>
                                <th>#</th>
                                <th>Nombre</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="role in roles" :key="role.id">
                                <td width="10px">
                                    <button @click="irEditar(role.id)" class="btn btn-warning btn-sm" v-if="can('roles.edit')">
                                        <i class="fas fa-edit"></i> 
                                    </button>                                    
                                </td>
                                <td width="10px">
                                    <button @click="eliminar(role.id)" class="btn btn-danger btn-sm" v-if="can('roles.destroy')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                                <td>{{ role.id }}</td>
                                <td>{{ role.name }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <nav v-if="pagination.last_page > 1" class="d-flex justify-content-center mt-4">
                            <ul class="pagination">
                            <li class="page-item" :class="{ disabled: pagination.current_page === 1 }">
                               <a @click.prevent="loadroles(pagination.current_page - 1)" class="page-link" href="#">
                                <i class="fas fa-chevron-left"></i>
                                </a>
                            </li>
                            <li v-for="page in paginationLinks" :key="page" class="page-item" :class="{ active: page === pagination.current_page }">
                                <a @click.prevent="loadroles(page)" class="page-link" href="#">
                                {{ page }}
                                </a>
                            </li>
                            <li class="page-item" :class="{ disabled: pagination.current_page === pagination.last_page }">
                               <a @click.prevent="loadroles(pagination.current_page + 1)" class="page-link" href="#">
                                <i class="fas fa-chevron-right"></i>
                                </a>
                            </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Swal from 'sweetalert2';

    export default {
        data() {
            return {
                permissions: window.userPermissions || [],
                roles: [],
                pagination: {
                    current_page: 1,
                    last_page: 1,
                    per_page: 10,
                    total: 0,
                },
            };        
        },
        created() {
            this.loadroles();
        },
        computed: {
            paginationLinks() {
            const current = this.pagination.current_page;
            const last = this.pagination.last_page;
            const delta = 2;
            const range = [];

            for (let i = Math.max(2, current - delta); i <= Math.min(last - 1, current + delta); i++) {
                range.push(i);
            }

            if (current - delta > 2) {
                range.unshift('...');
            }
            if (current + delta < last - 1) {
                range.push('...');
            }

            range.unshift(1);
            if (last !== 1) range.push(last);

            return range;
            },
         },
        methods: {
             can(permission) {
                return this.permissions.includes(permission);
            },
            async loadroles(page = 1) {
                try {
                    const response = await axios.get(`/listar/roles?page=${page}`);
                    this.roles = response.data.data;
                    this.pagination = {
                        current_page: response.data.current_page,
                        last_page: response.data.last_page,
                        per_page: response.data.per_page,
                        total: response.data.total,
                    };
                } catch (error) {
                    Swal.fire('Error', 'No se pudieron cargar los roles', 'error');
                }
            },

            irCrear() {
                window.location.href = '/roles/create';
            },

            irEditar(id) {
                window.location.href = `/roles/${id}/edit`;
            },

            eliminar(id) {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminarlo',
                    cancelButtonText: 'Cancelar',
                }).then(async (result) => {
                    if (result.isConfirmed) {
                    try {
                        await axios.delete(`/roles/${id}`);
                        Swal.fire('¡Eliminado!', 'El rol ha sido eliminado.', 'success');
                        this.getPendientes();
                    } catch (error) {
                        Swal.fire('Error', 'Hubo un problema al eliminar.', 'error');
                    }
                    }
                });
            },
    },


    }
</script>
