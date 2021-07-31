
<template>
<div>
<div class="container">
     <Menu />
     <br>
    <button class="btn btn-success" data-toggle="modal" data-target="#addNew" @click="openModalWindow">Crear Propietario/Conductor <i></i></button>

   <table class="table table-hover  table-bordered">
    <thead>
      <tr>
        <th>Id</th>
        <th>Numero de Cedula</th>
        <th>Nombre Completo</th>
        <th>Direccion</th>
        <th>Telefono</th>
        <th>Cuidad</th>
        <th>Accion</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="person in persons" :key="person.id">
        <td>{{person.id}}</td>
        <td>{{person.document_number}}</td>
        
        <td v-if="person.second_name == null">{{person.first_name + " "+person.last_name}}</td>
        <th v-else>{{person.first_name + " "+person.second_name +" "+person.last_name}}</th>
        <td>{{person.address}}</td>
        <td>{{person.telephone}}</td>
        <td>{{person.city}}</td>
        <td><a href="#" data-id="user.id" class="btn btn-info" @click="editModalWindow(person)"> Editar</a>
            <a href="#" class="btn btn-danger" @click="DeletePerson(person.id)">Eliminar</a>
        </td>

      </tr>
    </tbody>
  </table>
     <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">

                    <h5 v-show="!editMode" class="modal-title" id="addNewLabel">Crear Propietario/Conductor </h5>
                    <h5 v-show="editMode" class="modal-title" id="addNewLabel">Actualizar Propietario/Conductor</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
               <form @submit.prevent="editMode ? updatePerson() : createPerson()">
                     <div class="modal-body">
                      <div class="form-group">
                       <label for="document_number">Numero de cedula </label>
                        <input v-model="form.document_number" type="number"  placeholder="Primer Nombre" class="form-control" >
                        <p class="text-danger" v-text="errors.document_number"></p>

                    </div>

                    <div class="form-group">
                     <label for="first_name">Primer Nombre</label>
                     <input v-model="form.first_name" type="text"  placeholder="Segundo Nombre " class="form-control" >
                       <p class="text-danger" v-text="errors.first_name"></p>
                   </div>

                   <div class="form-group">
                      <label for="second_name">Segundo Nombre</label>

                     <input v-model="form.second_name" type="text"  placeholder="Segundo Nombre" class="form-control"  >
                      <p class="text-danger" v-text="errors.second_name"></p>

                   </div>

                   <div class="form-group">
                      <label  for="rol">Apellidos</label>
                      <input v-model="form.last_name" type="text"  placeholder="Apellidos" class="form-control"  >
                        <p class="text-danger" v-text="errors.last_name"></p>
                   </div>

                    <div class="form-group">
                      <label  for="rol">Direccion</label>
                      <input v-model="form.address" type="text"  placeholder="Direccion" class="form-control"  >
                        <p class="text-danger" v-text="errors.address"></p>
                   </div>

                    <div class="form-group">
                      <label  for="rol">Telefono</label>
                      <input v-model="form.telephone" type="number"  placeholder="Telefono" class="form-control"  >
                        <p class="text-danger" v-text="errors.telephone"></p>
                   </div>

                    <div class="form-group">
                      <label  for="rol">Ciudad</label>
                      <input v-model="form.city" type="text"  placeholder="Ciudad" class="form-control"  >
                        <p class="text-danger" v-text="errors.city"></p>
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
                form: {
                    id: '',
                    document_number : '',
                    first_name: '',
                    second_name: '',
                    last_name: '',
                    address:'',
                    telephone:'',
                    city:''
                },
                formedit:{},
                 errors: {},
                 buscar: ''
            }
        },
    mounted() {
      this.getPerson();
    
    },
    methods: {
    getPerson(){ 
          axios.get('api/person/get').then((response) => {
            this.persons =response.data
         }).catch((errors) => {
            console.log(errors)
         })
    },
    createPerson(){
        if (this.form.document_number == '') {
            Swal.fire({
                icon: 'error',title: 'el campo numero de cedula es obligatorio'
              })
        }else if (isNaN(this.form.document_number)) {
             Swal.fire({
                icon: 'error',title: 'el campo numero de cedula  debe ser numerico'
              })
      }else if (this.form.first_name =='') {
          Swal.fire({
                icon: 'error',title: 'el campo primer nombre es obligatorio'
              });
      }else if(this.form.last_name ==''){
               Swal.fire({
                icon: 'error',title: 'el campo  apellidos es obligatorio'
              });
      }else if (this.form.address == ''){
            Swal.fire({
                icon: 'error',title: 'el campo direccion es obligatorio'
              });
              //
      }else if (this.form.telephone ==''){
              Swal.fire({
                icon: 'error',title: 'el campo telefono es obligatorio'
              });
     }else if (isNaN(this.form.telephone)){
               Swal.fire({
                icon: 'error',title: 'el campo telefono debe ser numerico'
              });       
      }else if(this.form.city == ''){
            Swal.fire({
                icon: 'error',title: 'el campo ciudad es obligatorio'
              });
      }else{
         axios.post('api/person/create',this.form).then((response) => {
            this.users =response.data
             $('#addNew').modal('hide');
             Swal.fire({
               icon: 'success',title: 'El propietario/conductor se ha registrado con exito'
              })
             this.getPerson();
         }).catch((errors) => {
           this.errors = errors.response.data.errors
           Swal.fire({
                icon: 'error',title: 'ha ocurrido un fallo en el servidor'
              })
         })
      }
    },
    updatePerson(){
      const data  = this.form
      if (data.document_number == ''  && !Number(data.document_number)) {
            Swal.fire({
                icon: 'error',title: 'el campo numero de cedula es obligatorio'
              })
     }else if (isNaN(this.form.document_number)) {
             Swal.fire({
                icon: 'error',title: 'el campo numero de cedula  debe ser numerico'
              })
      }else if (data.first_name =='') {
          Swal.fire({
                icon: 'error',title: 'el campo primer nombre es obligatorio'
              });
      }else if(data.last_name ==''){
               Swal.fire({
                icon: 'error',title: 'el campo  apellidos es obligatorio'
              });
      }else if (data.address == ''){
            Swal.fire({
                icon: 'error',title: 'el campo direccion es obligatorio'
              });
      }else if (data.telephone ==''){
              Swal.fire({
                icon: 'error',title: 'el campo telefono es obligatorio'
              });
      } else if (isNaN(this.form.telephone)){
               Swal.fire({
                icon: 'error',title: 'el campo telefono debe ser numerico'
              });  
      }else if(data.city == ''){
            Swal.fire({
                icon: 'error',title: 'el campo ciudad es obligatorio'
              });
      }else{
          axios.post('api/person/update',data).then((response) => {
            const index = this.persons.findIndex(item => item.id === data.id);
             this.persons[index] = data

            $('#addNew').modal('hide');
             Swal.fire({
                icon: 'success',title: 'propietario/ conductor se ha actualizado con exito'
              })
              this.getPerson()
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
        title: 'Esta seguro de eliminar el propietario/conductor!',
       showCancelButton: true,
         icon: 'warning',
       confirmButtonText: `Eliminar`,
       }).then((result) => {
         if (result.value) {
             const dato= {
                 'id':data
             }
          axios.post('api/person/delete',dato).then((response) => {
            Swal.fire({
                icon: 'success',title: 'propietario/conductor eliminado con exito'
              })
              this.getPerson()
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
                    document_number : '',
                    first_name: '',
                    second_name: '',
                    last_name: '',
                    address:'',
                    telephone:'',
                    city:''
                },
        $('#addNew').modal('show');
     },
     editModalWindow(data){

          const dato ={
              'id':data.id,
              'document_number' :data.document_number,
              'first_name':data.first_name,
              'second_name':data.second_name,
              'last_name':data.last_name,
              'address':data.address,
              'telephone':data.telephone,
              'city':data.city
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