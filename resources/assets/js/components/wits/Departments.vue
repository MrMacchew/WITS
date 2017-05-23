<template>

  <div id="department-vue" class="container-fluid">
    <aside class="col-md-3 col-xs-12">
      <div id="selectDropdowns">

        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Divisions</h3>
          </div>
          <select v-model="selectedDivision" class="form-control" :size="setSelectSizeDivision()" ref="selectItem">
            <option value="" style="color:#c3c3c3">Select/Add a divisions</option>
            <option v-for="division in divisions" :value="division">{{division.name}}</option>
          </select>
        </div>

        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Departments</h3>
          </div>
          <select v-model="selectedDepartment" class="form-control" :size="setSelectSizeDepartment()" ref="selectItem">
            <option value="" style="color:#c3c3c3">Select/Add a departments</option>
            <option v-for="department in departments" :value="department">{{department.name}}</option>
          </select>
        </div>

        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Teams</h3>
          </div>
          <select v-model="selectedTeam" class="form-control" :size="setSelectSizeTeam()" ref="selectItem">
            <option value="" style="color:#c3c3c3">Select/Add a teams</option>
            <option v-for="team in teams" :value="team">{{team.name}}</option>
          </select>
        </div>

      </div>
    </aside>
    <div class="col-xs-12 col-md-9">

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

          <template v-for="(division, divisionKey) in divisions">
            <tr>
              <td data-toggle="collapse" :data-target="'#row'+divisionKey" class="accordion-toggle" aria-expanded="false">
                <i class="fa fa-chevron-right fa-fw"></i>
                <i class="fa fa-chevron-down fa-fw"></i>
              </td>
              <td>{{division.name}}</td>
              <td>{{division.primary_contact}}</td>
              <td>{{division.phone}}</td>
              <td>{{division.email}}</td>
            </tr>

            <tr>
              <td colspan="6" style="padding: 0">
                <div class="container-fluid">


                  <div class="accordian-body collapse" :id="'row'+divisionKey" style="margin:20px 60px 50px" >

                    <div class="row">
                       org code
                    </div>

                  </div>

                </div>
              </td>
            </tr>
          </template>

        </tbody>
      </table>





    </div>
  </div>
</template>

<script>
  import toastr from 'toastr';


  export default{
    data: function(){
      return {

        currentItem:{},

        selectedDivision: "",
        selectedDepartment: "",
        selectedTeam: "",

        divisions:[],
        departments:[],
        teams:[],


        results:[],

      }
    },
    methods: {
      setSelectSizeDivision: function(e){
        if (this.currentItem.type == 'department') {
          return 1
        }
        if (this.currentItem.type == 'division') {
          return 1
        }
        if (this.currentItem.type == null) {
          return 3
        }
      },
      setSelectSizeDepartment: function(e){
        if (this.currentItem.type == 'team') {
          return 1
        }
        if (this.currentItem.type == 'department') {
          return 1

        }
        if (this.currentItem.type == 'division') {
          return 10

        }
      },
      setSelectSizeTeam: function(e){
        if (this.currentItem.type == 'team') {
          return 10
        }
        if (this.currentItem.type == 'department') {
          return 10

        }
      },
    },
    mounted: function(){
      var vm = this

      axios.get('/api/v1/departments?with=org,divisions,departments,teams')
      .then(function (response) {
        vm.divisions = response.data;
        toastr["success"]("Loaded Divisions")
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

    },
  }


</script>
