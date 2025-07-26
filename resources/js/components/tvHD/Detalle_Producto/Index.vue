<template>
    <div class="container">
        <div class="row justify-content-center">
            <div>
                <div class="card">
                    <div class="card-header">Detalles del producto </div>

                    <div class="card-body table-responsive">
                        <button @click="irCrear" class="btn btn-success shadow-sm"  v-if="can('detalle_producto.create')">
                            Crear Nuevo
                        </button>
                        <table class="table table-hover table-bordered align-middle text-center">
                            <thead class="table-primary text-nowrap">
                            <tr>
                                <th colspan="2">ACCION</th>
                                <th>#</th>
                                <th>FECHA INGRESO</th>
                                <th>STB</th>
                                <th>COD_ART</th>
                                <th>ESTADO</th>
                            </tr>
                        </thead>
                            <tbody>
                                <tr v-for="detail_product in detail_products" :key="detail_product.id">
                                    <td width="50px">
                                        <button @click="irEditar(detail_product.id)" class="btn btn-warning btn-sm"  v-if="can('detalle_producto.edit')">
                                            <i class="fas fa-edit"></i> 
                                        </button>
                                    </td>
                                    <td width="50px">
                                        <button @click="eliminar(detail_product.id)" class="btn btn-danger btn-sm"  v-if="can('detalle_producto.destroy')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                    <td>{{ detail_product.id }}</td>
                                    <td>{{ detail_product.fecha_ingreso }}</td>
                                    <td>{{ detail_product.stb }}</td>
                                    <td>{{ detail_product.cod_art }}</td>
                                    <td>{{ detail_product.estado }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <nav v-if="pagination.last_page > 1" class="d-flex justify-content-center mt-4">
                            <ul class="pagination">
                            <li class="page-item" :class="{ disabled: pagination.current_page === 1 }">
                               <a @click.prevent="loadDetailProdt(pagination.current_page - 1)" class="page-link" href="#">
                                <i class="fas fa-chevron-left"></i>
                                </a>
                            </li>
                            <li v-for="page in paginationLinks" :key="page" class="page-item" :class="{ active: page === pagination.current_page }">
                                <a @click.prevent="loadDetailProdt(page)" class="page-link" href="#">
                                {{ page }}
                                </a>
                            </li>
                            <li class="page-item" :class="{ disabled: pagination.current_page === pagination.last_page }">
                               <a @click.prevent="loadDetailProdt(pagination.current_page + 1)" class="page-link" href="#">
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
                detail_products: [],
                pagination: {
                    current_page: 1,
                    last_page: 1,
                    per_page: 10,
                    total: 0,
                },
            };        
        },
        created() {
            this.loadDetailProduct();
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
            async loadDetailProduct(page = 1) {
                try {
                    const response = await axios.get(`/listar/detailproduct?page=${page}`);
                    this.detail_products = response.data.data;
                    this.pagination = {
                        current_page: response.data.current_page,
                        last_page: response.data.last_page,
                        per_page: response.data.per_page,
                        total: response.data.total,
                    };
                } catch (error) {
                    Swal.fire('Error', 'No se pudieron cargar los detalles', 'error');
                }
            },

            irCrear() {
                window.location.href = '/detalle_productos/create';
            },

            irEditar(id) {
                window.location.href = `/detalle_productos/${id}/edit`;
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
                        await axios.delete(`/detalle_productos/${id}`);
                        Swal.fire('¡Eliminado!', 'El detalle ha sido eliminado.', 'success');
                        this.loadDetailProduct();
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