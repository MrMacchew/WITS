<template>
	<div class="container-fluid">


		<aside class="col-md-3 col-xs-12">

			<div class="btn-group">
				<i class="fa fa-filter"></i>
				<input id="search" type="text" v-model="search" placeholder="campus, building, room" style="
    width: 180px;">
				<span id="searchclear" @click="resetSearch()" class="glyphicon glyphicon-remove-circle"></span>
			</div>


			<template>
				<ul id="location-menu" v-for="(campus, campusKey) in results">

					<a @click="selectedItem = campus"
					data-toggle="collapse"
					:data-target="'.campus'+campusKey"
					data-parent="#location-menu"
					class="accordion-toggle"
					aria-expanded="true">{{campus.name}} ({{campus.buildings.length}})</a>

					<template>
					<li v-for="(building, buildingKey) in campus.buildings"
					:class="'campus'+campusKey" class="accordian-body collapse">
						<ul >
							<li>
								<a @click="selectedItem = building"
								data-toggle="collapse"
								:data-target="'.building'+buildingKey"
								data-parent="#location-menu"
								class="accordion-toggle"
								aria-expanded="true"> {{building.name}} ({{building.rooms.length}})</i></a>

								<ul class="accordian-body collapse" :class="'building'+buildingKey">
									<li v-for="(room, roomKey) in building.rooms">
										<a @click="selectedItem = room">{{room.name}}</a>
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
			<gmap-map
			:center="{lat: 41.19287259976383, lng: -111.9421459481491}"
			:zoom="16"
			map-type-id="terrain"
			style="width: 100%; height: 300px"
			>



			</gmap-map>

		{{selectedItem.name  }}

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
				selectedItem: {},
				campuses: [],
				buildings: [],
				rooms: [],
				center: {lat: 41.192638470302114, lng: -111.9427574918045},
        // markers: [{
        //   position: {lat: 10.0, lng: 10.0}
        // }, {
        //   position: {lat: 11.0, lng: 11.0}
        // }]

			}
		},
		methods:{
			resetSearch: function(){
				this.search = '';
				this.campuses.$forceUpdate();

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
			console.log('Component mounted.')

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