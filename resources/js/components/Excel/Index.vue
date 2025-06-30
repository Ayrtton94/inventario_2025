<template>
  <div class="container py-5" v-if="can('impor_cliente.create')">
    <h2 class="mb-4 text-primary">📥 Importar Detalles desde Excel</h2>
    <input
      type="file"
      @change="handleFileUpload"
      accept=".xlsx,.xls"
      class="form-control mb-3"
    />
    <button
      class="btn btn-primary"
      @click="importExcel"
      :disabled="!file"
    >
      Importar y Guardar Detalles
    </button>
  </div>

  <div class="container py-5" v-if="can('impor_cliente.create')">
    <h2 class="mb-4 text-success">📦 Importar Productos desde Excel</h2>
    <input
      type="file"
      @change="handleFileUpload2"
      accept=".xlsx,.xls"
      class="form-control mb-3"
    />
    <button
      class="btn btn-success"
      @click="importExcel2"
      :disabled="!file2"
    >
      Importar y Guardar Productos
    </button>
  </div>

  <div class="container py-5" v-if="can('impor_cliente.create')">
    <h2 class="mb-4 text-warning">🔍 Importar Detalle de Productos desde Excel</h2>
    <input
      type="file"
      @change="handleFileUpload3"
      accept=".xlsx,.xls"
      class="form-control mb-3"
    />
    <button
      class="btn btn-warning"
      @click="importExcel3"
      :disabled="!file3"
    >
      Importar y Guardar Detalle Productos
    </button>
  </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
  data() {
    return {
      file: null,
      file2: null,
      file3: null,
      permissions: window.userPermissions || [],
    };
  },
  methods: {
    can(permission) {
      return this.permissions.includes(permission);
    },

    handleFileUpload(event) {
      this.file = event.target.files[0];
    },
    async importExcel() {
      const formData = new FormData();
      formData.append('file', this.file);

      try {
        const res = await axios.post('/import-excel', formData);
        Swal.fire("✅ ¡Éxito!", res.data.message, "success");
        this.file = null;
      } catch (error) {
        const msg = error.response?.data?.error || "Ocurrió un error inesperado.";
        Swal.fire("❌ Error", msg, "error");
        console.error("Error al importar:", error);
      }
    },

    handleFileUpload2(event) {
      this.file2 = event.target.files[0];
    },
    async importExcel2() {
      const formData = new FormData();
      formData.append('file', this.file2);

      try {
        const res = await axios.post('/api/import.excel', formData);
        Swal.fire("✅ ¡Éxito!", res.data.message, "success");
        this.file2 = null;
      } catch (error) {
        const msg = error.response?.data?.error || "Ocurrió un error inesperado.";
        Swal.fire("❌ Error", msg, "error");
        console.error("Error al importar:", error);
      }
    },

    handleFileUpload3(event) {
      this.file3 = event.target.files[0];
    },
    async importExcel3() {
      const formData = new FormData();
      formData.append('file', this.file3);

      try {
        const res = await axios.post('/api/importdetalle.excel', formData);
        Swal.fire("✅ ¡Éxito!", res.data.message, "success");
        this.file3 = null;
      } catch (error) {
        const msg = error.response?.data?.error || "Ocurrió un error inesperado.";
        Swal.fire("❌ Error", msg, "error");
        console.error("Error al importar:", error);
      }
    }
  }
};
</script>
