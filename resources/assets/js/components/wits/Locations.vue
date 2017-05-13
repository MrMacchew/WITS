<template>
    <div class="container-fluid">
        <aside class="col-md-3 col-xs-12">

            <!-- add campuse -->
            <div class="panel panel-default" v-show="showAddCampus">
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


            <!-- add building -->
            <div class="panel panel-default" v-show="showAddBuilding">
              <div class="panel-body">
                <form class="form-horizontal" v-on:submit.prevent="onSubmitBuilding">
                  <h2>Add Building <span>to {{currentItem.name}}</span></h2>
                  <p class="text-muted" > Select campus to add building too. </p>
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

            <!-- add room -->
            <div class="panel panel-default" v-show="showAddRoom">
              <div class="panel-body">
                <form class="form-horizontal" v-on:submit.prevent="onSubmitRoom">
                  <h2>Add Room <span>to {{currentItem.name}}</span></h2>
                  <p class="text-muted"> Select Bulding to add room too. </p>

                  <div class="form-group">
                    <label for="room_name" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                      <input type="text" v-model="newRoom.name" id="addRoom">
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit"
                      :disable="currentType !== 'building'"
                      class="btn btn-default">Add Room</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>


            <div class="pull-right">
                <span class="fa-stack" @click="toggleAdd('campus')" data-toggle="tooltip" title="Add Campus">
                  <i class="fa fa-university"></i>
                  <i class="fa fa-plus" style="left: 9px; position: absolute; top: -3px;"></i>
                </span>

                <span class="fa-stack" @click="toggleAdd('building')" data-toggle="tooltip" title="Add Building">
                  <i class="fa fa-cubes"></i>
                  <i class="fa fa-plus" style="left: 9px; position: absolute; top: -3px;"></i>
                </span>

                <span class="fa-stack" @click="toggleAdd('room')" data-toggle="tooltip" title="Add Room">
                  <i class="fa fa-cube"></i>
                  <i class="fa fa-plus" style="left: 9px; position: absolute; top: -3px;"></i>
                </span>
              </div>

            <div class="btn-group">

                <i class="fa fa-filter"></i>
                <input id="search" type="text" v-model="search" placeholder="campus, building, room" style="width: 180px;">
                <span id="searchclear" @click="resetSearch()" class="glyphicon glyphicon-remove-circle"></span>
            </div>


            <template>
                <ul id="location-menu" v-for="(campus, campusKey) in results">

                    <a @click="onSelectMenuItem('campus', campus)"
                    data-toggle="collapse"
                    :data-target="'.campus'+campusKey"
                    class="accordion-toggle"
                    aria-expanded="true">{{campus.name}} ({{campus.buildings.length}})</a>

                    <template>
                    <li v-for="(building, buildingKey) in campus.buildings"
                    :class="'campus'+campusKey" class="accordian-body collapse in">
                        <ul >
                            <li>
                                <a @click="onSelectMenuItem('building', building)"
                                data-toggle="collapse"
                                :data-target="'.building'+buildingKey"
                                class="accordion-toggle"
                                aria-expanded="true"> {{building.name}} ({{building.rooms.length}})</i></a>

                                <ul class="accordian-body collapse in" :class="'building'+buildingKey">
                                    <li v-for="(room, roomKey) in building.rooms">
                                        <a @click="onSelectMenuItem('room', room)">{{room.number || room.name}}</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    </template>

                </ul>
            </template>

        </aside>

        <div class="col-xs-12 col-md-9">

      <template>
        <gmap-map
            :center="{lat: 41.19287259976383, lng: -111.9421459481491}"
            :zoom="17"
            map-type-id="terrain"
            style="width: 100%; height: 300px"
            @rightclick="mapRclicked"
            >

          <gmap-marker v-for="(m, index) in markers":position="m.position":clickable="true":draggable="true"@click="center=m.position">
            <gmap-info-window :opened=\"m.ifw\" :content=\"m.ifw2text\"></gmap-info-window>
          </gmap-marker>

        </gmap-map>
      </template>








      <div id="current-item"  v-if="currentItem">


        <h2>{{currentType|capitalize}}: {{currentItem.number || currentItem.name}} </h2>



          <form v-if="currentType == 'campus'" >
            <div class="form-group">
              <label>Name</label>
              <input type="text" class="form-control" v-model="currentItem.name">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Campus Code</label>
              <input type="text" class="form-control" v-model="currentItem.campus_code">
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
            <button type="submit" class="btn btn-default">Submit</button>
          </form>

           <form v-if="currentType == 'building'" >
            <div class="form-group">
              <label>Name</label>
              <input type="text" class="form-control" v-model="currentItem.name">
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
          </form>

           <form v-if="currentType == 'room'" >
            <div class="form-group">
              <label>Name</label>
              <input type="text" class="form-control" v-model="currentItem.name">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Campus Code</label>
              <input type="text" class="form-control" v-model="currentItem.campus_code">
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
            <button type="submit" class="btn btn-default">Submit</button>
          </form>


      </div>

    </div>

  </div>
</template>
<script>

  import Fuse from 'fuse.js';

  import * as VueGoogleMaps from 'vue2-google-maps';
  import Vue from 'vue';

  Vue.use(VueGoogleMaps, {
    load: {
      key: 'AIzaSyBaB3pP8S65JEZ9gvA5XxYn5urVMgpoxuU',
      v: '3.27',
      // libraries: 'places', //// If you need to use place input
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
            currentItem: null,
            currentType: "",
            campuses: [],

            center: {lat: 41.192638470302114, lng: -111.9427574918045},
            newCampus: {
              name:'',
              campus_code:''
            },
            newBuilding: {
              name:'',
            },
            newRoom: {
              name:'',
            },
            markers: [
              {position: {lat: 41.19279206612305, lng: -111.9447934627533} }
            ],
            infoContent: 'test',

          }
        },
        methods:{
            resetSearch: function(){
                this.search = '';
            },
            toggleAdd: function (type) {
              this.showAddCampus = type=='campus' ? true : false;
              this.showAddBuilding = type=='building' ? true : false;
              this.showAddRoom = type=='room' ? true : false;
            },
            onSubmitCampus: function(e){
              console.log(this, e)
              var vm = this;
              axios.post('/api/v1/campus', this.newCampus)
              .then(function (response) {
                console.log(response);
                vm.campuses.push(response.data);

              })
              .catch(function (error) {
                console.log(error);
              });

              //reset new campus
              this.newCampus = {
                name:'',
                campus_code:''
              },
              this.toggleCampus()

            },
            onSelectMenuItem: function(type, obj){
              this.currentType = type
              this.currentItem = obj
              console.log(this.currentType, obj)

              // _.each(Object.keys(obj), function(item){
              //   console.log(type, obj[item])
              // })

            },




            mapClicked: function mapClicked(mouseArgs) {
            console.log('map clicked', mouseArgs); // eslint-disable-line no-console
            },

            mapRclicked: function mapRclicked(mouseArgs) {
              var createdMarker = this.addMarker();
              // this.toggleCampus();

              createdMarker.position.lat = mouseArgs.latLng.lat();
              createdMarker.position.lng = mouseArgs.latLng.lng();
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
        computed: {
            results: function() {
                // console.clear();

                if (this.search == "") {
                    return this.campuses;
                }

                var filteredData =  _.cloneDeep(this.campuses),
                    q = this.search.split(",");


                filteredData = filteredData.filter(function(o,i){
                    return o.name.toLowerCase().match(new RegExp(q[0]))
                })

                _.each(filteredData, function(cv,ck){

                    filteredData[ck].buildings = cv.buildings.filter(function(o,i){
                        if(o.name.toLowerCase().match(new RegExp(q[1]))){
                            return o.name
                        }
                    })


                    _.each(filteredData[ck].buildings, function(rv,rk){
                        filteredData[ck].buildings[rk].rooms = rv.rooms.filter(function(room,i){
                            if(room.name.toLowerCase().match(new RegExp(q[2]))){
                                return room.number || room.name
                            }
                        })
                    })

                })


                console.log(q)
                console.log('data', filteredData);
                return filteredData;
            }
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
            // console.log('Component mounted.')

            axios.get('/api/v1/campus?with=buildings,buildings.rooms')
            .then(function (response) {
                console.log(response);
                vm.campuses = response.data;
                vm.currentItem = response.data[0];
                vm.currentType = 'campus';
            })
            .catch(function (error) {
                console.log(error);
            });




        }
    }
</script>
