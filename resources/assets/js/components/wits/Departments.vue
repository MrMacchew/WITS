<template>
    <div id="department-vue" class="container-fluid">

        <aside class="col-md-3 col-xs-12">
            <div id="selectDropdowns">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="pull-right">
                          <i class="fa fa-check-square-o" @click="toggleCheckboxes = !toggleCheckboxes"></i>
                      </span>
                      <h3 class="panel-title">Departments</h3>

                      <div><input v-model="search" type="text"></div>
                  </div>
                  <div>
                    <ul>
                        <li v-for="(department, departmentKey) in results">
                            <span> <input type="checkbox" v-if="toggleCheckboxes"></span>
                            {{department.name }}
                        </li>
                    </ul>
                </div>

            </div>

            </div>
        </aside>
        <div class="col-xs-12 col-md-9">
             <!-- <span class="editable" data-url="/update_title.php">Hello world</span> -->

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
</template>

<script>
    import Fuse from 'fuse.js';
    import _ from 'lodash';
    import toastr from 'toastr';

    export default
    {
        data: function() {
            return {

                currentItem: {},

                toggleCheckboxes: false,

                departments: [],


                fields: ['name', 'email', '__slot:actions'],
                search: '',
                fuse: null,
                results: [],


            }
        },
        methods: {
            setSelectSizedepartment: function (e) {
                if (this.currentItem.type == 'department') {
                    return 1
                }
                if (this.currentItem.type == 'department') {
                    return 1
                }
                if (this.currentItem.type == null) {
                    return 3
                }
            },
            setSelectSizeDepartment: function (e) {
                if (this.currentItem.type == 'team') {
                    return 1
                }
                if (this.currentItem.type == 'department') {
                    return 1

                }
                if (this.currentItem.type == 'department') {
                    return 10

                }
            },
            setSelectSizeTeam: function (e) {
                if (this.currentItem.type == 'team') {
                    return 10
                }
                if (this.currentItem.type == 'department') {
                    return 10
                }
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
        mounted()
        {
            var vm = this

            $(document).ready(function(){
                $('.editable').jinplace();
                $('body').on('click', '.editable', function(){
                    $('.editable').jinplace();
                });
            })

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
