<template>
    <div>
        <div class="row mb-3">
            <div class="col-sm-12 col-md-2">
                <div class="d-flex align-items-center">
                    <div class="d-flex align-items-center" v-if="tblData?.download?.length > 0 && tblData.rows.length > 0">
                        <a class="me-2 btn btn-option" href="javascript:void(0)" v-for="btn in tblData?.download"
                           @click="btn.action">
                            <img v-if="!btn.loading" :class="btn.icon" width="16" height="16"/>
                            <span v-if="btn.loading" class="spinner-border spinner-border-sm" role="status"
                                  aria-hidden="true"></span>
                        </a>
                    </div>
                    <div class="d-flex align-items-center" v-if="tblData?.checkboxOption?.length > 0">
                        <a class="me-2 btn btn-option" href="javascript:void(0)"
                           v-if="selectedData.length > 0" v-for="btn in tblData?.checkboxOption"
                           @click="btn.action(selectedData)">
                            <img :class="btn.icon" width="16" height="16"/>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-10">
                <div class="dataTables_filter d-flex align-items-center justify-content-end">
                    <div v-if="tblData?.dateSearch" class="me-3 position-relative">
                        <flat-pickr class="form-control table-control form-control-sm" v-model="date"
                                    :value="tblData.dateSearch.selectedDate != '' ? tblData.dateSearch.selectedDate : ''"
                                    placeholder="Select Date"
                                    :config="{dateFormat: 'Y-m-d', altInput: true, altFormat:'d/m/Y', mode: 'range'}"
                                    @on-change="tblData?.dateSearch.action"/>
                        <i class="bx bx-calendar calendar-icon table-icon"></i>
                    </div>
                    <div class="d-flex align-items-center" v-if="tblData?.dropdown?.length > 0">
                        <select class="form-control-sm form-select table-control me-3"
                                v-for="select in tblData.dropdown" @change="select.action($event)">
                            <option v-if="select?.title" value="">{{ select.title }}</option>
                            <option :selected="param[select?.keyForSelected] === option.id"
                                    v-for="option in select.data" :value="option.id">{{ option.name }}
                            </option>
                        </select>
                    </div>
                    <div v-if="tblData?.bulk_actions?.length > 0" class="me-3">
                        <button class="btn btn-sm btn-inverse-primary btn-width" v-for="btn in tblData.bulk_actions"
                                @click="btn.action">
                            <i style="font-size: 14px" :class="btn.icon"></i>
                            {{ btn.name }}
                        </button>
                    </div>
                    <label class="d-flex align-items-center justify-content-center">
                        <input v-model="param.keyword" type="text" class="form-control table-control form-control-sm"
                               placeholder="Search">
                    </label>
                    <button class="btn btn-sm btn-inverse-primary ms-3" v-if="tblData?.searchBtn" @click="tblData.searchBtn.action">{{tblData.searchBtn.name}}</button>
                </div>
            </div>
        </div>
        <div class="table-height">
            <table class="table mb-0 table-striped table-bordered dataTable"
                   :class="tblData?.alignTop ? 'align-top' : 'align-middle'">
                <thead>
                <tr>
                    <template v-for="headerCol in tblData['columns']">
                        <th class="checkbox-center" v-if="headerCol['type'] === 'checkbox'">
                            <input :checked="isCheckedAll()"
                                   class="form-check-input"
                                   type="checkbox"
                                   @click="toggleCheckAll($event)">
                        </th>
                        <th v-if="headerCol['type'] !== 'checkbox'" class="cursor-pointer"
                            @click="headerCol['sortable'] ? orderData(headerCol['key']) : ''"
                            :class="headerCol['sortable'] ? orderClass(headerCol['key']) : ''">
                            <div class="text-label">
                                <div>{{ headerCol['label'] }}</div>
                            </div>
                        </th>
                    </template>
                    <th v-if="tblData.row_actions.length > 0"></th>
                </tr>
                </thead>
                <tbody v-if="!tblData.loading && tblData.rows.length > 0">
                <tr v-for="dataRow in tblData.rows">
                    <template v-for="dataCol in tblData['columns']">
                        <td class="checkbox-center" v-if="dataCol['type'] === 'checkbox'">
                            <input :checked="isChecked(dataRow.id)"
                                   class="form-check-input row-checkbox"
                                   type="checkbox"
                                   @click="toggleCheck($event, dataRow.id)">
                        </td>
                        <td v-if="dataCol['type'] === 'img'">
                            <img class="table-image" :src="dataRow[dataCol['key']]" alt="">
                        </td>
                        <td v-if="dataCol['type'] === 'imgArr'">
                            <img class="table-image" v-if="dataRow[dataCol['key']].length > 0" :src="dataRow[dataCol['key']][0]['full_path']" alt="">
                        </td>
                        <td v-if="dataCol['type'] === 'text'"
                            :class="dataCol['isCapital'] !== undefined && dataCol['isCapital'] === true ? 'text-capitalize' : ''">
                            <span v-if="dataCol['photo'] !== undefined && dataCol['photo'] === true">
                                <img class="table-avatar" v-if="dataRow.image_path"
                                     :src="dataRow.image_path" alt="">
                            </span>
                            <span v-if="dataCol['isStatus'] !== undefined && dataCol['isStatus'] === true"
                                  class="badge rounded-pill text-capitalize m-0 text-white fw-normal fs-13"
                                  :class="bgColor(dataRow[dataCol['key']])">
                                {{ dataRow[dataCol['key']] }}
                            </span>
                            <span v-else>{{ dataRow[dataCol['key']] }}</span>
                        </td>
                        <td v-if="dataCol['type'] === 'arrayText'">
                            <ol class="m-0 ps-3 order-list"
                                :class="{'no-list-style ps-0' : dataCol['no_list_style'] !== undefined &&  dataCol['no_list_style'] === true}">
                                <li v-for="row in dataRow[dataCol['key']]"
                                    :class="{'enable-padding':  dataCol['enable_padding'] !== undefined &&  dataCol['enable_padding'] === true}">
                                    {{ row[dataCol['text']] }}
                                    <span class="line" v-if="dataCol['border'] !== undefined &&  dataCol['border'] === true"></span>
                                </li>
                            </ol>
                        </td>
                    </template>
                    <td v-if="tblData.row_actions.length > 0">
                        <div class="d-flex justify-content-end">
                            <template v-for="(rowAction, index) in tblData['row_actions']">
                                <button class="btn btn-radius me-2"  v-if="isBtnShow(dataRow, rowAction['name'])"
                                        v-tooltip="capitalizeFirstLetter(rowAction['name'])"
                                        :class="rowAction['color']"
                                        @click="onActionIconClick(rowAction['name'], dataRow, $event)">
                                    <i v-if="rowAction['type'] === 'action'" :class="rowAction['label']"></i>
                                </button>
                            </template>
                        </div>
                    </td>
                </tr>
                </tbody>
                <tbody v-if="tblData.loading">
                <tr>
                    <td colspan="100" class="loader-height">
                        <Loader></Loader>
                    </td>
                </tr>
                </tbody>
                <tbody v-if="!tblData.loading && tblData.rows.length <= 0">
                <tr class="text-center">
                    <td colspan="100" class="fw-bold fs-6 text-height">
                        No Data Found
                        <br>
                        {{ tblData.noDataError }}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="row align-items-center">
            <div class="col-sm-12 col-md-5">
                <div class="d-flex align-items-center">
                    <div class="dataTables_length me-3" id="example_length">
                        <label class="table-filter fw-bold">Show
                            <select class="form-select form-select-sm ms-2 me-2" v-model="param.limit">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            entries
                        </label>
                    </div>
                    <div class="dataTables_info" id="example3_info" role="status" aria-live="polite"
                         v-if="tblData.paginateData != null">
                        Showing {{ tblData.paginateData.from }} to {{ tblData.paginateData.to }} of
                        {{ tblData.paginateData.total }} entries
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-7">
                <div class="dataTables_paginate paging_simple_numbers float-end" id="example_paginate">
                    <Bootstrap5Pagination :data="tblData.paginateData"
                                          @pagination-change-page="tblData.updatePagination"></Bootstrap5Pagination>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Loader from './Loader.vue'
import { Bootstrap5Pagination } from 'laravel-vue-pagination'

export default {
    name: 'Table',
    components: { Loader, Bootstrap5Pagination },
    props: ['tblData', 'param'],
    watch: {
        'param.keyword': function () {
            if (!this.tblData?.searchBtn) {
                this.tblData.updateFilter (this.param)
            }
        },
        'param.limit': function () {
            this.tblData.updateFilter (this.param)
        }
    },
    data () {
        return {
            selectedData: [],
            rowAction: null,
            date: ''
        }
    },
    methods: {
        isBtnShow: function (dataRow, btn) {
            if (this.tblData.row_action_disable !== undefined) {
                return this.tblData.row_action_disable({data: dataRow, btnName: btn})
            } else {
                return  true
            }
        },
        bgColor: function (status) {
            if (status === 'unpaid' || status === 'absent') {
                return 'bg-danger'
            } else if (status === 'paid' || status === 'present') {
                return 'bg-primary'
            } else if (status === 'partial paid' || status === 'late') {
                return 'bg-warning'
            } else {
                return ''
            }
        },
        onActionIconClick: function (rowAction, rowData, event) {
            event.stopPropagation ()
            if (this.tblData.tableIconAction !== undefined) {
                this.tblData.tableIconAction ({ row_action: rowAction, row_data: rowData })
            }
        },
        orderClass: function (order_by) {
            let cls
            if (this.param.order_by == order_by && this.param.order_mode == 'DESC') {
                cls = 'ordering_desc'
            } else if (this.param.order_by == order_by && this.param.order_mode == 'ASC') {
                cls = 'ordering_asc'
            } else {
                cls = 'ordering'
            }
            return cls
        },
        orderData: function (order_name) {
            this.param.order_by = order_name
            this.param.order_mode = this.param.order_mode == 'DESC' ? 'ASC' : 'DESC'
            this.tblData.updateFilter (this.param)
        },
        isChecked: function (id) {
            return this.selectedData.indexOf (id) > -1
        },
        toggleCheck: function (event, id) {
            if (event.target.checked == true) {
                this.selectedData.push (id)
            } else {
                this.selectedData.splice (this.selectedData.indexOf (id), 1)
            }
            event.stopPropagation ()
        },
        isCheckedAll: function () {
            if (this.selectedData.length === 0) {
                return false
            }
            return this.selectedData.length === this.tblData.rows.length
        },
        toggleCheckAll: function (event) {
            if (event.target.checked === true) {
                document.querySelectorAll ('.row-checkbox').forEach (value => {
                    value.checked = true
                })
                this.tblData.rows.map (v => {
                    if (this.dataExist (v.id) === false) {
                        this.selectedData.push (v.id)
                    }
                })
            } else {
                document.querySelectorAll ('.row-checkbox').forEach (value => {
                    value.checked = false
                })
                this.selectedData = []
            }
        },
        dataExist: function (id) {
            return this.selectedData.some (value => {
                return value === id
            })
        }
    }
}
</script>

<style scoped lang="scss">
table {
    thead {
        position: sticky;
        top: -1px;
        left: 0;
        width: 100%;
        background: #fff;
        z-index: 1;

        tr {
            th {

            }
        }
    }

    .order-list {
        li {
            &.enable-padding {
                padding: 10px 0;

                &:last-child {
                    padding-bottom: 4px;
                }
            }

            position: relative;

            .line {
                content: '';
                position: absolute;
                width: 100%;
                height: 1px;
                bottom: 0;
                left: 0;
                background-color: #d9d9d9;
            }

            &:last-child {
                .line {
                    content: '';
                    position: absolute;
                    width: 100%;
                    height: 1px;
                    bottom: 0;
                    left: 0;
                    background-color: transparent;
                }
            }
        }
    }

    .checkbox-center {
        width: 0;
        text-align: center;
    }

    .ordering {
        position: relative;

        &:before {
            right: 1em;
            content: "↑";
            position: absolute;
            bottom: 0.9em;
            display: block;
            opacity: .3;
        }

        &:after {
            right: 0.5em;
            content: "↓";
            position: absolute;
            bottom: 0.9em;
            display: block;
            opacity: .3;
        }
    }

    .ordering_asc {
        position: relative;

        &:before {
            right: 1em;
            content: "↑";
            position: absolute;
            bottom: 0.9em;
            display: block;
            opacity: 1;
        }

        &:after {
            right: 0.5em;
            content: "↓";
            position: absolute;
            bottom: 0.9em;
            display: block;
            opacity: .3;
        }
    }

    .ordering_desc {
        position: relative;

        &:before {
            right: 1em;
            content: "↑";
            position: absolute;
            bottom: 0.9em;
            display: block;
            opacity: .3;
        }

        &:after {
            right: 0.5em;
            content: "↓";
            position: absolute;
            bottom: 0.9em;
            display: block;
            opacity: 1;
        }
    }
}

.loader-height {
    padding-top: 10px;
}

.text-height {
    height: 250px;
    padding-top: 20px;
}

.table-filter {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 170px;
}

.search-filter {
    width: 250px;
}

.table-height {
    height: 71vh;
    overflow-x: hidden;
    overflow-y: auto;
    margin-bottom: 15px;
}

.table-control {
    max-width: 180px;
    min-width: 180px;
    padding: 0 2rem 0 0.8rem;
    font-size: 14px;
}

.btn-option {
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f9f9f9;
    border: 1px solid #cfcdcd;
    width: 31px;
    padding: 0;
    height: 31px;
    border-radius: 4px;
    transition: 500ms;

    &:hover {
        background-color: darken(#f9f9f9, 10%);
        transition: 500ms;
    }
}

.table-avatar {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    object-fit: fill;
    object-position: center;
    margin-right: 15px;
}
.table-image{
    width: 100px;
    height: 100px;
}

.no-list-style {
    list-style: none;
    padding-left: 0 !important;
}
</style>
