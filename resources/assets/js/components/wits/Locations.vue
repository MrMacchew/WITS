<template>
    <div class="container-fluid">
        <aside class="col-md-3 col-xs-12">




            <div class="panel panel-default" v-show="showCampus">
              <div class="panel-body">
                <form class="form-horizontal" v-on:submit.prevent="onSubmitCampus">
                  <h1>Add Campus</h1>
                  <div class="form-group">
                    <label for="campus_name" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                      <input type="text" v-model="newCampus.name">
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


            <div class="pull-right">
                <span class="fa-stack" @click="toggleCampus()">
                  <i class="fa fa-building"></i>
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

                    <a @click="onSelectMenuItem('campus')"
                    data-toggle="collapse"
                    :data-target="'.campus'+campusKey"
                    class="accordion-toggle"
                    aria-expanded="true">{{campus.name}} ({{campus.buildings.length}})</a>

                    <template>
                    <li v-for="(building, buildingKey) in campus.buildings"
                    :class="'campus'+campusKey" class="accordian-body collapse in">
                        <ul >
                            <li>
                                <a @click="onSelectMenuItem('building')"
                                data-toggle="collapse"
                                :data-target="'.building'+buildingKey"
                                data-parent="#location-menu"
                                class="accordion-toggle"
                                aria-expanded="true"> {{building.name}} ({{building.rooms.length}})</i></a>

                                <ul class="accordian-body collapse in" :class="'building'+buildingKey">
                                    <li v-for="(room, roomKey) in building.rooms">
                                        <a @click="onSelectMenuItem('room')">{{room.name}}</a>
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
            >
          </gmap-map>
          <gmap-marker
          :key="index"
          v-for="(m, index) in markers"
          :position="m.position"
          :clickable="true"
          :draggable="true"
          @click="center=m.position"
          ></gmap-marker>
        </gmap-map>
      </template>







        {{selectedItem.name  }}

        <div id="current-item">




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
            search: '',
            showCampus: false,
            selectedItem: {},
            campuses: [],
            buildings: [],
            rooms: [],

            center: {lat: 41.192638470302114, lng: -111.9427574918045},
            newCampus: {
              name:'',
              campus_code:''
            },
            markers: [{
              position: {lat: 41.19279206612305, lng: -111.9447934627533,enabled:true}
            }, {
              position: {lat: 41.19437443833441, lng: 111.94445013999939}
            }]

          }
        },
        methods:{
            resetSearch: function(){
                this.search = '';
            },
            toggleCampus: function () {
              this.showCampus = !this.showCampus;
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
            onSelectMenuItem: function(item){
              this.selectedItem = item
              console.log(item)
            }
        },
        computed: {
            results: function() {
                console.clear();

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
                                return room.name
                            }
                        })
                    })

                })


                console.log(q)
                console.log('data', filteredData);
                return filteredData;
            }
        },
        mounted() {
            var vm = this;
            // console.log('Component mounted.')

            axios.get('/api/v1/campus?with=buildings,buildings.rooms')
            .then(function (response) {
                console.log(response);
                vm.campuses = response.data;
            })
            .catch(function (error) {
                console.log(error);
            });




        }
    }
</script>
