
<template>
<div>
<div class="container">
     <Menu />
     <br>
     <h3>Reportes</h3>

   <table class="table table-hover  table-bordered">
    <thead>
      <tr>
        <th>Placa</th>
        <th>Marca</th>
        <th>Nombre del Conductor</th>
        <th>Nombre del Propietario </th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="report in reports" :key="report.id">
        <td>{{report.license_plate}}</td>
        <td>{{report.brand}}</td>
        <th v-if="report.drive_second_name == null">{{report.drive_first_name + " " +report.drive_last_name}}</th>
        <th v-else>{{report.drive_first_name + " "+report.drive_second_name + " "+report.drive_last_name}}</th>
        <th v-if="report.owner_second_name == null">{{report.owner_first_name + " " +report.owner_last_name}}</th>
        <th v-else>{{report.owner_first_name + " "+report.owner_second_name + " "+report.owner_last_name}}</th>
      </tr>
    </tbody>
  </table>
</div> 
</div>

</template>

<script>
import Menu from '../menu.vue'

export default {  
      components: {
          Menu
      },  
    data() {
            return {
                reports:{},
            }
        },
    mounted() {
      this.getReports();
    },
    methods: {
    getReports(){
          axios.get('api/vehicle/get').then((response) => {
            this.reports =response.data
         }).catch((errors) => {
            console.log(errors)
         })
    }
    }
}
</script>

<style>
</style>