<template>
  <div class="container py-4">
    <div class="card shadow-sm">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Pendientes</h5>
        <button @click="irCrear" class="btn btn-success btn-sm" v-if="can('cliente.create')">
          <i class="fas fa-plus-circle me-1"></i> Crear Nuevo
        </button>
      </div>

      <div class="card-body">
        <!-- Asignar pendientes -->
        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center mb-3 gap-2">
          <select v-model="usuarioSeleccionado" class="form-select w-100 w-md-auto">
            <option disabled value="">Selecciona un usuario</option>
            <option v-for="user in usuarios" :value="user.id" :key="user.id">{{ user.name }}</option>
          </select>

          <button
            class="btn btn-primary"
            @click="asignarSeleccionados"
            :disabled="!usuarioSeleccionado || seleccionados.length === 0"
          >
            <i class="fas fa-user-check me-1"></i> Asignar pendientes
          </button>
        </div>

        <!-- Tabla -->
        <div class="table-responsive">
          <table class="table table-bordered table-hover align-middle text-center small">
            <thead class="table-dark text-nowrap">
              <tr>
                <th colspan="3">Acción</th>
                <th><input type="checkbox" disabled /></th>
                <th>Asignado a</th>
                <th>#</th>
                <th>Departamento</th>
                <th>Provincia</th>
                <th>Municipio</th>
                <th>Dirección</th>
                <th>Abonado</th>
                <th>Nombres</th>
                <th>Tlf. Habitación</th>
                <th>Tlf. Móvil</th>
                <th>DTH</th>
                <th>Cant. Equipos</th>
                <th>Tipo Inst.</th>
                <th>F. Ingreso</th>
                <th>F. Age</th>
                <th>Distribuidor</th>
                <th>Tipo Cliente</th>
                <th>Origen</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="pendiente in pendientes" :key="pendiente.id">
                <td>
                  <button @click="irEditar(pendiente.id)" class="btn btn-warning btn-sm" v-if="can('cliente.edit')">
                    <i class="fas fa-edit"></i>
                  </button>
                </td>
                <td>
                  <button @click="eliminar(pendiente.id)" class="btn btn-danger btn-sm" v-if="can('cliente.destroy')">
                    <i class="fas fa-trash-alt"></i>
                  </button>
                </td>
                <td>
                  <button @click="irTecnico(pendiente.id)" class="btn btn-primary btn-sm">
                    <i class="fas fa-pen-nib"></i>
                  </button>
                </td>             
                <td>
                  <input class="form-check-input" type="checkbox" :value="pendiente.id" v-model="seleccionados" />
                </td>
                <td>
                  <span v-if="pendiente.user" class="badge bg-info">{{ pendiente.user.name }}</span>
                  <span v-else class="text-muted">Sin asignar</span>
                </td>
                <td>{{ pendiente.id }}</td>
                <td>{{ pendiente.departamento }}</td>
                <td>{{ pendiente.provincia }}</td>
                <td>{{ pendiente.municipio }}</td>
                <td>{{ pendiente.direccion }}</td>
                <td>{{ pendiente.abonado }}</td>
                <td>{{ pendiente.nombres }}</td>
                <td>{{ pendiente.tlf_habitacion }}</td>
                <td>{{ pendiente.tlf_movil }}</td>
                <td>{{ pendiente.dth }}</td>
                <td>{{ pendiente.cnt_equipos }}</td>
                <td>{{ pendiente.tipo_instalacion }}</td>
                <td>{{ pendiente.fecha_ingreso }}</td>
                <td>{{ pendiente.fecha_age }}</td>
                <td>{{ pendiente.distribuidor_age }}</td>
                <td>{{ pendiente.tipo_cliente_grupo_afinidad }}</td>
                <td>{{ pendiente.origen_abonado }}</td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Paginación -->
        <nav v-if="pagination.last_page > 1" class="d-flex justify-content-center mt-3">
          <ul class="pagination pagination-sm">
            <li class="page-item" :class="{ disabled: pagination.current_page === 1 }">
              <a @click.prevent="loadPendientes(pagination.current_page - 1)" class="page-link" href="#">
                <i class="fas fa-chevron-left"></i>
              </a>
            </li>
            <li
              v-for="page in paginationLinks"
              :key="page"
              class="page-item"
              :class="{ active: page === pagination.current_page }"
            >
              <a @click.prevent="loadPendientes(page)" class="page-link" href="#">{{ page }}</a>
            </li>
            <li class="page-item" :class="{ disabled: pagination.current_page === pagination.last_page }">
              <a @click.prevent="loadPendientes(pagination.current_page + 1)" class="page-link" href="#">
                <i class="fas fa-chevron-right"></i>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import Swal from 'sweetalert2';
import '@fortawesome/fontawesome-free/css/all.min.css';
export default {
    data() {
        return {
        permissions: window.userPermissions || [],
        pendientes: [],
        usuarios: [],
        seleccionados: [],
        asignaciones: [],
        pendienteEnModal: null,
        usuarioSeleccionado: '',
        mostrarModal: false,

        pagination: {
            current_page: 1,
            last_page: 1,
            per_page: 10,
            total: 0,
            
        },
        };
    },

    created() {
        //this.getPendientes();
        this.loadPendientes();
        this.loadUsuarios();
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
        async loadUsuarios() {
            const res = await axios.get('/usuarios/listar'); // solo usuarios técnicos
            this.usuarios = res.data;
        },

        async asignarSeleccionados() {
            try {
            await axios.post('/asignar/pendientes', {
                pendientes: this.seleccionados,
                user_id: this.usuarioSeleccionado                
            });            

            Swal.fire('¡Asignados!', 'Pendientes asignados correctamente.', 'success');
            this.loadPendientes();
            this.seleccionados = [];
            this.usuarioSeleccionado = '';
            } catch (err) {
            Swal.fire('Error', 'No se pudo asignar.', 'error');
            }
        },



        can(permission) {
            return this.permissions.includes(permission);
        },
        async loadPendientes(page = 1) {
            try {
                const response = await axios.get(`/listar/pendiente?page=${page}`);
                this.pendientes = response.data.data;
                this.pagination = {
                    current_page: response.data.current_page,
                    last_page: response.data.last_page,
                    per_page: response.data.per_page,
                    total: response.data.total,
                };
            } catch (error) {
                Swal.fire('Error', 'No se pudieron cargar los pendientes', 'error');
            }
        },

        /*async getPendientes() {
            try {
                const response = await axios.get("/listar/pendiente");
                this.pendientes = response.data;
            } catch (error) {
                console.error("Error al obtener las áreas:", error);
            }
        },*/
        irCrear() {
            window.location.href = '/pendiente/create';
        },
        irEditar(id) {
            window.location.href = `/pendiente/${id}/edit`;
        },
        irTecnico(id) {
            window.location.href = `/tecnico/create/${id}`;
        },
        /*irAsignarProducto(id) {
            window.location.href = `/pendiente/${id}/asignar-producto`;
        },*/
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
                    await axios.delete(`/pendiente/${id}`);
                    Swal.fire('¡Eliminado!', 'El pendiente ha sido eliminado.', 'success');
                    this.loadPendientes();
                } catch (error) {
                    Swal.fire('Error', 'Hubo un problema al eliminar.', 'error');
                }
                }
            });
        },
        async verAsignaciones(id) {
            try {
              const res = await axios.get(`/pendiente/${id}/asignaciones`);
              this.asignaciones = res.data.pendiente_productos;
              this.pendienteEnModal = res.data;
              const modal = new bootstrap.Modal(document.getElementById('modalVerAsignaciones'));
              modal.show();
            } catch (error) {
              console.error(error);
              Swal.fire('Error', 'No se pudo cargar la asignación', 'error');
            }
      },
      abrirModalProducto() {
      this.mostrarModal = true;

      this.$nextTick(() => {
        const modalEl = this.$refs.modalAsignaciones;

        // Crear una instancia de Bootstrap Modal solo si aún no lo está
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();
      });
    },

        cerrarModalProducto() {
            this.mostrarModal = false;
            this.asignaciones = [];
            this.pendienteEnModal = null;
            const modalEl = this.$refs.modalAsignaciones;
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) {
                modal.hide();
            }
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