<template>
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <form @submit.prevent="formSubmit">
          <!-- Cabecera -->
          <div class="row mb-4">
            <div class="col-md-6">
              <label class="form-label">Nº Abonado</label>
              <input type="number" class="form-control" v-model="form.abonado" required readonly>
              <input type="number" class="form-control" v-model="form.pendiente_id" hidden>
            </div>
            <div class="col-md-6">
              <label class="form-label">Fecha</label>
              <input type="date" class="form-control" v-model="form.fecha_ingreso" required readonly>
            </div>
          </div>

          <!-- Información del cliente -->
          <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-primary text-white">
              <h5 class="mb-0">📝 Información del Cliente</h5>
            </div>
            <div class="card-body">
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label">Nombre titular</label>
                  <input type="text" class="form-control" v-model="form.nombre" required readonly>
                  <input type="text" class="form-control" v-model="form.pendiente_id" hidden>
                </div>
                <div class="col-md-6">
                  <label class="form-label">RUI</label>
                  <input type="text" class="form-control" v-model="form.rut" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Dirección</label>
                  <input type="text" class="form-control" v-model="form.direccion" required readonly>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Fono</label>
                  <input type="text" class="form-control" v-model="form.fono" required readonly>
                </div>
                <div class="col-md-4">
                  <label class="form-label">Comuna</label>
                  <input type="text" class="form-control" v-model="form.comuna" required>
                </div>
                <div class="col-md-4">
                  <label class="form-label">Ciudad</label>
                  <input type="text" class="form-control" v-model="form.ciudad" required>
                </div>
                <div class="col-md-4">
                  <label class="form-label">Celular</label>
                  <input type="text" class="form-control" v-model="form.celular" required>
                </div>
              </div>
            </div>
          </div>

          <!-- Datos empresa -->
          <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-primary text-white">
              <h5 class="mb-0">📅 Datos Empresa de Servicio</h5>
            </div>
            <div class="card-body row g-3">
              <div class="col-md-4">
                <label class="form-label">Técnico</label>
                <input type="text" class="form-control" v-model="form.name_tecnico" required readonly>
                <input type="text" class="form-control" v-model="form.user_id" hidden>
              </div>
              <div class="col-md-4">
                <label class="form-label">RUI</label>
                <input type="text" class="form-control" v-model="form.rut_tecnico" required>
              </div>
              <div class="col-md-4">
                <label class="form-label">Empresa</label>
                <input type="text" class="form-control" v-model="form.empresa" required>
              </div>
            </div>
          </div>

          <!-- Descripción del servicio -->
          <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-primary text-white">
              <h5 class="mb-0">🛠️ Descripción del Servicio</h5>
            </div>
            <div class="card-body">
              <div class="col" v-for="(label, idx) in serviceLabels" :key="idx">
              <div class="form-check">
                <input
                  class="form-check-input"
                  type="checkbox"
                  :id="`servis_${idx + 1}`"
                  v-model="form[`servis_${idx + 1}`]"
                >
                <label class="form-check-label" :for="`servis_${idx + 1}`">{{ label }}</label>
              </div>              
            </div>
            <div class="col-md-6">
                  <label class="form-label">Detalles</label>
                  <textarea class="form-control" rows="3" v-model="form.servis_detalle"></textarea>
                </div>
            </div>
          </div>

          <!-- Dispositivos -->
          <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-primary text-white">
              <h5 class="mb-0">🛠️ Dispositivos</h5>
            </div>
            <div class="card-body">
              <div class="row g-3 mb-2">
                <div class="col-md-6">
                  <label class="form-label">SetTopBox</label>
                  <input type="text" class="form-control" v-model="form.settopbox1">
                </div>
                <div class="col-md-6">
                  <label class="form-label">SmartCard</label>
                  <input type="text" class="form-control" v-model="form.smartcard1">
                </div>
              </div>
              <div class="row g-3 mb-2">
                <div class="col-md-6">
                  <label class="form-label">SetTopBox</label>
                  <input type="text" class="form-control" v-model="form.settopbox2">
                </div>
                <div class="col-md-6">
                  <label class="form-label">SmartCard</label>
                  <input type="text" class="form-control" v-model="form.smartcard2">
                </div>
              </div>
              <div class="row g-3 mb-2">
                <div class="col-md-6">
                  <label class="form-label">SetTopBox</label>
                  <input type="text" class="form-control" v-model="form.settopbox3">
                </div>
                <div class="col-md-6">
                  <label class="form-label">SmartCard</label>
                  <input type="text" class="form-control" v-model="form.smartcard3">
                </div>
              </div>
              <div class="row g-3 mb-2">
                <div class="col-md-6">
                  <label class="form-label">SetTopBox</label>
                  <input type="text" class="form-control" v-model="form.settopbox4">
                </div>
                <div class="col-md-6">
                  <label class="form-label">SmartCard</label>
                  <input type="text" class="form-control" v-model="form.smartcard4">
                </div>
              </div>
            </div>
          </div>

          <!-- Materiales -->
          <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-primary text-white">
              <h5 class="mb-0">🎛️ Materiales Usados</h5>
            </div>
            <div class="card-body row g-3">
              <div class="col-md-4">
                <label class="form-label">Antena</label>
                <input type="number" min="0" class="form-control" v-model="form.antena">
              </div>
              <div class="col-md-4">
                <label class="form-label">Conectores</label>
                <input type="number" min="0" class="form-control" v-model="form.conectores"> 
              </div>
              <div class="col-md-4">
                <label class="form-label">Pasamuros</label>
                <input type="number" min="0" class="form-control" v-model="form.pasamuros">
              </div>
            </div>
            <div class="card-body row g-3">
              <div class="col-md-4">
                <label class="form-label">LNB</label>
                <input type="number" min="0" class="form-control" v-model="form.lnb">
              </div>
              <div class="col-md-4">
                <label class="form-label">Spliter</label>
                <input type="number" min="0" class="form-control" v-model="form.spliter">
              </div>
              <div class="col-md-4">
                <label class="form-label">Cable HDMI</label>
                <input type="number" min="0" class="form-control" v-model="form.hdmi">
              </div>
            </div>
            <div class="card-body row g-3">
              <div class="col-md-4">
                <label class="form-label">Cables</label>
                <input type="number" min="0" class="form-control" v-model="form.cable">
              </div>
              <div class="col-md-4">
                <label class="form-label">Grampas</label>
                <input type="number" min="0" class="form-control" v-model="form.grampas">
              </div>
              <div class="col-md-4">
                <label class="form-label">Cable RCA</label>
                <input type="number" min="0" class="form-control" v-model="form.rca">
              </div>
            </div>
          </div>

          <!-- Botones -->
          <div class="d-flex justify-content-between">
            <button type="button" @click="regreso" class="btn btn-outline-secondary">
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
</template>

<script>
import Swal from 'sweetalert2';
import axios from 'axios';

    export default {
        name: "Editar",
      props: {
        tecnicoId: {
          type: Number,
          required: true
        },
      },
      data() {
          const today = new Date().toISOString().split('T')[0]; // "YYYY-MM-DD"
            return {
                form: {
                abonado: '',
                fecha_ingreso: today,
                pendiente_id: '', // ← importante
                nombre: '',
                direccion: '',
                comuna: '',
                ciudad: '',
                rut: '',
                fono: '',
                celular: '',
                user_id: '', // ← asegúrate que esto esté llegando (puedes hacer `auth()->id()` en el backend y no mandarlo desde Vue)
                rut_tecnico: '',
                empresa: '',
                servis_1: null,
                servis_2: null,
                servis_3: null,
                servis_4: null,
                servis_5: null,
                servis_6: null,
                servis_7: null,
                servis_detalle: '',
                settopbox1: '',
                settopbox2: '',
                settopbox3: '',
                settopbox4: '',
                smartcard1: '',
                smartcard2: '',
                smartcard3: '',
                smartcard4: '',
                antena: '',
                conectores: '',
                pasamuros: '',
                lnb: '',
                spliter: '',
                hdmi: '',
                cable: '',
                grampas: '',
                rca: ''
                },
                selectedServices: [],
                serviceLabels: [
                    "Instalación",
                    "Servicio Técnico",
                    "Retiro de Equipo",
                    "Decodificador Adicional",
                    "Cambio de Domicilio",
                    "Reparación",
                    "Modificación de Instalación",
                ],               
                
            };
        },
        mounted() {   
            this.getTecnico();        
        },
         methods: {
            regreso() {
                window.location.href = '/tecnico'; 
            },
            async getTecnico() {
                try {
                    const response = await axios.get(`/get/tecnico/${this.tecnicoId}`);

                    // Mantiene la estructura de `this.form` y solo actualiza los datos recibidos
                    Object.assign(this.form, response.data);

                    for (let i = 1; i <= 7; i++) {
                    const field = `servis_${i}`;
                    // Asegúrate de que si viene como "1" o "0", lo conviertes a booleano
                    this.form[field] = Boolean(this.form[field]);
                    }

                } catch (error) {
                    console.error(error);
                    Swal.fire('Error', 'No se pudo cargar la información del cliente', 'error');
                }
            },

            formSubmit() {
                try {
                    axios.post('/tecnico', this.form)
                    .then(() => {
                        Swal.fire('Éxito', 'Venta registrada correctamente', 'success');
                        // this.resetForm(); // Opcional
                    })
                    .catch((err) => {
                        console.error(err);
                        Swal.fire('Error', 'Verifica los campos obligatorios', 'error');
                    });

                } catch (error) {
                    console.error(error);
                    Swal.fire('Error', 'Error interno', 'error');
                }
                },

            resetForm() {
                this.form = {
                    abonado: '',
                    fecha_ingreso: '',
                    pendiente_id: '',
                    nombre: '',
                    rut: '',
                    direccion: '',
                    fono: '',
                    comuna: '',
                    ciudad: '',
                    celular: '',
                    rut_tecnico: '',
                    rui: '',
                    empresa: '',
                    servis_detalle: '',
                    settopbox1: '',
                    settopbox2: '',
                    settopbox3: '',
                    settopbox4: '',
                    smartcard1: '',
                    smartcard2: '',
                    smartcard3: '',
                    smartcard4: '',
                    antena: '',
                    conectores: '',
                    pasamuros: '',
                    lnb: '',
                    spliter: '',
                    hdmi: '',
                    cable: '',
                    grampas: '',
                    rca: '',
                    servis_1: null,
                    servis_2: null,
                    servis_3: null,
                    servis_4: null,
                    servis_5: null,
                    servis_6: null,
                    servis_7: null,
                  };
          this.selectedServices = [];

         }


         }
    }
</script>
<style scoped>
.card-header h5 {
  font-weight: bold;
}
</style>
