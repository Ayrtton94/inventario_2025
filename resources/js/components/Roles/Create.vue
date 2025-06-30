<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Crear Rol</div>
          <div class="card-body">
            <form @submit.prevent="formSubmit">
              <div class="form-group mb-3">
                <label for="name">Nombre</label>
                <input type="text" v-model="form.name" class="form-control" />
              </div>

              <div class="form-group mb-4">
                <label>Permisos</label>
                <div
                  class="form-check"
                  v-for="role in roles"
                  :key="role.id"
                >
                  <input
                    class="form-check-input"
                    type="checkbox"
                    :id="'checkbox-' + role.id"
                    :value="role.id"
                    v-model="selectedForms"
                  />
                  <label
                    class="form-check-label"
                    :for="'checkbox-' + role.id"
                  >
                    {{ role.name }}
                  </label>
                </div>
              </div>

              <div class="d-flex justify-content-between mt-4">
                <button
                  type="button"
                  @click="regreso"
                  class="btn btn-outline-secondary"
                >
                  <i class="fas fa-arrow-left me-2"></i>Regresar
                </button>
                <button type="submit" class="btn btn-primary">
                  <i class="fas fa-save me-2"></i>Guardar
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Swal from "sweetalert2";
import axios from "axios";

export default {
  data() {
    return {
      form: {
        name: "",
        permissions: [],
      },
      roles: [],
      selectedForms: [],
    };
  },
  mounted() {
    this.getPermission();
  },
  methods: {
    regreso() {
      window.location.href = "/roles";
    },
    async getPermission() {
      try {
        const response = await axios.get("/get/permission");
        this.roles = response.data;
      } catch (error) {
        Swal.fire({
          icon: "error",
          title: "Error",
          text:
            error.response?.data?.error || "No se pudieron cargar los roles",
          timer: 2000,
        });
      }
    },
    validarFormulario() {
      if (!this.form.name.trim()) {
        Swal.fire({
          icon: "warning",
          title: "Campos obligatorios",
          text: "Por favor completa el nombre del rol",
          timer: 2000,
        });
        return false;
      }

      if (this.selectedForms.length === 0) {
        Swal.fire({
          icon: "warning",
          title: "Permisos faltantes",
          text: "Debes seleccionar al menos un permiso",
          timer: 2000,
        });
        return false;
      }

      return true;
    },
    async formSubmit() {
      if (!this.validarFormulario()) return;

      this.form.permissions = this.selectedForms;

      try {
        const response = await axios.post("/roles", this.form);
        Swal.fire("✅ Éxito", "Rol registrado correctamente", "success");
        this.resetForm();
      } catch (error) {
        Swal.fire(
          "❌ Error",
          error.response?.data?.message || "Ocurrió un error al guardar",
          "error"
        );
      }
    },
    resetForm() {
      this.form = { name: "", permissions: [] };
      this.selectedForms = [];
    },
  },
};
</script>
