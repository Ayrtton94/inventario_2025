<template>
    <div class="container">
        <div class="row justify-content-center">
            <div>
                <div class="card">
                    <div class="card-header">Procutos</div>                    
                    <div class="card-body table-responsive">
                        <button @click="irCrear" class="btn btn-success shadow-sm" v-if="can('producto.create')">
                            Crear Nuevo
                        </button>
                        <table class="table table-hover table-bordered align-middle text-center">
                        <thead class="thead-dark">
                            <tr>
                                <th colspan="2">ACCION</th>
                                <th>#</th> 
                                <th>COD_PRODUCTO</th>
                                <th>PRODUCTO</th>
                                <th>CANTIDAD</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="producto in productos" :key="producto.id">
                                <td>
                                    <button @click="irEditar(producto.id)" class="btn btn-warning btn-sm" v-if="can('producto.edit')">
                                        <i class="fas fa-edit"></i> 
                                    </button>                                    
                                </td>
                                <td>
                                    <button @click="eliminar(producto.id)" class="btn btn-danger btn-sm" v-if="can('producto.destroy')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                                <td>{{ producto.id }}</td>
                                <td>{{ producto.cod_producto }}</td>
                                <td>{{ producto.producto }}</td>
                                <td>{{ producto.total_detalles }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <nav v-if="pagination.last_page > 1" class="d-flex justify-content-center mt-4">
                            <ul class="pagination">
                            <li class="page-item" :class="{ disabled: pagination.current_page === 1 }">
                               <a @click.prevent="loadProductos(pagination.current_page - 1)" class="page-link" href="#">
                                <i class="fas fa-chevron-left"></i>
                                </a>
                            </li>
                            <li v-for="page in paginationLinks" :key="page" class="page-item" :class="{ active: page === pagination.current_page }">
                                <a @click.prevent="loadProductos(page)" class="page-link" href="#">
                                {{ page }}
                                </a>
                            </li>
                            <li class="page-item" :class="{ disabled: pagination.current_page === pagination.last_page }">
                               <a @click.prevent="loadProductos(pagination.current_page + 1)" class="page-link" href="#">
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
                productos: [],
                pagination: {
                    current_page: 1,
                    last_page: 1,
                    per_page: 10,
                    total: 0,
                },
            };        
        },

    created() {
        this.loadProductos();
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
        async loadProductos(page = 1) {
            try {
                const response = await axios.get(`/api/listar/producto?page=${page}`);
                this.productos = response.data.data;
                this.pagination = {
                    current_page: response.data.current_page,
                    last_page: response.data.last_page,
                    per_page: response.data.per_page,
                    total: response.data.total,
                };
            } catch (error) {
                Swal.fire('Error', 'No se pudieron cargar los productos', 'error');
            }
        },

        irCrear() {
            window.location.href = '/productos/create';
        },

        irEditar(id) {
            window.location.href = `/productos/${id}/edit`;
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
                    await axios.delete(`/productos/${id}`);
                    Swal.fire('¡Eliminado!', 'El producto ha sido eliminado.', 'success');
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

<style scoped>
.table th {
  font-weight: 600;
  text-transform: uppercase;
  font-size: 0.85rem;
  letter-spacing: 0.5px;
  border-top: none;
}

.table td {
  vertical-align: middle;
}

.table-responsive {
  margin-top: 20px;
}

.page-item.active .page-link {
  background-color: #0d6efd;
  border-color: #0d6efd;
}

.page-link {
  color: #000000;
}

.pagination {
  --bs-pagination-font-size: 0.9rem;
}

.pagination .page-item.disabled .page-link {
  pointer-events: none;
  opacity: 0.5;
}

.pagination i {
  font-size: 1.1rem;
}

.btn-group .btn {
  font-size: 0.85rem;
  padding: 0.5rem 1rem;
}
</style>