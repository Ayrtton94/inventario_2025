<template>
  <div class="container mt-4">
    <div class="card shadow-sm">
      <div class="card-header">
        <h5 class="mb-0">Asignar Producto y Detalles a Pendiente</h5>
      </div>
      <div class="card-body">
        <!-- Producto -->
        <div class="mb-3">
          <label for="producto" class="form-label">Producto:</label>
          <select v-model="productoSeleccionado" @change="cargarDetalles" class="form-select">
            <option disabled value="">Selecciona un producto</option>
            <option v-for="producto in productos" :key="producto.id" :value="producto">
              {{ producto.producto }}
            </option>
          </select>
        </div>

        <!-- Detalles -->
        <div v-if="productoSeleccionado" class="mb-3">
          <label for="detalles" class="form-label">Detalles:</label>
          <select v-model="detallesSeleccionados" class="form-select" multiple>
            <option v-for="detalle in detalles" :key="detalle.id" :value="detalle">
              {{ detalle.stb }}
            </option>
          </select>
        </div>

        <!-- Botón para agregar -->
        <button class="btn btn-primary mb-3" @click="añadirAsignacion" :disabled="!productoSeleccionado || detallesSeleccionados.length === 0">
          Añadir a lista
        </button>

        <!-- Tabla de asignaciones -->
        <div v-if="asignaciones.length > 0">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Producto</th>
                <th>Detalles</th>
                <th>Acción</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(asignacion, index) in asignaciones" :key="index">
                <td>{{ asignacion.producto.producto }}</td>
                <td>
                  <ul>
                    <li v-for="detalle in asignacion.detalles" :key="detalle.id">
                      {{ detalle.stb }}
                    </li>
                  </ul>
                </td>
                <td>
                  <button class="btn btn-danger btn-sm" @click="eliminarAsignacion(index)">Eliminar</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Botón Final -->
        <button class="btn btn-success" @click="guardarAsignaciones" :disabled="asignaciones.length === 0">
          Asignar al pendiente
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";

export default {
  props: ['usarId'],
  data() {
    return {
      productos: [],
      productoSeleccionado: '',
      detalles: [],
      detallesSeleccionados: [],
      asignaciones: []
    };
  },
  created() {
    this.cargarProductos();
  },
  methods: {
    async cargarProductos() {
      const res = await axios.get('/listar/producto'); // Ajusta ruta si es diferente
      this.productos = res.data;
    },
    async cargarDetalles() {
      this.detallesSeleccionados = [];
      const cod = this.productoSeleccionado.cod_producto;
      const res = await axios.get(`/productos/${cod}/detalles`);
      this.detalles = res.data;
    },
    añadirAsignacion() {
      this.asignaciones.push({
        producto: this.productoSeleccionado,
        detalles: [...this.detallesSeleccionados]
      });
      this.productoSeleccionado = '';
      this.detalles = [];
      this.detallesSeleccionados = [];
    },
    eliminarAsignacion(index) {
      this.asignaciones.splice(index, 1);
    },
    async guardarAsignaciones() {
      try {
        const payload = {
          pendiente_id: this.usarId,
          asignaciones: this.asignaciones.map(item => ({
            producto_id: item.producto.id,
            detalle_ids: item.detalles.map(det => det.id)
          }))
        };

        await axios.post('/pendiente/asignar-producto', payload);
        Swal.fire('Éxito', 'Asignación guardada correctamente', 'success');
        this.asignaciones = [];
      } catch (error) {
        Swal.fire('Error', 'Ocurrió un problema al guardar', 'error');
      }
    }
  }
};
</script>
