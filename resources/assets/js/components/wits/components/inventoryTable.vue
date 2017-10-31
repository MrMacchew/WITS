<template>
    <div>

        <vue-good-table
            :columns="inventory.columns"
            :rows="data"
            :lineNumbers="false"
            :childrow="true"
            :tableActions="true"
            :paginate="true"
            styleClass="table table-bordered table-striped condensed vue-good-table "
            :onClick="onClickFn"
        >
            <template slot="table-actions" scope="props">
                <div class="input-group col-md-3">
                    <select class="form-control">
                        <option value="">Bulk Edit</option>
                        <option value="delete">Delete</option>
                        <option value="edit">Edit</option>
                        <option value="duplicate">Duplicate</option>
                    </select>
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button" tabindex="-1"> <span
                            class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span></button>
                        </span>
                </div>
            </template>

            <template slot="table-column" scope="props">
                                <span v-if="props.column.label =='Name'"> <i
                                    class="fa fa-address-book"></i> {{props.column.label}} </span>
                <span v-else> {{props.column.label}} </span>
            </template>

            <template slot="table-row" scope="props">
                <td></td>
                <td>{{props.row.id}}</td>
                <td>{{props.row.name}}</td>
                <td>{{props.row.cost}}</td>
                <td>{{props.row.manufacturer}}</td>
                <td>{{props.row.weber_inventory_tag}}</td>
                <td>{{props.row.model}}</td>
                <td>{{props.row.po_number}}</td>
                <td>{{props.row.serial_number}}</td>
                <td>{{props.formattedRow.acquisition_date}}</td>
                <!--<td><span v-if="props.row.room">{{props.row.room.number}}</span></td>-->
            </template>


            <template slot="childrow" scope="props" v-if="showChildRow" @click="console.log(this.props)">

                <ui-tabs type="text" fullwidth raised>
                    <ui-tab title="General">
                        <!--<p>Asset Picture</p>-->
                        <!--<p>Name: {{props.row.name}}</p>-->
                        <!--<p>manufacturer: {{props.row.manufacturer}}</p>-->
                        <!--<p>model: {{props.row.model}}</p>-->
                        <!--<p>description: {{props.row.description}}</p>-->
                        <!--<p>weber_inventory_tag: {{props.row.weber_inventory_tag}}</p>-->
                        <!--<p>created_at: {{props.row.created_at}}</p>-->
                        <!--<p>updated_at: {{props.row.updated_at}}</p>-->
                        <!--<p>{{props.row.category}}</p>-->

                        <code>
                            <pre>{{props}}</pre>
                        </code>

                    </ui-tab>

                    <ui-tab title="Cost Info">
                        <p>Cost: {{props.row.cost}}</p>
                        <p>Acquisition Date: {{props.row.acquisition_date}}</p>
                        <p>{{props.row.po_number}}</p>
                        Replacement Year,
                        Replacement Cost,
                        Replacement ID,
                        Category
                    </ui-tab>

                    <ui-tab title="Location">
                        <p>Campus:
                            <span v-if="props.row.room">
                                                {{props.row.room.building.campus.name}}
                                            </span>
                        </p>

                        <p>Building:
                            <span v-if="props.row.room">
                                                {{props.row.room.building.name}}
                                            </span>
                        </p>

                        <p>Number:
                            <span v-if="props.row.room">
                                                {{props.row.room.number}}
                                            </span>
                        </p>

                        <p>Name:
                            <span v-if="props.row.room">
                                                {{props.row.room.name}}
                                            </span>
                        </p>

                        <p>Style:
                            <span v-if="props.row.room && props.row.room.roomstyle">
                                                {{props.row.room.roomstyle.name}}
                                            </span>
                        </p>

                        <p>Capacity:
                            <span v-if="props.row.room">
                                                {{props.row.room.capacity}}
                                            </span>
                        </p>
                        Map,
                    </ui-tab>

                    <ui-tab title="properties">

                        <properties :id="props.row.id" :data="props.row.properties"></properties>

                    </ui-tab>

                    <ui-tab title="Checkout">
                        <b>Checkout</b>


                        <p v-if="props.row.checkout">asset_id: {{props.row.checkout.asset_id}}</p>
                        <p v-if="props.row.checkout">user_id: {{props.row.checkout.user_id}}</p>
                        <p v-if="props.row.checkout">cost_code: {{props.row.checkout.cost_code}}</p>
                        <p v-if="props.row.checkout">checkout_date: {{props.row.checkout.checkout_date}}</p>
                        <p v-if="props.row.checkout">due_date: {{props.row.checkout.due_date}}</p>
                        <p v-if="props.row.checkout">checkin_date: {{props.row.checkout.checkin_date}}</p>


                    </ui-tab>

                </ui-tabs>

            </template>

        </vue-good-table>


    </div>
</template>

<script>
    Vue.component('properties', require('./properties.vue'));

    export default {
        props: ['data'],
       data: function () {
            var vm = this

            return {
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
//                        {
//                            label: 'Room',
//                            field: function (data) {
//                                return data.number ? "room.number" : ""
//                            },
//                            type: 'number',
//                            filterable: true,
//                            filter: regexFilter
//
//                        },
                        // {label:'Created', field:'created_at', type:'date', inputFormat:'YYYY-MM-DD HH:MM:SS', outputFormat:'MM-D-YY', filterable:true, },
                        // {label:'Updated', field:'updated_at', type:'date', inputFormat:'YYYY-MM-DD HH:MM:SS', outputFormat:'MM-D-YY', filterable:true, },
                    ],
                }
            }

            function regexFilter(data, filterString) {

                if (data.match(new RegExp(filterString, "mig"))) {
                    console.log(data, filterString)
                    return data.match(new RegExp(filterString, "mig"));


                }
            }


        },
        methods: {
            onClickFn: function (row, index) {
//                console.log(row, index);
            },
            onPageChange: function () {
//                console.log('onPageChange');
            },

        },
        watch: {},
        computed: {},
        mounted() {
            var vm = this
        }

    }

</script>
