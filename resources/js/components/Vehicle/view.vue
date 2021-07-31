
<template>
<div>
<div class="container">
     <Menu />
     <br>
    <button class="btn btn-success" data-toggle="modal" data-target="#addNew" @click="openModalWindow">Crear Vehiculo <i></i></button>

   <table class="table table-hover  table-bordered">
    <thead>
      <tr>
        <th>Id</th>
        <th>Placa</th>
        <th>Color</th>
        <th>Marca</th>
        <th>Tipo de vehiculo</th>
        <th>Conductor</th>
        <th>Propietario </th>
        <th>Accion</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="vehicle in vehicles" :key="vehicle.id">
        <td>{{vehicle.id}}</td>
        <td>{{vehicle.license_plate}}</td>
        <td>{{ vehicle.color }}</td>
        <td>{{vehicle.brand}}</td>
        <td v-if="vehicle.vehicle_type == 1">particular</td>
        <th v-else>publico</th>
        <th>{{vehicle.drive_first_name + " " +vehicle.drive_last_name}}</th>
        <th>{{vehicle.owner_first_name + " " +vehicle.owner_last_name}}</th>
        <td><a href="#" data-id="user.id" class="btn btn-info" @click="editModalWindow(vehicle)"> Editar</a>
            <a href="#" class="btn btn-danger" @click="DeletePerson(vehicle.id)">Eliminar</a>
        </td>
      </tr>
    </tbody>
  </table>
     <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">

                    <h5 v-show="!editMode" class="modal-title" id="addNewLabel">Crear Vehículo </h5>
                    <h5 v-show="editMode" class="modal-title" id="addNewLabel">Actualizar Vehículor</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
               <form @submit.prevent="editMode ? updateVehicle() : createVehicle()">
                     <div class="modal-body">
                      <div class="form-group">
                       <label for="document_number">Placa </label>
                        <input v-model="form.license_plate" type="text"  placeholder="Placa" class="form-control" >
                        <p class="text-danger" v-text="errors.license_plate"></p>

                    </div>

                    <div class="form-group">
                     <label for="first_name">Color</label>
                     <input v-model="form.color" type="color"  placeholder="Coloar " class="form-control" >
                       <p class="text-danger" v-text="errors.color"></p>
                   </div>

                   <div class="form-group">
                      <label for="second_name">Marca</label>

                     <input v-model="form.brand" type="text"  placeholder="Marca" class="form-control"  >
                      <p class="text-danger" v-text="errors.brand"></p>

                   </div>

                   <div class="form-group">
                      <label  for="rol">Tipo de vehiculo</label>

                      <select name="vehicle_type" v-model="form.vehicle_type" id="role" class="form-control" placeholder="Seleccione">
                        <option value="">Seleccione</option>
                        <option value="2">Publico</option>
                        <option value="1">Particular</option>
                      </select>
                        <p class="text-danger" v-text="errors.vehicle_type"></p>
                   </div>

                    <div class="form-group">
                      <label >Conductor</label>
                       <select  v-model="form.driver_id" class="form-control" placeholder="Seleccione">
                             <option value="" selected>Seleccione</option>
                            <option v-for="person in persons" v-bind:value="person.id">
                              {{ person.first_name+ " " +person.last_name }}
                       </option>
                      </select>
                        <p class="text-danger" v-text="errors.driver_id"></p>
                   </div>

                     <div class="form-group">
                      <label  >Propietario</label>
                       <select  v-model="form.owner_id"  class="form-control" placeholder="Seleccione">
                            <option value="" selected>Seleccione</option>
                            <option  v-for="person in persons" v-bind:value="person.id">
                              {{ person.first_name+ " " +person.last_name }}
                           </option>
                      </select>
                        <p class="text-danger" v-text="errors.owner_id"></p>
                   </div>
              </div>
             <div class="modal-footer">
               <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
               <button v-show="editMode" type="submit" class="btn btn-primary">Update</button>
               <button v-show="!editMode" type="submit" class="btn btn-primary">Create</button>
           </div>
        </form>
       </div>
    </div>
</div>
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
                editMode: false,
                persons: {},
                vehicles:{},
                form: {
                    id: '',
                    license_plate : '',
                    color: '',
                    brand: '',
                    vehicle_type: '',
                    driver_id:'',
                    owner_id:'',
                },
                 errors: {},
            }
        },
    mounted() {
      this.getPerson();
      this.getVehicle();
    },
    methods: {
    getPerson(){ 
          axios.get('api/person/get').then((response) => {
            this.persons =response.data
         }).catch((errors) => {
            console.log(errors)
         })
    },
    getVehicle(){
          axios.get('api/vehicle/get').then((response) => {
            this.vehicles =response.data
         }).catch((errors) => {
            console.log(errors)
         })
    },
    createVehicle(){
     if (this.form.license_plate == '') {
            Swal.fire({
                icon: 'error',title: 'el campo placa es obligatorio'
              })
      }else if (this.form.color =='') {
          Swal.fire({
                icon: 'error',title: 'el campo color nombre es obligatorio'
              });
      }else if(this.form.brand ==''){
               Swal.fire({
                icon: 'error',title: 'el campo marca es obligatorio'
              });
      }else if (this.form.vehicle_type == ''){
            Swal.fire({
                icon: 'error',title: 'el campo tipo de vehiculo es obligatorio'
              });
              //
      }else if (this.form.driver_id ==''){
              Swal.fire({
                icon: 'error',title: 'el campo conductor es obligatorio'
              });
     }else if (this.form.owner_id == ''){
               Swal.fire({
                icon: 'error',title: 'el campo propietario  debe ser numerico'
              });       
      }else{
         axios.post('api/vehicle/create',this.form).then((response) => {
             $('#addNew').modal('hide');
             Swal.fire({
               icon: 'success',title: 'El vehículo se ha registrado con exito'
              })
             this.getVehicle();
         }).catch((errors) => {
           this.errors = errors.response.data.errors
           Swal.fire({
                icon: 'error',title: 'ha ocurrido un fallo en el servidor'
              })
         })
      }
    },
    updateVehicle (){
          const data  = this.form
     if (data.license_plate == '') {
            Swal.fire({
                icon: 'error',title: 'el campo placa es obligatorio'
              })
      }else if (data.color =='') {
          Swal.fire({
                icon: 'error',title: 'el campo color nombre es obligatorio'
              });
      }else if(data.brand ==''){
               Swal.fire({
                icon: 'error',title: 'el campo marca es obligatorio'
              });
      }else if (data.vehicle_type == ''){
            Swal.fire({
                icon: 'error',title: 'el campo tipo de vehiculo es obligatorio'
              });
              //
      }else if (data.driver_id ==''){
              Swal.fire({
                icon: 'error',title: 'el campo conductor es obligatorio'
              });
     }else if (data.owner_id == ''){
               Swal.fire({
                icon: 'error',title: 'el campo propietario  debe ser numerico'
              });       
      }else{
          axios.post('api/vehicle/update',data).then((response) => {
            $('#addNew').modal('hide');
             Swal.fire({
                icon: 'success',title: 'el vehículo se ha actualizado con exito'
              })
              this.getVehicle()
         }).catch((errors) => {
          this.errors = errors.response.data.errors
               Swal.fire({
                icon: 'error',title: 'ha ocurrido un fallo en el servidor'
              })
         })
      }
     
    },
    DeletePerson(data){
      Swal.fire({
        title: 'Esta seguro de eliminar el vehículo !',
       showCancelButton: true,
         icon: 'warning',
       confirmButtonText: `Eliminar`,
       }).then((result) => {
         if (result.value) {
             const dato= {
                 'id':data
             }
          axios.post('api/vehicle/delete',dato).then((response) => {
            Swal.fire({
                icon: 'success',title: 'el vehículo se ha eliminado con exito'
              })
              this.getVehicle()
         }).catch((errors) => {
               Swal.fire({
                icon: 'error',title: 'ha ocurrido un fallo en el servidor'
              })
         })
     }
    })
        
      
    },
    openModalWindow(){
         this.errors ={}
         this.editMode = false
          this.form= {
                    id: '',
                    license_plate : '',
                    color: '',
                    brand: '',
                    vehicle_type: '',
                    driver_id:'',
                    owner_id:''
                },
        $('#addNew').modal('show');
     },
     editModalWindow(data){

          const dato ={
              'id':data.id,
              'license_plate' :data.license_plate,
              'color':data.color,
              'brand':data.brand,
              'vehicle_type':data.vehicle_type,
              'driver_id':data.driver_id,
              'owner_id':data.owner_id
          }
        this.errors ={}
        this.form={}
        this.editMode = true;
         this.form =dato
        $('#addNew').modal('show');
        }
    }
}
</script>

<style>
</style>