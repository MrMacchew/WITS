<template>

    <div id="inventory-vue" class="container-fluid">

        <template>
            <ui-collapsible :title="inventory.departmentInventory.name" class="department" :open="true">
                <inventory-table :data="inventory.departmentInventory.assets"/>
            </ui-collapsible>
        </template>


        <template v-for="department in inventory.subDeparmentsInventory">

            <!-- Child DeparmentsInventory -->
            <ui-collapsible :title="department.name" class="childDepartment">

                <inventory-table :data="department.assets"/>

            </ui-collapsible>

            <!-- Grand Child DeparmentsInventory -->
            <ui-collapsible v-for="department in department.children" :title="department.name"
                            class="grandchildDepartment">

                <!-- subSubDeparmentsInventory -->
                <inventory-table :data="department.assets"/>

            </ui-collapsible>

        </template>

    </div>

</template>

<script>
    import _ from 'lodash';
    import confirm from 'jquery-confirm';
    import Form from '../../utils/Form';


    export default {
        data: function () {
            var vm = this

            return {
                currentuser: {},
                inventory: {
                    columns: [

                        {
                            label: 'Photo'
                        },
                        {
                            label: 'Id',
                            field: 'id',
                            type: 'number',
                            filterable: true
                        },
                        {
                            label: 'Name',
                            field: 'name',
                            filterable: true,
                            filter: regexFilter

                        },
                        // {label:'Department Id', field:'department_id', filterable:true, },
                        // {label:'Category Id', field:'category_id', filterable:true, },
                        // {label:'Checkoutable', type:'string', field:'checkoutable', filterable:true, },
                        {
                            label: 'Cost',
                            field: 'cost',
                            type: 'number',
                            filterable: true,
                            filter: regexFilter

                        },
                        // {label:'Description', field:'description', filterable:true, },
                        {
                            label: 'Manufacturer',
                            field: 'manufacturer',
                            filterable: true,
                            filter: regexFilter

                        },
                        {
                            label: 'Tag #',
                            field: 'weber_inventory_tag',
                            type: 'string',
                            filterable: true,
                            filter: regexFilter

                        },
                        {
                            label: 'Model',
                            field: 'model',
                            filterable: true,
                            filter: regexFilter

                        },
                        {
                            label: 'Po #',
                            field: 'po_number',
                            filterable: true,
                            filter: regexFilter

                        },
                        // {label:'Replacement Id', field:'replacement_id', type:'number', filterable:true, },
                        {
                            label: 'Serial #',
                            field: 'serial_number',
                            type: 'string',
                            filterable: true,
                            filter: regexFilter

                        },
                        {
                            label: 'Acquired',
                            field: 'acquisition_date',
                            type: 'date',
                            inputFormat: 'YYYY-MM-DD',
                            outputFormat: 'YYYY-MM-DD',
                            filterable: true,
                            filter: regexFilter

                        },
                        {
                            label: 'Room',
                            field: function (data) {
                                return data.number ? "room.number" : ""
                            },
                            type: 'number',
                            filterable: true,
                            filter: regexFilter

                        },
                        // {label:'Created', field:'created_at', type:'date', inputFormat:'YYYY-MM-DD HH:MM:SS', outputFormat:'MM-D-YY', filterable:true, },
                        // {label:'Updated', field:'updated_at', type:'date', inputFormat:'YYYY-MM-DD HH:MM:SS', outputFormat:'MM-D-YY', filterable:true, },
                    ],
                    departmentInventory: {},
                    subDeparmentsInventory: {}
                }
            }

            function regexFilter(data, filterString) {

                if (data.match(new RegExp(filterString, "mig"))) {
                    console.log(data, filterString)

                } else {
                    console.log(this, data, filterString)
                }
                return data.match(new RegExp(filterString, "mig"));
            }


        },
        methods: {
            onClickFn: function (row, index) {
//                console.log(row, index);
            },
            onPageChange: function () {
                console.log('onPageChange');
            },


        },
        watch: {},
        computed: {},
        mounted() {
            var vm = this

            axios.get('/api/v1/currentuser?fields=username,id')
                .then(function (response) {
                    vm.currentuser = response.data.currentuser;
                    toastr["success"]("Loaded Users")
                })
                .catch(vm.handleError);

            axios.get('/api/v1/currentuser?' +
                'fields=username,id&' +
                'with=' +

                // Department Assets
                'departments.assets,' +

                'departments.assets.room,' +
                'departments.assets.room.roomstyle,' +
                'departments.assets.room.building,' +
                'departments.assets.room.building.campus,' +

                'departments.assets.checkout,' +

//                'departments.assets.properties,' +
                'departments.assets.properties.name,' +

                // Department Child Assets
                'departments.children.assets,' +

                'departments.children.assets.room,' +
                'departments.children.assets.room.roomstyle,' +
                'departments.children.assets.room.building,' +
                'departments.children.assets.room.building.campus,' +

                'departments.children.assets.checkout,' +


                // Department Grand Child Assets
                'departments.children.children,' +
                'departments.children.children.assets,' +

                'departments.children.children.assets.room,' +
                'departments.children.children.assets.room.roomstyle,' +
                'departments.children.children.assets.room.building,' +
                'departments.children.children.assets.room.building.campus,' +

                'departments.children.children.assets.checkout,' +

                'departments.parent')
                .then(function (response) {
                    vm.inventory.departmentInventory = response.data.currentuser.departments[0];
                    vm.inventory.subDeparmentsInventory = response.data.currentuser.departments[0].children;
                    toastr["success"]("Loaded Inventory")
                })
                .catch(vm.handleError);
        }

    }

</script>





