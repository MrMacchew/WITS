<template>
	<div class="container-fluid">


		<aside class="col-md-3 col-xs-12">
			<div class="btn-group">
				<i class="fa fa-filter"></i>
				<input id="search" type="text" v-model="search">
				<span id="searchclear" @click="search = ''" class="glyphicon glyphicon-remove-circle"></span>
			</div>

			<template >
				<ul id="location-menu" v-for="(campus, campusKey) in campuses">
					<li>

						<a data-toggle="collapse"
						:data-target="'#campus'+campusKey"
						class="accordion-toggle"
						aria-expanded="false">{{campus.name}} {{campusKey}} </a>
					</li>


					<li v-for="(building, buildingKey) in campus.buildings" >
						<ul class="accordian-body collapse" :id="'campus'+campusKey">
							<li>
								<a data-toggle="collapse"
								:data-target="'#building'+buildingKey"
								class="accordion-toggle"
								aria-expanded="false"> {{building.name}} {{buildingKey}}  {{campus.id}}.{{building.id}}</i></a>

								<ul class="accordian-body collapse" :id="'building'+buildingKey">
									<li v-for="k in 2">
										<a>Room {{campus.id}}.{{building.id}}.{{k}}</a>
									</li>
								</ul>

							</li>
						</ul>

					</li>
				</ul>

			</template>
		</aside>






<!-- 		<aside class="col-md-3 col-xs-12">
			<div class="btn-group">
				<i class="fa fa-filter"></i>
				<input id="search" type="text" v-model="search">
				<span id="searchclear" @click="search = ''" class="glyphicon glyphicon-remove-circle"></span>
			</div>

			<ul class="metismenu" id="location-menu">

				<li v-for="campus in result">
					<a aria-expanded="false">{{campus.name}} <i class="fa fa-fw fa-chevron-left"></i></a>
					<ul>
						<li v-for="building in campus.buildings">
							<a aria-expanded="false">{{building.name}} {{campus.id}}.{{building.id}}</i></a>
							<ul>
								<li v-for="k in 50"><a href="javascript:;">Room {{campus.id}}.{{building.id}}.{{k}}</a></li>
							</ul>
						</li>
					</ul>
				</li>


			</ul>

		</aside> -->


		<div class="col-xs-12 col-md-9" style="background:red">.col-xs-12 .col-md-8</div>

	</div>
</template>
<script>

	import Fuse from 'fuse.js';
	export default{
		data: function(){
			return {
				search: '',
				campuses: [],
				fuse: null,
				result: []

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
				'name'
				]
			};



			axios.get('/api/v1/campus?with=buildings')
			.then(function (response) {
				console.log(response);
				vm.campuses = response.data;

				vm.fuse = new Fuse(vm.campuses, options);
				vm.result = vm.campuses;


			})
			.catch(function (error) {
				console.log(error);
			});

			// axios.get('/api/v1/roles?fields=id,name')
			// .then(function (response) {
			// 	console.log(response);
			// 	vm.roles = response.data;
			// })
			// .catch(function (error) {
			// 	console.log(error);
			// });

			// axios.get('/api/v1/roles?fields=id,name')
			// .then(function (response) {
			// 	console.log(response);
			// 	vm.roles = response.data;
			// })
			// .catch(function (error) {
			// 	console.log(error);
			// });


		}
	}
</script>