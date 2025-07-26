<template>
  <div class="container py-4">
    <div class="card shadow-sm">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Clientes Asignados</h5>
      </div>

      <div class="card-body">
        <!-- Tabla -->
        <div class="table-responsive">
          <table class="table table-bordered table-hover align-middle text-center small">
            <thead class="table-danger text-nowrap">
              <tr>
                <th >Acción</th>
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
                  <button @click="irTecnico(pendiente.id)" class="btn btn-primary btn-sm" v-if="can('tecnico.create')">
                    <i class="fas fa-pen-nib"></i>
                  </button>
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
        usuarioSeleccionado: '',

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
async loadPendientes(page = 1) {
  this.pendientes = [];
  try {
    const response = await axios.get(`/listar/asignadosdth?page=${page}`);
    console.log('Respuesta del backend:', response.data); // 👈🏼 Agrega esto
    this.pendientes = response.data.data;
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
        irTecnico(id) {
            window.location.href = `/tecnico/create/${id}`;
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