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
      name: "Crear",
      props: {
        clienteId: {
          type: Number,
          required: true
        },
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
                  servis_detalle: '',
                  servis_1: false,
                  servis_2: false,
                  servis_3: false,
                  servis_4: false,
                  servis_5: false,
                  servis_6: false,
                  servis_7: false,
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
            this.getCliente(); 
            this.getTecnico();  
            //this.cargarAsignaciones();  
        },
        methods: {
            regreso() {
                window.location.href = '/tecnico'; 
            },
            async getCliente(id) {
              try {
                const response = await axios.get(`/get/pendiente/${this.clienteId}`);
                const cliente = response.data;

                // Llenas los campos necesarios del form
                this.form.pendiente_id = cliente.id;
                this.form.abonado = cliente.abonado;
                this.form.nombre = cliente.nombres;
                this.form.rut = cliente.rut;
                this.form.direccion = cliente.direccion;
                this.form.fono = cliente.tlf_habitacion;
                this.form.comuna = cliente.comuna;
                this.form.ciudad = cliente.ciudad;
                this.form.celular = cliente.tlf_movil;
              } catch (error) {
                console.error(error);
                Swal.fire('Error', 'No se pudo cargar la información del cliente', 'error');
              }
            },
            async getTecnico() {
                try {
                  const response = await axios.get('/api/tecnico/actual');
                  this.form.name_tecnico = response.data.name;
                  this.form.user_id = response.data.id;
                } catch (error) {
                  console.error('Error al obtener técnico:', error);
                }
              },
              /*async cargarAsignaciones() {
                try {
                  const res = await axios.get(`/api/pendiente/${this.clienteId}/asignaciones`);
                  console.log('Asignaciones cargadas:', res.data);

                  const detalles = res.data.flatMap(p => p.detalles.map(d => d.detalle_producto));
                  
                  if (detalles[0]) this.form.settopbox1 = detalles[0].stb || '';
                  if (detalles[1]) this.form.settopbox2 = detalles[1].stb || '';
                  if (detalles[2]) this.form.settopbox3 = detalles[2].stb || '';
                  if (detalles[3]) this.form.settopbox4 = detalles[3].stb || '';

                  if (detalles[0]) this.form.smartcard1 = detalles[0].smartcard || '';
                  if (detalles[1]) this.form.smartcard2 = detalles[1].smartcard || '';
                  if (detalles[2]) this.form.smartcard3 = detalles[2].smartcard || '';
                  if (detalles[3]) this.form.smartcard4 = detalles[3].smartcard || '';

                } catch (e) {
                  console.error('Error al cargar asignaciones:', e);
                }
              },*/


            async formSubmit() {
                  try {
                    const response = await axios.post('/tecnico', this.form);
                    Swal.fire('Éxito', 'Venta registrada correctamente', 'success');
                    // Reseteamos los campos si deseas
                    // this.resetForm();
                  } catch (error) {
                    console.error(error); // Ahora sí usa correctamente el error
                    Swal.fire('Error', 'Verifica los campos obligatorios', 'error');
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
