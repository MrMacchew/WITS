<template>
  <div id="location-vue" class="container-fluid">
    <aside class="col-md-3 col-xs-12">
      <div id="selectDropdowns">

        <div class="panel panel-default">
          <div class="panel-heading">
          <h3 class="panel-title">Campuses</h3>
          </div>
          <select v-model="selectedCampus" class="form-control" :size="setSelectSizeCampus()" ref="selectItem">
            <option value="" style="color:#c3c3c3">Select/Add a Campus</option>
            <option v-for="campus in campuses" :value="campus">{{campus.name}}</option>
          </select>
        </div>

        <!-- add campuse -->
        <div class="panel panel-default" v-if="selectedCampus==''">
          <div class="panel-body">
            <form class="form-horizontal" v-on:submit.prevent="onSubmitCampus">
              <h4>Add Campus</h4>
              <div class="form-group">
                <label for="addCampus" class="col-sm-2 control-label">Name</label>
                <div class="col-sm-10">
                  <input type="text" v-model="newCampus.name" id="addCampus">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">Code</label>
                <div class="col-sm-10">
                  <input type="number" v-model="newCampus.campus_code">
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit"  class="btn btn-default">Add Campus</button>
                </div>
              </div>
            </form>
          </div>
        </div>

        <div class="panel panel-default" v-if="selectedCampus" >
          <div class="panel-heading">
            <h3 class="panel-title">Buildings</h3>
          </div>
          <select v-model="selectedBuilding" class="form-control" :size="setSelectSizeBuilding()" ref="selectItem">
            <option value="" style="color:#c3c3c3">Select/Add a Building</option>
            <option v-for="building in selectedCampus.buildings" :value="building"> {{building.name}}</option>
          </select>
        </div>


        <!-- add building -->
        <div class="panel panel-default" v-if="selectedCampus && selectedBuilding==''">
          <div class="panel-body">
            <form class="form-horizontal" v-on:submit.prevent="onSubmitBuilding">
              <h4>Add Building <span>to {{currentItem.name}}</span></h4>

              <div class="form-group">
                <label for="building_name" class="col-sm-2 control-label">Name</label>
                <div class="col-sm-10">
                  <input type="text" v-model="newBuilding.name" id="addBuilding">
                </div>
              </div>

              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit"  class="btn btn-default">Add Building</button>
                </div>
              </div>
            </form>
          </div>
        </div>

        <div class="panel panel-default" v-if="selectedBuilding && selectedCampus">
          <div class="panel-heading">
            <h3 class="panel-title">Rooms</h3>
          </div>
          <select v-model="selectedRoom" class="form-control" :size="setSelectSizeRoom()">
            <option value="" style="color:#c3c3c3">Select/Add a Room</option>
            <option v-for="room in selectedBuilding.rooms" :value="room">{{room.number || room.name}}</option>
          </select>
        </div>

        <!-- add room -->
        <div class="panel panel-default" v-if="selectedCampus && selectedBuilding && selectedCampus && selectedRoom==''">
          <div class="panel-body">
            <form class="form-horizontal" v-on:submit.prevent="onSubmitRoom">
              <h4>Add Room <span>to {{currentItem.name}}</span></h4>

              <div class="form-group">
                <label for="room_name" class="col-sm-3 control-label">Name</label>
                <div class="col-sm-9">
                  <input type="text" v-model="newRoom.name">
                </div>
              </div>

              <div class="form-group">
                <label for="room_name" class="col-sm-3 control-label">Number</label>
                <div class="col-sm-9">
                  <input type="text" v-model="newRoom.number">
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label">Room Style</label>
                <div class="col-sm-9">
                  <select v-model='roomStyle' class="form-control">
                    <option v-for="roomstyle in roomStyles" :value="roomstyle.id">{{roomstyle.name}}</option>
                  </select>
                </div>
              </div>


              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit"
                  class="btn btn-default">Add Room</button>
                </div>
              </div>
            </form>
          </div>
        </div>

      </div>
    </aside>

    <div class="col-xs-12 col-md-9">




  <div id="current-item">
     <h2>
      <span class="text-capitalize">{{currentItem.type || "Select a Campus"}}:</span> {{currentItem.number || currentItem.name}}
    </h2>

     <template>
        <gmap-map ref="map"
        :center="center"
        :zoom="currentItem.zoom || 15"
    map-type-id="terrain"
        @rightclick="mapRclicked"
        style="width: 100%; height: 300px"
        >
          <gmap-marker v-for="(m, index) in markers"
          :position="m.position"
          :clickable="true"
          :draggable="true"
          @click="center=m.position"@dragend="mapDragend"></gmap-marker>
        </gmap-map>
      </template>



      <div id="current-item-tabs" style="margin:20px 0">

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">

          <li role="presentation" > <a href="#home" aria-controls="home" role="tab" data-toggle="tab" class="text-capitalize">{{currentItem.type}}</a> </li>

          <li role="presentation" v-show="currentItem.type == 'room'"> <a href="#inventory" aria-controls="inventory" role="tab" data-toggle="tab" class="text-capitalize">inventory</a> </li>

          <li role="presentation" v-show="currentItem.type == 'room'"> <a href="#software" aria-controls="software" role="tab" data-toggle="tab" class="text-capitalize">software <i id="software-btn" class="fa fa-plus fa-fw"
            data-toggle="collapse" data-target="#addSoftware"
            aria-expanded="false" aria-controls="addSoftware"
            /></a> </li>

          <li role="presentation" v-show="currentItem.type == 'room'"> <a href="#department" aria-controls="department" role="tab" data-toggle="tab" class="text-capitalize">department</a> </li>

          <li role="presentation" v-show="currentItem.type == 'room'"> <a href="#media" aria-controls="media" role="tab" data-toggle="tab" class="text-capitalize">media</a> </li>

          <li role="presentation" v-show="currentItem.type == 'room'"> <a href="#something" aria-controls="something" role="tab" data-toggle="tab" cl="text-transform: capitalize">Something</a> </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">

          <!-- HOME -->
          <div role="tabpanel" class="tab-pane active" id="home">
            <form v-if="currentItem.type == 'campus'" v-on:submit.prevent="onUpdateCampus">

              <div class="pull-right">
                <i class="fa fa-trash fa-2x" @click="onDeleteCampus"></i>
              </div>

              <!-- HOME -->
              <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" v-model="currentItem.name">
              </div>

              <div class="form-group">
                <label>Code</label>
                <input type="text" class="form-control" v-model="currentItem.campus_code">
              </div>
              <button type="submit" class="btn btn-default">Update Campus</button>
            </form>

            <form v-if="currentItem.type == 'building'" v-on:submit.prevent="onUpdateBuilding">
              <div class="pull-right">
                <i class="fa fa-trash fa-2x" @click="onDeleteBuilding"></i>
              </div>

              <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" v-model="currentItem.name">
              </div>
              <button type="submit" class="btn btn-default">Update Building</button>
            </form>

            <form v-if="currentItem.type == 'room'" v-on:submit.prevent="onUpdateRoom" >

              <div class="pull-right">
                <i class="fa fa-trash fa-2x" @click="onDeleteRoom"></i>
              </div>

              <div class="form-group">
                <label>Number</label>
                <input type="text" class="form-control" v-model="currentItem.number">
              </div>

              <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" v-model="currentItem.name">
              </div>

              <div class="form-group">
                <label>Room Style</label>
                <select v-model='currentItem.style_id' class="form-control">
                  <option v-for="roomstyle in roomStyles"
                  :value="roomstyle.id"
                  :selected="roomstyle.id == currentItem.style_id ">{{roomstyle.name}}</option>
                </select>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label">Capacity</label>
                <div class="col-sm-9">
                  <input type="number" v-model="currentItem.capacity">
                </div>
              </div>

              <div class="form-group">
                <button type="submit" class="btn btn-default">Update Room</button>
              </div>

            </form>
          </div>

          <div role="tabpanel" class="tab-pane" id="software">




            <div class="collapse" id="addSoftware">
              <div class="well">
                <form class="form-horizontal" v-on:submit.prevent="onAddSoftware">
                  <h4>Add Software to <span>{{currentItem.name || currentItem.number}}</span></h4>

                  <div class="form-group">
                    <label class="col-sm-1 control-label text-capitalize">Title</label>
                    <div class="col-sm-11">
                      <input type="text" v-model="newSoftware.title">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-1 control-label text-capitalize">filename</label>
                    <div class="col-sm-11">
                      <input type="text" v-model="newSoftware.filename">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-1 control-label text-capitalize">url</label>
                    <div class="col-sm-11">
                      <input type="text" v-model="newSoftware.url">
                    </div>
                  </div>




                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit"  class="btn btn-default">Add Software</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <table class="table table-striped" style="border-collapse:collapse;">
              <thead>
                <tr>
                  <th></th>
                  <th>title</th>
                  <th>filename</th>
                  <th>url</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>



                <template v-for="roomsoftware in currentItem.software">
                  <tr>
                    <td></td>
                    <td><a :href="roomsoftware.url">{{roomsoftware.title}}</a></td>
                    <td>{{roomsoftware.filename}}</td>
                    <td>{{roomsoftware.url}}</td>
                    <td><i class="fa fa-times fa-fw" @click="onDeleteSoftware(roomsoftware)"></i></td>
                  </tr>
                </template>



              </tbody>
            </table>


          </div>

           <div role="tabpanel" class="tab-pane" id="inventory">
            inventory
          </div>

          <div role="tabpanel" class="tab-pane" id="department">

            <form class="form-horizontal" v-on:submit.prevent="onAddSoftware">
              <!-- <h4>Add Departments to <span>{{currentItem.name || currentItem.number}}</span></h4> -->
          <div>
              <label class="typo__label">Single select / dropdown</label>

              <multiselect
              v-model="currentItem.departments"
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


          </div>





            </form>






          </div>

          <div role="tabpanel" class="tab-pane" id="media">
            media
          </div>

          <div role="tabpanel" class="tab-pane" id="something">
            something
          </div>
        </div>

      </div>








  </div>

</div>

</div>
</template>
<script>

  import Fuse from 'fuse.js';
  import * as VueGoogleMaps from 'vue2-google-maps';
  import Vue from 'vue';
  import toastr from 'toastr';
  import confirm from 'jquery-confirm';
  import _ from 'lodash';


  Vue.use(VueGoogleMaps, {
    load: {
      key: 'AIzaSyBaB3pP8S65JEZ9gvA5XxYn5urVMgpoxuU',
      v: '3.27',
    }
  });

  export default{
    data: function(){
      return {
        search: '',

        showAddCampus: false,
        showAddBuilding: false,
        showAddRoom: false,


        selectedCampus: "",
        selectedBuilding: "",
        selectedRoom: "",

        campuses: [],


        currentCampus: {},
        currentBuilding: {},
        currentRoom: {},

        departments:[],
        selectedDepartment: {},

        roomStyles: [],
        roomStyle: '',


        newCampus: {
          name:'',
          campus_code:'',
          latlong: ''
        },
        newBuilding: {
          name:'',
          campus_id:'',
        },
        newRoom: {
          name:'',
          number:'',
          style_id:'',
          building_id:'',
          capacity: ''
        },
        center: {lat: 41.192638470302114, lng: -111.9427574918045}, //{lat: 41.192638470302114, lng: -111.9427574918045}

        markers: [], //[{position: JSON.parse(currentItem.latlong)}],

        infoContent: '',

        toggleAddSoftware: false,

        newSoftware: {
          title: '',
          filename: '',
          url: '',
        }
      }
    },

    methods:{

      departmentLabel:function(item){
        return `${item.name} – ${item.id}`
      },

      setSelectSizeCampus: function(e){
        if (this.currentItem.type == 'building') {
          return 1
        }
        if (this.currentItem.type == 'campus') {
          return 1
        }
        if (this.currentItem.type == null) {
          return 10
        }
      },

      setSelectSizeBuilding: function(e){

        if (this.currentItem.type == 'room') {
          return 1
        }
        if (this.currentItem.type == 'building') {
          return 1

        }
        if (this.currentItem.type == 'campus') {
          return 10
        }
      },

      setSelectSizeRoom: function(e){

        if (this.currentItem.type == 'room') {
          return 10
        }
        if (this.currentItem.type == 'building') {
          return 10

        }
        // if (this.currentItem.type == 'campus') {
        //   return 1

        // }
      },

      onSubmitCampus: function(e){
        var vm = this;
        this.newCampus.latlong = "{}"
        // this.newCampus.buildings = []
        if (this.newCampus.name == "") {
          toastr["warning"]("Need Name of campus")
          return
        }
        if (this.newCampus.campus_code == "") {
          toastr["warning"]("Need Code of campus")
          return
        }

        axios.post('/api/v1/campus', this.newCampus)
        .then(function (response) {
          console.log(response);
          vm.campuses.push(response.data);

          toastr["success"]("Added Campus: " + response.data.name)
          toastr["info"]("Place a marker for " + response.data.name)


          vm.newCampus = {
            name:'',
            campus_code:''
          }
        })
        .catch(vm.handleError);
      },

      onSubmitBuilding: function(e){
        var vm = this;
        this.newBuilding.campus_id = this.currentItem.campus_id
        this.newBuilding.latlong = "{}"

        if (this.newBuilding.name == "") {
          toastr["warning"]("Need Name of Building")
          return
        }


        axios.post('/api/v1/buildings', this.newBuilding)
        .then(function (response) {
          vm.campuses[vm.currentItem.index.campus]
          .buildings.push(response.data)

          toastr["success"]("Added building: " + response.data.name)
          toastr["info"]("Place a marker for " + response.data.name)

        })
        .catch(vm.handleError);

        this.newBuilding = {
          name:'',
          campus_id:''
        }
      },

      onSubmitRoom: function(e){
        var vm = this;

        this.newRoom.building_id = this.currentItem.id
        this.newRoom.style_id = this.roomStyle
        this.newRoom.latlong = "{}"

        if (this.newRoom.name == "" && this.newRoom.number == "") {
          toastr["warning"]("Need Name or Number of room")
          return
        }
        if (!this.roomStyle) {
          toastr["warning"]("Need Style of room")
          return
        }

        axios.post('/api/v1/rooms', this.newRoom)
        .then(function (response) {
            try {
              vm.campuses[vm.currentItem.index.campus]
              .buildings[vm.currentItem.index.building]
              .rooms.push(response.data)
            }
            catch (e) {
            // statements to handle any exceptions
            console.log(e); // pass exception object to error handler
            }


            toastr["success"]("Added Room: " + response.data.name)
            toastr["info"]("Place a marker for " + response.data.name)

        })
        .catch(vm.handleError);

        this.newRoom = {
          name:'',
          number:'',
          style_id:'',
          building_id:'',
          capacity: ''
        }
      },

      onUpdateCampus: function(e){
        var vm = this;
        this.newCampus._method = 'PATCH'
        this.newCampus.name = this.currentItem.name
        this.newCampus.campus_code = this.currentItem.campus_code

        console.log(this.newCampus);

        axios.post('/api/v1/campus/'+ this.currentItem.id, this.newCampus)
        .then(function (response) {
          toastr["success"]("Updated Campus: " + response.data.name)


        })
        .catch(vm.handleError)

        this.newCampus = {
          name:'',
          campus_code:''
        }
      },

      onUpdateBuilding: function(e){
        var vm = this;
        this.newBuilding = this.currentItem
        this.newBuilding._method = 'PATCH'

        axios.post('/api/v1/buildings/'+ this.currentItem.id, this.newBuilding)
        .then(function (response) {
            toastr["success"]("Updated Building: " + response.data.name)
        })
        .catch(vm.handleError);
      },

      onUpdateRoom: function(e){
        var vm = this;

        this.newRoom = this.currentItem
        this.newRoom._method = 'PATCH'


        console.log(this.newRoom);
        axios.post('/api/v1/rooms/'+ this.currentItem.id, this.newRoom)
        .then(function (response) {
          toastr["success"]("Updated Room: " + (response.data.name || response.data.number ))
        })
        .catch(vm.handleError);

      },
      onDeleteCampus: function(e){
        var vm = this;
        this.newCampus._method = 'DELETE'
        this.newCampus.name = this.currentItem.name
        this.newCampus.campus_code = this.currentItem.campus_code

        var data = this.newCampus

        $.confirm({
          title: 'Are you sure? You are about to delete a campus?',
          content: 'This is a very Unlikely Action',
          icon: 'fa fa-question-circle',
          animation: 'scale',
          closeAnimation: 'scale',
          opacity: 0.5,
          buttons: {
            'confirm': {
              text: 'Proceed',
              btnClass: 'btn-orange',
              action: function () {
                $.confirm({
                  title: 'Delete: ' + vm.currentItem.name,
                  content: 'Ok... if your absolutely positive',
                  icon: 'fa fa-warning',
                  animation: 'zoom',
                  closeAnimation: 'zoom',
                  buttons: {
                    confirm: {
                      text: 'DELETE!',
                      btnClass: 'btn-red',
                      action: function () {
                      console.log('sending data: ', data);
                       axios.post('/api/v1/campus/'+ vm.currentItem.id, data)
                       .then(function (response) {

                        console.log('delete', response.data)
                        toastr["success"]("Deleted Campus: " + response.data.name)

                        //buildings
                        vm.campuses[vm.currentItem.index.campus]
                        .buildings = []


                        //campus
                        vm.campuses.splice(vm.currentItem.index.campus, 1)


                        vm.currentItem = {type:null}
                        vm.$forceUpdate();

                        console.log(vm.currentItem)


                      })
                       .catch(vm.handleError)

                     }
                   },
                   close:{
                    text: "Close"
                   }
                 }
               });
              }
            },
            cancel: function () {
              // $.alert('you clicked on <strong>cancel</strong>');
            },
          }
        });


        this.newCampus = {
          name:'',
          campus_code:''
        }

      },

      onDeleteBuilding: function(e){
        var vm = this;
        this.newBuilding = this.currentItem
        this.newBuilding._method = 'DELETE'
        var data = this.newBuilding


        $.confirm({
          title: 'Are you sure? You are about to delete a building:'+ this.currentItem.name+'?',
          content: 'This is a very Unlikely Action',
          icon: 'fa fa-question-circle',
          animation: 'scale',
          closeAnimation: 'scale',
          opacity: 0.5,
          buttons: {
            'confirm': {
              text: 'Proceed',
              btnClass: 'btn-orange',
              action: function () {
                $.confirm({
                  title: 'Delete: ' + vm.currentItem.name,
                  content: 'Ok... if your absolutely positive',
                  icon: 'fa fa-warning',
                  animation: 'zoom',
                  closeAnimation: 'zoom',
                  buttons: {
                    confirm: {
                      text: 'DELETE!',
                      btnClass: 'btn-red',
                      action: function () {

                        console.log('sending data: ', data);
                        axios.post('/api/v1/buildings/'+ vm.currentItem.id, data)
                        .then(function (response) {
                          toastr["success"]("Delete Building: " + response.data.name)

                          //rooms
                          vm.campuses[vm.currentItem.index.campus]
                          .buildings[vm.currentItem.index.building]
                          .rooms = []

                          //buildings
                          vm.campuses[vm.currentItem.index.campus]
                          .buildings.splice(vm.currentItem.index.building, 1);



                          vm.currentItem = {type:null}
                          vm.$forceUpdate();
                          console.log(vm.currentItem)


                        })
                        .catch(vm.handleError);
                     }

                   },
                   close:{
                    text: "Close"
                   }
                 }
               });
              }
            },
            cancel: function () {
              // $.alert('you clicked on <strong>cancel</strong>');
            },
          }
        });
      },

      onDeleteRoom: function(e){
        var vm = this;
        this.newRoom = this.currentItem
        this.newRoom._method = 'DELETE'

        var data = this.newRoom

        $.confirm({
          title: 'Are you sure? You are about to delete a room?',
          // content: 'This is a very Unlikely Action',
          icon: 'fa fa-question-circle',
          animation: 'scale',
          closeAnimation: 'scale',
          opacity: 0.5,
          buttons: {
            'confirm': {
              text: 'Proceed',
              btnClass: 'btn-orange',
              action: function () {
                $.confirm({
                  title: 'Delete: ' + vm.currentItem.name,
                  content: 'Ok... if your absolutely positive',
                  icon: 'fa fa-warning',
                  animation: 'zoom',
                  closeAnimation: 'zoom',
                  buttons: {
                    confirm: {
                      text: 'DELETE!',
                      btnClass: 'btn-red',
                      action: function () {
                        console.log('sending data: ', data);
                        axios.post('/api/v1/rooms/'+ vm.currentItem.id, data)
                        .then(function (response) {
                          toastr["success"]("Deleted Room: " + response.data.name)

                          vm.campuses[vm.currentItem.index.campus]
                          .buildings[vm.currentItem.index.building]
                          .rooms.splice(vm.currentItem.index.room, 1)



                          vm.currentItem = {type:null}
                          vm.$forceUpdate();
                          console.log(vm.currentItem)


                        })
                        .catch(vm.handleError);
                     }
                   },
                   close:{
                    text: "Close"
                   }
                 }
               });
              }
            },
            cancel: function () {
              // $.alert('you clicked on <strong>cancel</strong>');
            },
          }
        });
      },

      handleError: function (error) {
        if (error.response) {
        // The request was made and the server responded with a status code
        // that falls out of the range of 2xx
        // console.log(error.response.data);
        console.log(error.response.status);
        console.log(error.response.headers);
        // toastr["error"](error.response.data)
        toastr["error"](error.response.status)
        toastr["error"](error.response.headers)

        } else if (error.request) {
        // The request was made but no response was received
        // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
        // http.ClientRequest in node.js
        console.log(error.request);
        toastr["error"](error.request)

        } else {
        // Something happened in setting up the request that triggered an Error
        console.log('Error', error.message);
        toastr["error"](error.message)

        }
        console.log(error);
      },

      mapClicked: function mapClicked(mouseArgs) {
        console.log('map clicked', mouseArgs);
      },

      mapRclicked: function mapRclicked(mouseArgs) {
        var vm = this
        var createdMarker = this.addMarker();

        createdMarker.position.lat = mouseArgs.latLng.lat();
        createdMarker.position.lng = mouseArgs.latLng.lng();

        if(vm.currentItem){
          vm.currentItem.latlong = JSON.stringify(createdMarker.position)

          var data = {
            _method: 'PATCH',
            latlong: this.currentItem.latlong
          }


          vm.setMarker(vm, data)
          vm.markers = [{position: createdMarker.position}];
        }
      },

      mapDragend: function mapDragend(mouseArgs) {
        var vm = this
        this.currentItem.latlong = JSON.stringify({"lat": mouseArgs.latLng.lat(), "lng":mouseArgs.latLng.lng()})

        var data = {
          _method: 'PATCH',
          latlong: vm.currentItem.latlong
        }

        vm.setMarker(vm, data)
      },

      setMarker: function(vm, data){
        switch(vm.currentItem.type){
          case "campus":
          axios.post('/api/v1/campus/'+vm.currentItem.id, data)
          .then(function (response) {
            toastr["success"]("Marker Placed")
          })
          .catch(vm.handleError);
          break;

          case "building":
          axios.post('/api/v1/buildings/'+vm.currentItem.id, data)
          .then(function (response) {
            toastr["success"]("Marker Placed")
          })
          .catch(vm.handleError);
          break;

          case "room":
          axios.post('/api/v1/rooms/'+vm.currentItem.id, data)
          .then(function (response) {
            toastr["success"]("Marker Placed")
          })
          .catch(vm.handleError);
          break;
        }
      },

      addMarker: function addMarker() {
        this.markers.push({
          // id: this.lastId,
          position: {
            lat: 48.8538302,
            lng: 2.2982161
          },
          opacity: 1,
          draggable: true,
          enabled: true,
          clicked: 0,
          rightClicked: 0,
          dragended: 0,
          ifw: true,
          // ifw2text: 'This text is bad please change me :( '
        });
        return this.markers[this.markers.length - 1];
      },

      onAddSoftware: function(e){
        var vm = this;

        this.newSoftware.room_id = this.currentItem.id

        if (this.newSoftware.title == "") {
          toastr["warning"]("Need Title of software")
          return
        }

        if (this.newSoftware.filename == "") {
          toastr["warning"]("Need filename of software")
          return
        }

        if (this.newSoftware.url == "") {
          toastr["warning"]("Need url of software")
          return
        }

        // this.newSoftware

        axios.post('/api/v1/software', this.newSoftware)
        .then(function (response) {
          console.log(response);

          vm.campuses[vm.currentItem.index.campus]
              .buildings[vm.currentItem.index.building]
              .rooms[vm.currentItem.index.room]
              .software.push(response.data)



          toastr["success"]("Added Software: " + response.data.title)

          vm.newSoftware = {
            title: '',
            filename: '',
            url: '',
          }
          $('#software-btn').trigger('click')
        })
        .catch(vm.handleError);
      },

      onSelectDepartment: function(e){

        console.log('onSelectDepartment', e, this.currentItem.departments);
        var vm = this;
        var data = this.currentItem.departments

        console.log(data)

        axios.post('/api/v1/rooms/'+ this.currentItem.id +'/sync/departments', data)
        .then(function (response) {
            console.clear();
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

      onDeleteSoftware: function (software) {
        var vm = this
        var data = software
        data._method = 'DELETE'
        console.log(data)


        $.confirm({
          title: 'Delete: ' + data.title,
          content: 'Ok... if your absolutely positive',
          icon: 'fa fa-warning',
          animation: 'zoom',
          closeAnimation: 'zoom',
          buttons: {
            confirm: {
              text: 'DELETE!',
              btnClass: 'btn-red',
              action: function () {
                axios.post('/api/v1/software/'+ data.id, data)
                .then(function (response) {
                  toastr["success"]("Deleted Software: " + response.data.title)


                  var rooms = vm.campuses[vm.currentItem.index.campus]
                  .buildings[vm.currentItem.index.building]
                  .rooms[vm.currentItem.index.room]

                  var software_index = _.findIndex(rooms.software, function(room) { return room.id == response.data.id; });

                  vm.campuses[vm.currentItem.index.campus]
                  .buildings[vm.currentItem.index.building]
                  .rooms[vm.currentItem.index.room]
                  .software.splice(software_index,1)

                })
                .catch(vm.handleError);
              }
            },
            close:{
              text: "Close"
            }
          }
        });
      }
    },

    watch:{
      selectedCampus: function(item){
        this.selectedBuilding = ""
        this.selectedRoom = ""

        if (item == "") {
          this.currentItem = {}
          return;
        }

        this.currentItem = item
        this.currentItem.type = 'campus'
      },

      selectedBuilding: function(item){
        this.selectedRoom = ""

        if (item == "") {
          this.currentItem = {}
          return;
        }

        this.currentItem = item
        this.currentItem.type = 'building'
      },

      selectedRoom: function(item){

        this.newRoom = {
            name:'',
            number:'',
            style_id:'',
            building_id:'',
            capacity: ''
          }

        if (item == "") {
          this.currentItem = {}
          return;
        }


        this.currentItem = item
        this.currentItem.type = 'room'

      },
      currentItem: function(item){

        if (item.type == null) {
          return
        }

        if (item.latlong !== "{}") {
          var latlong = JSON.parse(item.latlong)
          var hasLat = _.has(latlong, 'lat');
          var hasLng = _.has(latlong, 'lng');

          if (hasLat && hasLng) {
            this.markers = [{position: latlong}];
            this.center = latlong
          }
        }


      }
    },

    computed: {
      currentItem: function(){
        var vm = this
        this.markers = []

        if( _.isObject(this.selectedCampus) && _.isObject(this.selectedBuilding) && _.isObject(this.selectedRoom))
        {
          var currentItem = this.selectedRoom
          currentItem.type = 'room'
          currentItem.campus_id = this.selectedCampus.id
          currentItem.building_id = this.selectedBuilding.id
          //currentItem room id is currentItem.id

          currentItem.zoom = 20

          //--Position of item in room--//
          var i,j,k

          i = _.findIndex(this.campuses, function(campus) { return campus.id == vm.selectedCampus.id; });
          j = _.findIndex(this.campuses[i].buildings, function(building) { return building.id == vm.selectedBuilding.id; });
          k = _.findIndex(this.campuses[i].buildings[j].rooms, function(room) { return room.id == vm.selectedRoom.id; });
          // console.log(i,j,k)
          currentItem.index = {campus: i, building: j, room: k} //this.campuses[i].buildings[j].rooms[k]
          //----//

          return currentItem;
        }

        if( _.isObject(this.selectedCampus) && _.isObject(this.selectedBuilding) ){
          var currentItem = this.selectedBuilding
          currentItem.campus_id = this.selectedCampus.id

          currentItem.type = 'building'
          currentItem.zoom = 18
          //--Position of item in building--//
          var i,j,k

          i = _.findIndex(this.campuses, function(campus) { return campus.id == vm.selectedCampus.id; });
          j = _.findIndex(this.campuses[i].buildings, function(building) { return building.id == vm.selectedBuilding.id; });
          // console.log(i,j)
          currentItem.index = {campus: i, building: j, room: null}
          //----//
          return currentItem;
        }

        if(_.isObject(this.selectedCampus)){
          var currentItem = this.selectedCampus
          currentItem.campus_id = this.selectedCampus.id
          currentItem.type = 'campus'
          currentItem.zoom = 16

          //--Position of item in campus--//
          var i

          i = _.findIndex(this.campuses, function(campus) { return campus.id == vm.selectedCampus.id; });

          // console.log(i)
          currentItem.index = {campus: i, building: null, room: null}
          //----//

          return currentItem;
        }

        return {type:null, index: {campus: null, building: null, room: null}} }
    },

    filters: {
      capitalize: function (value) {
        if (!value) return ''
          value = value.toString()
        return value.charAt(0).toUpperCase() + value.slice(1)
      }
    },
    mounted() {
      var vm = this;


      var $with = [
      'buildings.rooms.software',
      'buildings.rooms.departments',
      ]
      axios.get('api/v1/campus?with='+ $with.join())
      .then(function (response) {
        vm.campuses = response.data;
        toastr["success"]("Loaded Locations")
      })
      .catch(vm.handleError);

      axios.get('/api/v1/roomstyle')
      .then(function (response) {
        vm.roomStyles = response.data;
      })
      .catch(vm.handleError);


      axios.get('/api/v1/departments?fields=id,name')
      .then(function(response){
        vm.departments = response.data
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
    }

  }
</script>

