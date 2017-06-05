<template>
  <div>

    <div class="btn-group">
      <i class="fa fa-filter"></i>
      <input id="search" type="text" v-model="search">
      <span id="searchclear" @click="search = ''" class="glyphicon glyphicon-remove-circle"></span>
    </div>


    <table class="table table-striped" style="border-collapse:collapse;">
      <thead>
        <tr>
          <th></th>
          <th>id</th>
          <th>First</th>
          <th>Last</th>
          <th>Email</th>
          <th>Role</th>
          <th>Department</th>
        </tr>
      </thead>
      <tbody>

        <template v-for="(user, userKey) in results">
          <tr @click="select(user)" >
            <td data-toggle="collapse" :data-target="'#row'+userKey" class="accordion-toggle" aria-expanded="false">
              <i class="fa fa-chevron-right fa-fw"></i>
              <i class="fa fa-chevron-down fa-fw"></i>
            </td>
            <td>{{user.id}}</td>
            <td>{{user.first_name}}</td>
            <td>{{user.last_name}}</td>
            <td>{{user.email}}</td>
            <td>
              <multiselect
                v-model="user.roles"
                :options="roles"
                :multiple="true"
                track-by="name"
                label="name"
                :hideSelected="true"
                :close-on-select="false"
                @input="onSelectRoles"
                >
                <template slot="option" scope="props">
                  <div class="option__desc">
                     <span class="option__title">{{ props.option.name }}</span>
                 </div>
             </template>
         </multiselect>




            </td>
            <td>
             <multiselect
             v-model="user.departments"
             :options="departments"
             :multiple="true"
             track-by="name"
             label="name"
             :hideSelected="true"
             :close-on-select="false"
             @input="onSelectDepartment"
             >
             <template slot="option" scope="props">
              <div class="option__desc">
               <span class="option__title">{{ props.option.name }}</span>
              </div>
             </template>
            </multiselect>
            </td>
          </tr>

          <tr>
            <td colspan="6" style="padding: 0">
              <div class="container-fluid">


                <div class="accordian-body collapse" :id="'row'+userKey" style="margin:20px 60px 50px" >

                  <div class="row">
                    <div class="col-md-8">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email" :value="user.email">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputFile">File input</label>
                        <input type="file" id="exampleInputFile">
                        <p class="help-block">Example block-level help text here.</p>
                      </div>
                      <div class="checkbox">
                        <label>
                          <input type="checkbox"> Check me out
                        </label>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                      </div>

                      <div class="form-group">
                        <button type="submit" class="btn btn-default">Submit</button>
                      </div>
                    </div>
                  </div>

                </div>

              </div>
            </td>
          </tr>
        </template>



      </tbody>
    </table>
  </div>
</template>

<script>
 import Fuse from 'fuse.js';
 import _ from 'lodash';
 import toastr from 'toastr';


  export default {
    data() {
      return {
        users:[],
        roles:[],
        departments: [],
        currentUser:{},
        search: '',
        fuse: null,
        results: []

      }
    },
    methods: {

     select: function (currentUser) {
      this.currentUser = currentUser
     },
      onSelectDepartment: function(e){
        var vm = this;



        console.log('onSelectDepartment',this.users[this.currentUser.id]);

        axios.post('/api/v1/users/'+ this.currentUser.id +'/sync/departments',
         this.users[this.currentUser.id].departments)
        .then(function (response) {
         // console.clear();
         var items = response.data
         console.log(items);

         _.each(items['attached'], function(item){
          toastr["success"]("Added department: " + item.name)
         })

         _.each(items['detached'], function(item){
          toastr["warning"]("Removed department: " + item.name)
         })
        })
        .catch(vm.handleError);
       },

        onSelectRoles: function(e){

        console.log('onSelectRoles', e);
        var vm = this;

        // console.log(data)

        // axios.post('/api/v1/users/'+ this.currentItem.id +'/sync/departments', data)
        // .then(function (response) {
        //  console.clear();
        //  var items = response.data
        //  console.log(items);

        //  _.each(items['attached'], function(item){
        //   toastr["success"]("Added department: " + item.name)
        //  })

        //  _.each(items['detached'], function(item){
        //   toastr["warning"]("Removed department: " + item.name)
        //  })
        // })
        // .catch(vm.handleError);
       },



    },
    watch: {
      search: function() {
        if (this.search.trim() === ''){
          this.results = this.users
        }
        else{
          this.results = this.fuse.search(this.search.trim())
        }
      }
    },

    mounted() {
      var vm = this;
      console.log('Component mounted.')


      var options = {
        caseSensitive: false,
        tokenize: true,
        threshold: 0.6,
        location: 0,
        distance: 900,
        maxPatternLength: 32,
        minMatchCharLength: 1,
        keys: [
        "id",
        "first_name",
        "last_name",
        "email",
        "roles.name"
        ]
      };



      axios.get('/api/v1/users?with=roles,departments')
      .then(function (response) {
        console.log(response);
        vm.users = response.data;

        vm.fuse = new Fuse(response.data, options);
        vm.results = vm.users
      })
      .catch(function (error) {
        console.log(error);
      });

      axios.get('/api/v1/roles?fields=id,name')
      .then(function (response) {
        console.log(response);
        vm.roles = response.data;
      })
      .catch(function (error) {
        console.log(error);
      });

      axios.get('/api/v1/roles?fields=id,name')
      .then(function (response) {
        console.log(response);
        vm.roles = response.data;
      })
      .catch(function (error) {
        console.log(error);
      });

      axios.get('/api/v1/departments?fields=id,name')
      .then(function(response){
       vm.departments = response.data
      })
      .catch(vm.handleError);






    }
  }
</script>
