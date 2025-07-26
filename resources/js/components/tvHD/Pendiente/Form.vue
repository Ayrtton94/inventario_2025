<template>
    <div class="container py-4">
  
      <!-- 🟩 FORMULARIO PRINCIPAL COMPACTO -->
      <div class="mb-5">
        <h3 class="mb-4">📋 Información de Ventas Pendientes</h3>
  
        <table class="table table-bordered w-75 mx-auto text-center align-middle shadow">
          <thead class="table-dark">
            <tr>
              <th>Campo</th>
              <th>Valor</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(label, index) in campos" :key="index">
              <td><strong>{{ label }}</strong></td>
              <td><input type="text" class="form-control" /></td>
            </tr>
          </tbody>
        </table>
      </div>
  
      <!-- 🟩 DOS TABLAS AL COSTADO -->
      <div class="row">
        <!-- Primera tabla -->
        <div class="col-md-6 mb-4">
          <div class="table-responsive shadow">
            <table class="table table-bordered text-center align-middle">
              <thead class="table-success text-dark">
                <tr>
                  <th v-for="(th, i) in columnas" :key="'col1-' + i"><strong>{{ th }}</strong></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td v-for="(th, i) in columnas" :key="'input1-' + i">
                    <input type="text" class="form-control" />
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
  
        <!-- Segunda tabla -->
        <div class="col-md-6 mb-4">
          <div class="table-responsive shadow">
            <table class="table table-bordered text-center align-middle">
              <thead class="table-info text-dark">
                <tr>
                  <th v-for="(th, i) in columnas2" :key="'col2-' + i"><strong>{{ th }}</strong></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td v-for="(th, i) in columnas2" :key="'input2-' + i">
                    <input type="text" class="form-control" />
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
  
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        campos: [
          'Departamento', 'Provincia', 'Municipio',
          'TipoCliente', 'Grupo Afinidad', 'Origen',
          'Fecha Ingreso Desde', 'Fecha Ingreso Hasta'
        ],
        columnas: [
          'Origen', 'Departamento', 'Provincia', 'Municipio', 'Dirección',
          'Abonado', 'Nombres y Apellidos', 'Tlf. Habitación', 'Tlf. Móvil',
          'DTH', 'Cnt. Equipos', 'Tipo Instalación', 'Fecha Ingreso',
          'Fecha Age.', 'Distribuidor Age.', 'Tipo Cliente-Grupo Afinidad',
          'Origen Abonado'
        ],
        columnas2: [
          'Contrato', 'Fecha Ingreso', 'Tipo Instalación'
        ]
      };
    }
  };
  </script>
  
  <style scoped>
  .table th,
  .table td {
    vertical-align: middle !important;
  }
  </style>
  