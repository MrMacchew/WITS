<template>
  <div id="department-vue" class="container-fluid">
    <aside class="col-md-3 col-xs-12">
      <ui-collapsible title="Add Department" open>


        <form @submit.prevent="onSubmitDepartment">

          <ui-textbox
          floating-label
          label="Department Name"
          v-model="formDepartment.name"
          :error="formDepartment.errors.get('name')"
          :invalid="!!formDepartment.errors.get('name')"
          @keydown="formDepartment.errors.clear('name')"

          />

          <ui-textbox
          floating-label
          label="Primary Contact Name"
          v-model="formDepartment.primary_contact_name"
          :error="formDepartment.errors.get('primary_contact_name')"
          :invalid="!!formDepartment.errors.get('primary_contact_name')"
          @keydown="formDepartment.errors.clear('primary_contact_name')"
          />

          <ui-textbox
          type="number"
          floating-label
          label="Phone"
          v-model="formDepartment.phone"
          :help="phoneHelp"
          :error="formDepartment.errors.get('phone')"
          :invalid="!!formDepartment.errors.get('phone')"
          @keydown="formDepartment.errors.clear('phone')"
          />

          <ui-textbox
          type="text"
          floating-label
          label="Primary Contact Email"
          v-model="formDepartment.email"
          :error="formDepartment.errors.get('email')"
          :invalid="!!formDepartment.errors.get('email')"
          @keydown="formDepartment.errors.clear('email')"

          />

          <ui-select
          has-search
          floating-label
          label="Parent Department"
          :options="departments"
          :keys="{label: 'name', value:'id'}"
          v-model="formDepartment.parent_department_id"
          :error="formDepartment.errors.get('parent_department_id')"
          :invalid="!!formDepartment.errors.get('parent_department_id')"
          @keydown="formDepartment.errors.clear('parent_department_id')"

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
              <th>Parent Department</th>
              <th></th>
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
                <td><span class="editable" v-if="department.parent" >{{department.parent.name}}</span> </td>
                <td> <i class="fa fa-trash" @click="onDeleteDepartment(department)"></i> </span></td>
              </tr>

              <tr>
                <td colspan="7" style="padding: 0">
                  <div class="container-fluid">

                    <div class="accordian-body collapse" :id="'row'+departmentKey" style="margin:20px 60px 50px">

                      <ui-collapsible title="Add Org Code">

                        <form @submit.prevent="onSubmitOrgcode">

                          <input name="department_id" type="hidden" :value="department.id">


                          <ui-textbox
                          floating-label
                          label="Name"
                          v-model="formOrg.name"
                          :error="formOrg.errors.get('name')"
                          :invalid="!!formOrg.errors.get('name')"
                          @keydown="formOrg.errors.get('name')"
                          />

                          <ui-textbox
                          type="number"
                          floating-label
                          label="Code"
                          v-model="formOrg.code"
                          :error="formOrg.errors.get('code')"
                          :invalid="!!formOrg.errors.get('code')"
                          @keydown="formOrg.errors.get('code')"
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
  import confirm from 'jquery-confirm';
  import Form from '../../utils/Form';





  export default
  {
   data: function() {
    return {

      departments: [],

      formDepartment: new Form({
        name:"",
        primary_contact_name:"",
        phone:"",
        email:"",
        parent_department_id: "",
      }),

      formOrg: new Form({
        name:"",
        department_id:"",
        code:"",
      }),

      search: '',
      fuse: null,
      results: [],

    }
  },
  methods: {
    onSubmitDepartment: function (e) {
      var vm = this
        console.log('onSubmitDepartment', this, e)

      this.formDepartment.beforeSubmit(function(form){
        console.log(form)
        if (form.get('parent_department_id')) {
          form.set('parent_department_id', form.get('parent_department_id').id)
        }

      })
      .post('/api/v1/departments')
      .then(function(response){
        vm.departments.push(response)
        toastr["success"]("Saved Department")
      })
      .catch(errors => console.log(this.formDepartment.errors.errors))
    },

    onSubmitOrgcode: function(e){
      var vm = this
      this.formOrg
      .beforeSubmit(form =>{form.set('department_id', $(e.currentTarget).find("[name=department_id]").val())})
      .post('/api/v1/org')
      .then(function(response){
        var department_index = _.findIndex(vm.departments, function(department) { return department.id == response.department_id; });
        vm.departments[department_index].org.push(response)
        toastr["success"]("Saved Org code")
      })
      .catch(errors => console.log(this.formOrg.errors.errors))
    },

    onSuccessDepartment: function(){},

    onDeleteOrg: function (org) {
      var vm = this
      this.form
      // org._method = "DELETE"

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

              vm.formOrg.beforeSubmit(form => {
                form._method = "DELETE"
              })
              .delete('/api/v1/org/'+org.id)
              .then(response => {
                var department_index = _.findIndex(vm.departments, function(department) { return department.id == response.department_id; });
                var org_index = _.findIndex(vm.departments[department_index].org, function(org) { return org.id == response.id; });
                vm.departments[department_index].org.splice(org_index, 1)
              })
              .catch(error => console.log(vm.formOrg.errors.errors))
            }
          },
          close:{
            text: "Close"
          }
        }
      });
    },

    onDeleteDepartment: function (department) {
      var vm = this

      $.confirm({
        title: 'Delete: ' + department.name,
        content: 'Ok... if your absolutely positive',
        icon: 'fa fa-warning',
        animation: 'zoom',
        closeAnimation: 'zoom',
        buttons: {
          confirm: {
            text: 'DELETE!',
            btnClass: 'btn-red',
            action: function () {


              vm.formDepartment.beforeSubmit(form => {
                form._method = "DELETE"
                form.id = department.id
              })
              .delete('/api/v1/departments/'+vm.formDepartment.id)
              .then(response => {
                var department_index = _.findIndex(vm.departments, function(department) { return department.id == response.id; })
                vm.departments.splice(department_index,1)

                toastr["success"]("Deleted Department")
              })
              .catch(error => console.log(vm.formOrg.errors.errors))
            }
          },
          close:{
            text: "Close"
          }
        }
      });
    },

    onPrimaryOrgChange: function (department,org,e) {
      console.log(e,department,org, e);

      axios.post('/api/v1/departments/'+department.id, {"_method":"PATCH",primary_orgcode_id: org.id})
      .then(function(response){
        toastr["success"]("Updated Primary Org code")
      })
      .catch(error => this.errors = error.response.data)
    },

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
    phoneHelp: function(){
      if ((10 - this.formDepartment.phone.length) !== 0) {
        return '10 digit phone number: ' + (10 - this.formDepartment.phone.length) + ' left'
      }
      return '10 digit phone number'
    }

  },

  mounted(){
    var vm = this

    axios.get('/api/v1/departments?with=org,parent')
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
        keys: [{
          name: 'name',
          weight: .7
        },
        {
          name: 'email',
          weight: 0.1
        },
        {
          name: 'org.code',
          weight: 0.1
        },
        {
          name: 'parent.name',
          weight: 0.1
        }]





      });

      vm.results = vm.departments

    })
    .catch(vm.handleError);

  }
}

</script>

<style>

</style>
