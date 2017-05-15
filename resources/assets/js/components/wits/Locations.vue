<template>
  <div class="container-fluid">
    <aside class="col-md-3 col-xs-12">
       

      <div id="selectDropdowns">

        <select v-model="selectedCampus" class="form-control">
          <option value="">Select/Add a Campus</option>
          <option v-for="campus in campuses" :value="campus">{{campus.name}}</option>
        </select>


        <!-- add campuse -->
        <div class="panel panel-default" v-if="selectedCampus==''">
          <div class="panel-body">
            <form class="form-horizontal" v-on:submit.prevent="onSubmitCampus">
              <h2>Add Campus</h2>
              <div class="form-group">
                <label for="campus_name" class="col-sm-2 control-label">Name</label>
                <div class="col-sm-10">
                  <input type="text" v-model="newCampus.name" id="addCampus">
                </div>
              </div>
              <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Code</label>
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

        <select v-model="selectedBuilding" class="form-control" v-if="selectedCampus">
          <option value="">Select/Add a Building</option>
          <option v-for="building in selectedCampus.buildings" :value="building"> {{building.name}}</option>
        </select>

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

        <select v-model="selectedRoom" class="form-control" v-if="selectedBuilding && selectedCampus">
          <option value="">Select/Add a Room</option>
          <option v-for="room in selectedBuilding.rooms" :value="room">{{room.number || room.name}}</option>
        </select>

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

      <template>
        <gmap-map :center="center" :zoom="17" map-type-id="terrain"
        style="width: 100%; height: 300px"
        @rightclick="mapRclicked"
        >

        <gmap-marker
        v-for="(m, index) in markers"
        :position="m.position"
        :clickable="true"
        :draggable="true" @click="center=m.position"
        @dragend="mapDragend"
        >

      </gmap-marker>
    </gmap-map>
  </template>


  <div id="current-item"  v-if="currentItem.type">

    <h2>
      <span class="text-capitalize">{{currentItem.type}}:</span> {{currentItem.number || currentItem.name}}
    </h2>


    <form v-if="currentItem.type == 'campus'" v-on:submit.prevent="onUpdateCampus">
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
      <div class="form-group">
        <label>Name</label>
        <input type="text" class="form-control" v-model="currentItem.name">
      </div>
      <button type="submit" class="btn btn-default">Update Building</button>
    </form>

    <form v-if="currentItem.type == 'room'" v-on:submit.prevent="onUpdateRoom" >
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
          <input type="text" v-model="currentItem.capacity">
        </div>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-default">Update Room</button>
      </div>
    </form>


  </div>

</div>

</div>
</template>
<script>

  import Fuse from 'fuse.js';
  import * as VueGoogleMaps from 'vue2-google-maps';
  import Vue from 'vue';
  import toastr from 'toastr';


  Vue.use(VueGoogleMaps, {
    load: {
      key: 'AIzaSyBaB3pP8S65JEZ9gvA5XxYn5urVMgpoxuU',
      v: '3.27',
    }
  });

  export default{
    data: function(){
      return {
        lastId: 1,
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

        roomStyles: [],
        roomStyle: '',


        center: {lat: 41.192638470302114, lng: -111.9427574918045}, //{lat: 41.192638470302114, lng: -111.9427574918045}
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
        markers: [], //[{position: JSON.parse(currentItem.latlong)}],
        infoContent: '',

      }
    },

    methods:{

      onSubmitCampus: function(e){
        var vm = this;
        axios.post('/api/v1/campus', this.newCampus)
        .then(function (response) {
          console.log(response);
          vm.campuses.push(response.data);

          toastr["success"]("Added Campus: " + response.data.name)

          this.newCampus = {
            name:'',
            campus_code:''
          }
        })
        .catch(function (error) {
          console.log(error);
          toastr["error"](error.response.data)
       });


      },

      onSubmitBuilding: function(e){
        var vm = this;
        this.newBuilding.campus_id = this.currentItem.campus_id

        axios.post('/api/v1/buildings', this.newBuilding)
        .then(function (response) {
          var campus = $.grep(vm.campuses, function (e) {
            return e.id == vm.currentItem.campus_id;
          })[0];

          campus.buildings.push(response.data)
          toastr["success"]("Added building: " + response.data.name)

          this.newBuilding = {
            name:'',
            campus_id:''
          }
        })
        .catch(function (error) {
         toastr["error"](error.response.data)
       });



      },

      onSubmitRoom: function(e){
        var vm = this;

        this.newRoom.building_id = this.currentItem.id
        this.newRoom.style_id = this.roomStyle
        console.log(this.newRoom);
        axios.post('/api/v1/rooms', this.newRoom)
        .then(function (response) {

          var campus_index = vm.campuses.map(function(campus) {return campus.id; }).indexOf(vm.currentItem.campus_id);
          var campus = vm.campuses[campus_index]
          var building_index = campus.buildings.map(function(building) {return building.id; }).indexOf(vm.currentItem.id);

          var building = campus.buildings[building_index];
          if(campus.buildings[building_index].rooms){
            building.rooms.push(response.data);
          }else{
            building.rooms = []
            building.rooms.push(response.data);

          }

          toastr["success"]("Added Room: " + response.data.name)

          this.newRoom = {
            name:''
          }

        })
        .catch(function (error) {
         toastr["error"](error.response.data)
       });



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
          this.newCampus = {
            name:'',
            campus_code:''
          }

        })
        .catch(function (error) {
         toastr["error"](error.response.data)
       })


      },

      onUpdateBuilding: function(e){
        var vm = this;
        this.newBuilding = this.currentItem
        this.newBuilding._method = 'PATCH'

        axios.post('/api/v1/buildings/'+ this.currentItem.id, this.newBuilding)
        .then(function (response) {
          toastr["success"]("Updated Building: " + response.data.name)
          
        })
        .catch(function (error) {
          console.log(error.response)
         toastr["error"](error.response)
       });



      },

      onUpdateRoom: function(e){
        var vm = this;

        this.newRoom = this.currentItem
        this.newRoom._method = 'PATCH'


        console.log(this.newRoom);
        axios.post('/api/v1/rooms/'+ this.currentItem.id, this.newRoom)
        .then(function (response) {
          toastr["success"]("Updated Building: " + response.data.name)
          this.newRoom = {
            name:''
          }
          
        })
        .catch(function (error) {
         toastr["error"](error.response.data)
       });



      },

      mapClicked: function mapClicked(mouseArgs) {
        console.log('map clicked', mouseArgs);
      },

      mapRclicked: function mapRclicked(mouseArgs) {
        var createdMarker = this.addMarker();

        createdMarker.position.lat = mouseArgs.latLng.lat();
        createdMarker.position.lng = mouseArgs.latLng.lng();

        if(this.currentItem){

          this.currentItem.latlong = JSON.stringify(createdMarker.position)


          var data = {
            _method: 'PATCH',
            latlong: this.currentItem.latlong
          }

          switch(this.currentItem.type){
            case "campus":
            axios.post('/api/v1/campus/'+this.currentItem.id, data)
            .then(function (response) {
              toastr["success"]("Marker Placed")

            })
            .catch(function (error) {
             toastr["error"](error.response.data)
           });

            break;

            case "building":
            axios.post('/api/v1/buildings/'+this.currentItem.id, data)
            .then(function (response) {
              toastr["success"]("Marker Placed")

            })
            .catch(function (error) {
             toastr["error"](error.response.data)
           });

            break;

            case "room":
            axios.post('/api/v1/rooms/'+this.currentItem.id, data)
            .then(function (response) {
              toastr["success"]("Marker Placed")
            })
            .catch(function (error) {
             toastr["error"](error.response.data)
           });

            break;
          }
        }
      },

      mapDragend: function mapDragend(mouseArgs) {
        this.currentItem.latlong = JSON.stringify({"lat": mouseArgs.latLng.lat(), "lng":mouseArgs.latLng.lng()})

        var data = {
          _method: 'PATCH',
          latlong: this.currentItem.latlong
        }

        console.log(data);


        switch(this.currentItem.type){
          case "campus":
          axios.post('/api/v1/campus/'+this.currentItem.id, data)
          .then(function (response) {
            toastr["success"]("Marker Placed")
          })
          .catch(function (error) {
           toastr["error"](error.response.data)
         });

          break;

          case "building":
          axios.post('/api/v1/buildings/'+this.currentItem.id, data)
          .then(function (response) {
            toastr["success"]("Marker Placed")
          })
          .catch(function (error) {
           toastr["error"](error.response.data)
         });

          break;

          case "room":
          axios.post('/api/v1/rooms/'+this.currentItem.id, data)
          .then(function (response) {
            toastr["success"]("Marker Placed")
          })
          .catch(function (error) {
           toastr["error"](error.response.data)
         });

          break;
        }
      },

      addMarker: function addMarker() {
        this.lastId++;

        this.markers.push({
          id: this.lastId,
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
          ifw2text: 'This text is bad please change me :( '
        });
        return this.markers[this.markers.length - 1];
      },
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
        if (item == "") {
          this.currentItem = {}
          return;
        }


        this.currentItem = item
        this.currentItem.type = 'room'

      }
    },

    computed: {
      currentItem: function(){

        this.markers = []

        if( _.isObject(this.selectedCampus) && _.isObject(this.selectedBuilding) && _.isObject(this.selectedRoom))
        {
          var currentItem = this.selectedRoom
          currentItem.type = 'room'
          currentItem.campus_id = this.selectedCampus.id
          currentItem.building_id = this.selectedBuilding.id

          if (currentItem.latlong) {
            this.markers = [{position: JSON.parse(currentItem.latlong)}];
            this.center = JSON.parse(currentItem.latlong);
          }
          console.log(this.center);
          return currentItem;
        }

        if( _.isObject(this.selectedCampus) && _.isObject(this.selectedBuilding) )
        {
          var currentItem = this.selectedBuilding
          currentItem.campus_id = this.selectedCampus.id

          currentItem.type = 'building'

          if (currentItem.latlong) {
            this.markers = [{position: JSON.parse(currentItem.latlong)}];
            this.center = JSON.parse(currentItem.latlong);
          }
          return currentItem;
        }

        if(_.isObject(this.selectedCampus))
        {
          var currentItem = this.selectedCampus
          currentItem.campus_id = this.selectedCampus.id
          currentItem.type = 'campus'

          if (currentItem.latlong) {
            this.markers = [{position: JSON.parse(currentItem.latlong)}];
            this.center = JSON.parse(currentItem.latlong);
          }
          return currentItem;
        }

        return {type:null}
      },
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

      axios.get('/api/v1/campus?with=buildings,buildings.rooms')
      .then(function (response) {
        vm.campuses = response.data;
        toastr["success"]("Loaded Locations")
      })
      .catch(function (error) {
        console.log(error);
      });

      axios.get('/api/v1/roomstyle')
      .then(function (response) {
        vm.roomStyles = response.data;
      })
      .catch(function (error) {
       toastr["error"](error)
     });


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

