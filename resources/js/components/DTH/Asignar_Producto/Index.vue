<template>
  <div class="container mt-4">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="card shadow rounded-4">
          <div class="card-header bg-danger text-white fw-bold">
            Lista de Productos Asignados
          </div>
          <div class="card-body">
            <div>
              <button @click="irCrear" class="btn btn-primary shadow-sm" v-if="can('asignar_producto.create')">
                    Crear Nuevo
              </button>
              <table class="table table-striped table-bordered text-center">
                <thead class="table-primary">
                  <tr>
                    <th>ID</th>
                    <th>Técnico</th>
                    <th>Producto</th>
                    <th>Ver Detalles</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="producto in productos" :key="producto.id">
                    <td>{{ producto.id }}</td>
                    <td>{{ producto.asignado_a || 'N/A' }}</td>
                    <td>{{ producto.producto_nombre }}</td>
                    <td>
                      <button
                        class="btn btn-outline-info btn-sm"
                        @click="abrirModal(producto)"
                      >
                        Ver Detalles
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div
      class="modal fade"
      id="modalDetalles"
      tabindex="-1"
      aria-labelledby="modalDetallesLabel"
      aria-hidden="true"
      ref="modal"
    >
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4">
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title" id="modalDetallesLabel">
              Detalles del Producto
            </h5>
            <button
              ref="botonCerrar"
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Cerrar"
              @click="cerrarModal"
            ></button>
          </div>
          <div class="modal-body">
            <ul class="list-group list-group-flush">
              <li class="list-group-item">
                <strong>ID:</strong> {{ productoSeleccionado.id }}
              </li>
              <li class="list-group-item">
                <strong>Técnico:</strong> {{ productoSeleccionado.asignado_a || 'N/A' }}
              </li>
              <li class="list-group-item">
                <strong>Producto:</strong> {{ productoSeleccionado.producto_nombre }}
              </li>
              <li class="list-group-item">
                <strong>Detalles:</strong>
                <ul>
                  <li v-for="detalle in productoSeleccionado.detalles" :key="detalle.id">
                    {{ detalle.stb }}
                  </li>
                </ul>
              </li>
              <!-- Aquí puedes agregar más detalles si los tienes -->
            </ul>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
              @click="cerrarModal"
            >
              Cerrar
            </button>
          </div>
        </div>
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
            productos: [],
            productoSeleccionado: {},  
            modalInstance: null,
        }
    },
    created() {
        this.loadProductos();
    },
    mounted() {
        this.modalInstance = new bootstrap.Modal(this.$refs.modal, {
          backdrop: 'static',
          keyboard: false
        });

        // Opcional: limpiar producto al cerrar el modal
        this.$refs.modal.addEventListener('hidden.bs.modal', () => {
          this.productoSeleccionado = {};
        });
    },
    methods: {
      can(permission) {
            return this.permissions.includes(permission);
      },
      irCrear() {
          window.location.href = '/pendiente_productodth/create';
        },
        async loadProductos() {
            try {
                const response = await axios.get('/api/pendiente_productodth/productos');
                this.productos = response.data.data;
                this.pagination = {
                    current_page: response.data.current_page,
                    last_page: response.data.last_page,
                    per_page: response.data.per_page,
                    total: response.data.total,
                };
            } catch (error) {
                console.error('Error al cargar productos:', error);
            }
        },

        abrirModal(producto) {
            this.productoSeleccionado = producto;

            this.$nextTick(() => {
              this.modalInstance.show();

              // Espera al final de la animación
              this.$refs.modal.addEventListener('shown.bs.modal', () => {
                // Aquí puedes dar foco si deseas
                // this.$refs.botonCerrar?.focus();
              }, { once: true });
            });
        },

        cerrarModal() {
          document.activeElement.blur();

          if (this.modalInstance) {
            this.modalInstance.hide();
          }
        },
    }
}
</script>
<style scoped>
.table th,
.table td {
  vertical-align: middle;
}
</style>
