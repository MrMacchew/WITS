<template>
  <div>
  <input id="search" type="text" v-model="search">

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

        <template v-for="(user, userKey) in result">
          <tr>
            <td data-toggle="collapse" :data-target="'#row'+userKey" class="accordion-toggle" aria-expanded="false">
              <i class="fa fa-chevron-right fa-fw"></i>
              <i class="fa fa-chevron-down fa-fw"></i>
            </td>
            <td>{{user.id}}</td>
            <td>{{user.first_name}}</td>
            <td>{{user.last_name}}</td>
            <td>{{user.email}}</td>
            <td >
              <select name="" class='form-control '>
                <option v-for="role in roles" :value="role.name" :selected="role.name == user.roles[0].name"> {{role.name}} </option>
              </select>
            </td>
            <td>{{user.department}}</td>
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

                  <form>

                    Form

                  </form>

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


  export default {
    data: function(){
      return {
        users:[],
        roles:[],
        search: '',
        fuse: null,
        result: []

      }
    },
    methods: {

    },
    watch: {
      search: function() {
        if (this.search.trim() === ''){
          this.result = this.users
        }
        else{
          this.result = this.fuse.search(this.search.trim())
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
        vm.result = vm.users
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





    }
  }
</script>
