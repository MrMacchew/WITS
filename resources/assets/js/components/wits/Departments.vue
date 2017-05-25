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
            v-model="newDepartment.primary_contact_email"
            required
            :invalid="newDepartment.primary_contact_email_touched && newDepartment.primary_contact_email.length === 0"
            @touch="newDepartment.primary_contact_email_touched = true"
            />




            <ui-select
            has-search
            floating-label
            label="Parent Department"
            placeholder="if this has a parent department"
            :options="optionsParentDepartment"
            v-model="newDepartment.parentDepartment"
            ></ui-select>

            <ui-button buttonType="submit" type="primary" color="primary" size="small">Add Department</ui-button>

            </form>





      </ui-collapsible>
    </aside>

    <div class="col-md-9 col-xs-12">


      <div id="addDepartment">

        <form class="form-horizontal">



        </form>

      </div>


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
                <td><span class="editable">{{department.primary_contact}}</span></td>
                <td><span class="editable">{{department.phone}}</span></td>
                <td><span class="editable">{{department.email}}</span></td>
              </tr>

              <tr>
                <td colspan="6" style="padding: 0">
                  <div class="container-fluid">

                    <div class="accordian-body collapse" :id="'row'+departmentKey" style="margin:20px 60px 50px">

                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Code</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="org in department.org">
                            <td scope="row">{{org.id}}</td>
                            <td>{{org.name}}</td>
                            <td>{{org.code}}</td>
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
        name_touched: false,
        primary_contact_name:"",
        primary_contact_name_touched:false,
        phone:"",
        phone_touched:false,
        primary_contact_email:"",
        primary_contact_email_touched:false,
        parentDepartment: "",
      },

      //Add Department


      search: '',
      fuse: null,
      results: [],


    }
  },
  methods: {
    onSubmitDepartment: function () {
       axios.post('/api/v1/departments', this.newDepartment)
       .then(response => response.data)
       .catch(error => this.errors = error.response.data)
    },
    resetNewDepartment: function(){

      this.newDepartment = {
        name:"",
        name_touched: false,
        primary_contact_name:"",
        primary_contact_name_touched:false,
        primary_contact_email:"",
        primary_contact_email_touched:false,
        parentDepartment: "",
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
