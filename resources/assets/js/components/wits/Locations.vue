<template>
	<div class="container-fluid">


		<aside class="col-md-3 col-xs-12">

			<!-- <div class="btn-group">
				<i class="fa fa-filter"></i>
				<input id="search" type="text" v-model="search">
				<span id="searchclear" @click="search = ''" class="glyphicon glyphicon-remove-circle"></span>
			</div>
			 -->

			<template>
				<ul id="location-menu" v-for="(campus, campusKey) in campuses">

					<a @click="selectedItem = campus"
					data-toggle="collapse"
					:data-target="'.campus'+campusKey"
					data-parent="#location-menu"
					class="accordion-toggle"
					aria-expanded="false">{{campus.name}} ({{campus.buildings.length}})</a>

					<template>
					<li v-for="(building, buildingKey) in campus.buildings" :class="'campus'+campusKey" class="accordian-body collapse">
						<ul >
							<li>
								<a @click="selectedItem = building"
								data-toggle="collapse"
								:data-target="'.building'+buildingKey"
								data-parent="#location-menu"
								class="accordion-toggle"
								aria-expanded="false"> {{building.name}} ({{building.rooms.length}})</i></a>

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
				
				<gmap-marker
      v-for="m in markers"
      :position="m.position"
      :clickable="true"
      :draggable="true"
      @click="center=m.position"
    ></gmap-marker>

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
				// search: '',
				selectedItem: {},
				campuses: [],
				// result: [],
				// fuse: null,
				center: {lat: 41.192638470302114, lng: -111.9427574918045},
        markers: [{
          position: {lat: 10.0, lng: 10.0}
        }, {
          position: {lat: 11.0, lng: 11.0}
        }]

			}
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
				"name",
				"buildings.name",
				"buildings.latlong"
				]
			};



			axios.get('/api/v1/campus?with=buildings,buildings.rooms')
			.then(function (response) {
				console.log(response);
				vm.campuses = response.data;

				// vm.fuse = new Fuse(vm.campuses, options);
				// vm.result = fuse.search(search);


			})
			.catch(function (error) {
				console.log(error);
			});




		}
	}
</script>