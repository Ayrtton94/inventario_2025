<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <div class="card shadow">
          <div class="card-header bg-danger text-white">Asignar Producto</div>

          <div class="card-body">
            <form @submit.prevent="guardarAsignaciones">

              <!-- Selección del técnico -->
              <div class="mb-3">
                <label class="form-label">Técnico</label>
                <select class="form-select" v-model="form.users_id" required>
                  <option value="">Seleccione un técnico</option>
                  <option v-for="tecnico in tecnicos" :key="tecnico.id" :value="tecnico.id">
                    {{ tecnico.name }}
                  </option>
                </select>
              </div>

              <!-- Búsqueda de producto por código -->
              <div class="mb-3">
                <label for="producto" class="form-label">Buscar Producto por Código</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="producto" v-model="producto.cod_producto" placeholder="Código del producto">
                    <button class="btn btn-primary" type="button" @click="buscarProducto">Buscar</button>
                </div>
            </div>

              <!-- Mostrar producto encontrado -->
              <div v-if="productoSeleccionado" class="alert alert-info">
                <strong>Producto:</strong> {{ productoSeleccionado.producto }}
              </div>

              <!-- Mostrar detalles del producto -->
              <div v-if="detalles.length" class="mb-3">
                <label class="form-label">Seleccionar Detalles</label>
                <select v-model="detallesSeleccionados" class="form-select" multiple>
                  <option v-for="detalle in detalles" :key="detalle.id" :value="detalle">
                    {{ detalle.stb }} - {{ detalle.id }}
                  </option>
                </select>
              </div>

              <!-- Añadir a la lista -->
              <button class="btn btn-secondary mb-3" type="button"
                @click="añadirAsignacion" :disabled="!productoSeleccionado || detallesSeleccionados.length === 0">
                Añadir a lista
              </button>

              <!-- Lista de asignaciones -->
              <div v-if="asignaciones.length">
                <table class="table table-bordered text-center">
                  <thead class="table-dark">
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
                            {{ detalle.stb }} - {{ detalle.smartcard }}
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
              <button class="btn btn-success w-100" type="submit" :disabled="asignaciones.length === 0">
                Asignar al pendiente
              </button>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios";
import Swal from "sweetalert2";

export default {
  data() {
    return {
        form: {
            users_id: '',
        },
        producto: {
            cod_producto: ''
        },
        productoSeleccionado: null,
        detalles: [],
        detallesSeleccionados: [],
        asignaciones: [],
        tecnicos: []
    };
  },
  mounted() {
    this.loadTecnicos();
  },
  methods: {
    loadTecnicos() {
      axios.get('/usuarios/listar')
        .then(res => this.tecnicos = res.data)
        .catch(err => console.error("Error cargando técnicos:", err));
    },

    buscarProducto() {
      axios.get(`/productdth/buscar/${this.producto.cod_producto}`)
        .then(response => {
            this.productoSeleccionado = response.data.producto;
            this.detalles = response.data.detalles;
            this.detallesSeleccionados = []; // Limpias solo la selección actual
        })
        .catch(error => {
            Swal.fire('Error', 'Producto no encontrado', 'error');
            this.productoSeleccionado = null;
            this.detalles = [];
        });
    },

    añadirAsignacion() {
      if (!this.productoSeleccionado || this.detallesSeleccionados.length === 0) {
        Swal.fire('Error', 'Debe seleccionar un producto y al menos un detalle', 'warning');
        return;
    }

    this.asignaciones.push({
        producto: this.productoSeleccionado,
        detalles: [...this.detallesSeleccionados] // copia por valor
    });

    // Limpiar solo la selección actual
    this.productoSeleccionado = null;
    this.detalles = [];
    this.detallesSeleccionados = [];
    this.producto.cod_producto = '';
    },

    eliminarAsignacion(index) {
      this.asignaciones.splice(index, 1);
    },

    guardarAsignaciones() {
    const asignaciones = {
        users_id: this.form.users_id, // o user_id si ese es tu campo real
        asignaciones: this.asignaciones.map(asignacion => ({
        producto_id: asignacion.producto.id,
        detalle_ids: asignacion.detalles.map(d => d.id), // ✅ este nombre debe coincidir
        }))
    };

    axios.post('/pendiente_productodth', asignaciones)
        .then(() => {
        Swal.fire("Éxito", "Asignaciones guardadas correctamente", "success");
        this.resetFormulario();
        })
        .catch((error) => {
        console.error(error.response?.data);
        Swal.fire("Error", "No se pudo guardar la asignación", "error");
        });
    },
    resetFormulario() {
      this.form.user_id = '';
      this.codigoProducto = '';
      this.productoSeleccionado = null;
      this.detalles = [];
      this.detallesSeleccionados = [];
      this.asignaciones = [];
    }
  }
};
</script>
