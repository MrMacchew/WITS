<template>
  <div id="department-vue" class="container-fluid">
    <aside class="col-md-3 col-xs-12">
      <ui-collapsible title="Add Department" @close="resetNewDepartment()" open>


        <form @submit.prevent="onSubmitDepartment">

          <!-- <input  name="_method" type="hidden" value="POST"> -->

          <ui-textbox
          floating-label
          error="This field is required"
          label="Department Name"
          placeholder="Department Name"
          v-model="newDepartment.name"
          required
          :invalid="newDepartment.name_touched && newDepartment.name.length === 0"
          @touch="newDepartment.name_touched = true"
          />

          <ui-textbox
          floating-label
          error="This field is required"
          label="Primary Contact Name"
          placeholder="Primary Contact"
          v-model="newDepartment.primary_contact_name"
          required
          :invalid="newDepartment.primary_contact_name_touched && newDepartment.primary_contact_name.length === 0"
          @touch="newDepartment.primary_contact_name_touched = true"
          />

          <ui-textbox
          floating-label
          error="This field is required"
          label="Phone"
          placeholder="Primary Contact"
          v-model="newDepartment.phone"
          required
          :invalid="newDepartment.phone_touched && newDepartment.phone.length === 0"
          @touch="newDepartment.phone_touched = true"
          />

          <ui-textbox
          type="email"
          floating-label
          error="This field is required"
          label="Primary Contact Email"
          placeholder="email"
          v-model="newDepartment.email"
          required
          :invalid="newDepartment.email_touched && newDepartment.email.length === 0"
          @touch="newDepartment.email_touched = true"
          />

          <ui-select
          has-search
          floating-label
          label="Parent Department"
          placeholder="if this has a parent department"
          :options="optionsParentDepartment"
          v-model="newDepartment.parent_department_id"
          ></ui-select>

          <ui-button buttonType="submit" type="primary" color="primary" size="small">Add Department</ui-button>

        </form>

      </ui-collapsible>
    </aside>

    <div class="col-md-9 col-xs-12">

      <div class="col-sm-12">

        <div class="form-group">
          <div class="btn-group">

            <input v-model="search" class="form-control" type="text">
            <span id="searchclear"  @click="search = ''" class="glyphicon glyphicon-remove-circle"></span>

          </div>
        </div>


        <table class="table table-striped" style="border-collapse:collapse;">
          <thead>
            <tr>
              <th></th>
              <th>Name</th>
              <th>Primary Contact</th>
              <th>Phone</th>
              <th>Email</th>
            </tr>
          </thead>
          <tbody>

            <template v-for="(department, departmentKey) in results">
              <tr>
                <td data-toggle="collapse" :data-target="'#row'+departmentKey" class="accordion-toggle" aria-expanded="false">
                  <i class="fa fa-chevron-right fa-fw"></i>
                  <i class="fa fa-chevron-down fa-fw"></i>
                </td>
                <td><span class="editable">{{department.name}}</span></td>
                <td><span class="editable">{{department.primary_contact_name}}</span></td>
                <td><span class="editable">{{department.phone}}</span></td>
                <td><span class="editable">{{department.email}}</span></td>
              </tr>

              <tr>
                <td colspan="6" style="padding: 0">
                  <div class="container-fluid">

                    <div class="accordian-body collapse" :id="'row'+departmentKey" style="margin:20px 60px 50px">

                      <ui-collapsible title="Add Org Code" @close="resetNewDepartment()">

                        <form @submit.prevent="onSubmitOrgcode">

                          <input name="department_id" type="hidden" :value="department.id">


                          <ui-textbox
                          floating-label
                          error="This field is required"
                          label="Name"
                          placeholder="name"
                          v-model="newOrgcode.name"
                          required
                          :invalid="newOrgcode.name_touched && newOrgcode.name.length === 0"
                          @touch="newOrgcode.name_touched = true"
                          />

                          <ui-textbox
                          type="number"
                          floating-label
                          error="This field is required"
                          label="Code"
                          placeholder="Code"
                          v-model="newOrgcode.code"
                          required
                          :invalid="newOrgcode.code_touched && newOrgcode.code.length === 0"
                          @touch="newOrgcode.code_touched = true"
                          />

                          <ui-button buttonType="submit" type="primary" color="primary" size="small">Add Org Code</ui-button>


                        </form>
                      </ui-collapsible>

                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <!-- <th>#</th> -->
                            <th>Name</th>
                            <th>Code</th>
                            <th>Primary</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="org in department.org">
                            <!-- <td scope="row">{{org.id}}</td> -->
                            <td>{{org.name}}</td>
                            <td>{{org.code}}</td>
                            <td>
                              <input type="radio" 
                              :name="'primary_orgcode_id'+department.id" 
                              :value="org.id" 
                              @change="onPrimaryOrgChange(department,org)" 
                              :checked="org.id == department.primary_orgcode_id">
                              
                              </td>
                            <td><i class="fa fa-trash" @click="onDeleteOrg(org)"></i></td>
                          </tr>

                        </tbody>
                      </table>

                    </div>

                  </div>
                </td>
              </tr>
            </template>

          </tbody>
        </table>

      </div>
    </div>
  </div>
</template>

<script>
  import Fuse from 'fuse.js';
  import _ from 'lodash';
  import toastr from 'toastr';
  import confirm from 'jquery-confirm';



  class Errors {
    constructor(){
      this.errors = {};

      get = function(field) {
        if (this.errors[field]) {
          this.errors[field][0]
        }
      }
    }
  }


  export default
  {
   data: function() {
    return {

      currentItem: {},

      toggleCheckboxes: false,

      departments: [],

      newDepartment:{

        name:"",
        primary_contact_name:"",
        phone:"",
        email:"",
        parent_department_id: "",

        name_touched: false,
        primary_contact_name_touched:false,
        phone_touched:false,
        email_touched:false,
      },

      newOrgcode:{

        name:"",
        department_id:"",
        code:"",

        name_touched: false,
        department_id_touched:false,
        code_touched:false
      },

      //Add Department


      search: '',
      fuse: null,
      results: [],


    }
  },
  methods: {


    onSubmitDepartment: function () {
      var vm = this
      // var oldPDId = this.newDepartment.parent_department_id

      this.newDepartment.parent_department_id = this.newDepartment.parent_department_id.value

      console.log(this.newDepartment);
      axios.post('/api/v1/departments', this.newDepartment)
      .then(function(response){
        vm.resetNewDepartment();
        toastr["success"]("Saved Department")

        vm.departments.push(response.data)

      })
      .catch(error => this.errors = error.response.data)
    },
    onSubmitOrgcode: function (e) {
      var vm = this

      this.newOrgcode.department_id = $(e.currentTarget).find("[name=department_id]").val()
      console.log(e, this.newOrgcode);

      axios.post('/api/v1/org', this.newOrgcode)
      .then(function(response){
        vm.resetNewDepartment();
        toastr["success"]("Saved Org code")
        console.log(response.data, vm.departments)
        var department_index = _.findIndex(vm.departments, function(department) { return department.id == response.data.department_id; });
        vm.departments[department_index].org.push(response.data)


      })
      .catch(error => this.errors = error.response.data)
    },
    onDeleteOrg: function (org) {
      var vm = this

      org._method = "DELETE"


      $.confirm({
        title: 'Delete: ' + org.name,
        content: 'Ok... if your absolutely positive',
        icon: 'fa fa-warning',
        animation: 'zoom',
        closeAnimation: 'zoom',
        buttons: {
          confirm: {
            text: 'DELETE!',
            btnClass: 'btn-red',
            action: function () {

              axios.post('/api/v1/org/'+org.id, org)
              .then(function(response){


                var department_index = _.findIndex(vm.departments, function(department) { return department.id == response.data.department_id; });
                var org_index = _.findIndex(vm.departments[department_index].org, function(org) { return org.id == response.data.id; });
                vm.departments[department_index].org.splice(org_index, 1)

                toastr["success"]("Deleted Org code")
                vm.resetNewOrg()
              })
              .catch(error => this.errors = error.response.data)

            }
          },
          close:{
            text: "Close"
          }
        }
      });
    },
    onPrimaryOrgChange: function (department,org,e) {
      console.log(e,department,org);

      axios.post('/api/v1/departments/'+department.id, {"_method":"PATCH",primary_orgcode_id: org.id})
      .then(function(response){


        // var department_index = _.findIndex(vm.departments, function(department) { return department.id == response.data.department_id; });
        // var org_index = _.findIndex(vm.departments[department_index].org, function(org) { return org.id == response.data.id; });
        // vm.departments[department_index].org.splice(org_index, 1)

        toastr["success"]("Updated Primary Org code")
        // vm.resetNewOrg()
      })
      .catch(error => this.errors = error.response.data)


    },
    resetNewDepartment: function(){

      this.newDepartment = {
        name:"",
        primary_orgcode_id:"",
        primary_contact_name:"",
        phone:"",
        email:"",
        parent_department_id: "",

        name_touched: false,
        primary_contact_name_touched:false,
        phone_touched:false,
        email_touched:false,
      }

    },
    resetNewOrg: function(){

      this.newOrgcode ={
        name:"",
        department_id:"",
        code:"",
        name_touched: false,
        department_id_touched:false,
        code_touched:false
      }
    }

  },
  watch: {
    search: function () {
      if (this.search.trim() === '') {
        this.results = this.departments
      }
      else {
        this.results = this.fuse.search(this.search.trim())
      }
    }

  },
  computed:{
    optionsParentDepartment: function(){
      var options = _.map(this.departments,
        function(obj){return {
          'value': obj.id, 'label':obj.name
        }
      })
      options.unshift({
        'value': null, 'label':'No Parent'
      });
      return options;
    }
  },
  mounted()
  {
    var vm = this

    axios.get('/api/v1/departments?with=org')
    .then(function (response) {
      vm.departments = response.data;
      toastr["success"]("Loaded departments")


      vm.fuse = new Fuse(response.data, {
        caseSensitive: false,
        tokenize: true,
        threshold: 0.6,
        location: 0,
        distance: 900,
        maxPatternLength: 32,
        minMatchCharLength: 1,
        keys: [
        "name",
        "email",
        "org.code"
        ]
      });

      vm.results = vm.departments

    })
    .catch(vm.handleError);


    toastr.options = {
      "closeButton": true,
      "debug": false,
      "newestOnTop": true,
      "progressBar": true,
      "positionClass": "toast-bottom-right",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "2000",
      "timeOut": "5000",
      "extendedTimeOut": "10000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    }

            // $('body').on('click', '.editable', function(){
            //     $('.editable').jinplace();
            // });

          }
        }

      </script>

      <style>

      </style>
