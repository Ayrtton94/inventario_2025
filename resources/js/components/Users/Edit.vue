<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Editar Usuario</div>

          <div class="card-body">
            <table class="table">
              <thead>
                <tr>
                  <th><p class="h5">Nombre:</p></th>
                  <th><input v-model="users.name" type="text" class="form-control" required /></th>
                  <th><p class="h5">Email:</p></th>
                  <th><input v-model="users.email" type="email" class="form-control" required /></th>
                </tr>
              </thead>
            </table>

            <div class="form-check" v-for="form in forms" :key="form.id">
              <input
                class="form-check-input"
                type="checkbox"
                :id="'checkbox-' + form.id"
                :value="form.id"
                v-model="selectedForms"
              >
              <label class="form-check-label" :for="'checkbox-' + form.id">
                {{ form.name }}
              </label>
            </div>

            <button @click="actualizarUsuario" class="btn btn-primary mt-3">
                Guardar Cambios
            </button>

          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Swal from 'sweetalert2';
import axios from 'axios';

export default {
  name: "Editar",
  props: {
    usuariosId: {
      type: Number,
      required: true,
    },
  },

  data() {
    return {
      users: {},
      forms: [],              // Aquí van los roles o formularios
      selectedForms: [],      // Para los IDs seleccionados
    };
  },

  mounted() {
    this.getUsuarios();
    this.getRoles();
  },

  methods: {
    async getUsuarios() {
      try {
        const response = await axios.get(`/get/user/${this.usuariosId}`);
        this.users = response.data;
        console.log("Usuario:", this.users);
      } catch (error) {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: error.response?.data?.error || 'No se pudo cargar el usuario',
          timer: 2000
        });
      }
    },

    async getRoles() {
      try {
        const response = await axios.get(`/get/roles`);
        this.forms = response.data;
        console.log("Formularios/Roles:", this.forms);
      } catch (error) {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: error.response?.data?.error || 'No se pudieron cargar los roles',
          timer: 2000
        });
      }
    },

    /*async actualizarUsuario() {
        try {
            const payload = {
                name: this.users.name,
                email: this.users.email,
                roles: this.selectedForms
            };

            const response = await axios.put(`/user/${this.usuariosId}`, payload);

            Swal.fire({
                icon: 'success',
                title: 'Usuario actualizado',
                text: response.data.message || 'Los datos se guardaron correctamente',
                timer: 2000
            });
        } catch (error) {
                Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error.response?.data?.error || 'No se pudo actualizar el usuario',
                timer: 2000
            });
        }
    }*/

    validarFormulario() {
  if (!this.users.name || !this.users.email) {
    Swal.fire({
      icon: 'warning',
      title: 'Campos obligatorios',
      text: 'Por favor completa nombre y email',
      timer: 2000
    });
    return false;
  }

  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailRegex.test(this.users.email)) {
    Swal.fire({
      icon: 'warning',
      title: 'Email inválido',
      text: 'Por favor escribe un email válido',
      timer: 2000
    });
    return false;
  }

  if (this.selectedForms.length === 0) {
    Swal.fire({
      icon: 'warning',
      title: 'Roles faltantes',
      text: 'Debes seleccionar al menos un rol',
      timer: 2000
    });
    return false;
  }

  return true;
},

async actualizarUsuario() {
  if (!this.validarFormulario()) return;

  try {
    const payload = {
      name: this.users.name,
      email: this.users.email,
      roles: this.selectedForms
    };

    const response = await axios.put(`/user/${this.usuariosId}`, payload);

    Swal.fire({
      icon: 'success',
      title: 'Usuario actualizado',
      text: response.data.message || 'Los datos se guardaron correctamente',
      timer: 2000
    });
  } catch (error) {
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: error.response?.data?.error || 'No se pudo actualizar el usuario',
      timer: 2000
    });
  }
}



  }
};
</script>
