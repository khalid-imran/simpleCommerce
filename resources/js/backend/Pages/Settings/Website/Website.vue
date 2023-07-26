<template>
    <div>
        <Breadcrumb section-name="Settings" :breadcrumb="breadCrumb"></Breadcrumb>
        <div class="col-12">
            <div class="card mb-0">
                <div class="card-body" :class="{'data-loading': dataLoading}">
                   <div class="row">
                       <div class="col-sm-12">
                           <form @submit.prevent="manage">
                               <div class="fixed-card-height">
                                   <div class="card border-top border-0 border-4 border-primary">
                                       <div class="card-body p-4">
                                           <div class="card-title d-flex align-items-center">
                                               <h5 class="mb-0 text-primary">Website Settings</h5>
                                           </div>
                                           <hr>
                                           <div class="row">
                                               <div class="col-sm-6 mb-3 form-group">
                                                   <label class="form-label">Date<span class="text-danger">*</span></label>
                                                   <flat-pickr class="form-control" v-model="addEditParam.date" name="date"
                                                               :config="{dateFormat: 'Y-m-d', altInput: true, altFormat:'d/m/Y'}"/>
                                                   <small class="invalid-feedback text-danger"></small>
                                               </div>
                                               <div class="col-sm-6 mb-3 form-group">
                                                   <label class="form-label">Accounts Category</label>
                                                   <select class="form-select" v-model="addEditParam.category_id" name="category_id">
                                                       <option v-for="c in categories" :value="c.id">{{ c.name }}</option>
                                                   </select>
                                               </div>
                                               <div class="col-sm-6 mb-3 form-group">
                                                   <label class="form-label">Collection By<span class="text-danger">*</span></label>
                                                   <multiselect name="member_id" v-model="member"  track-by="id" label="name" :options="members" :multiple="false"></multiselect>
                                                   <small class="invalid-feedback text-danger"></small>
                                               </div>
                                               <div class="col-sm-6 mb-3 form-group">
                                                   <label class="form-label">Payment Method<span class="text-danger">*</span></label>
                                                   <select class="form-select" v-model="addEditParam.payment_method" name="payment_method">
                                                       <option value="bank">Bank</option>
                                                       <option value="bkash">Bkash</option>
                                                       <option value="nagad">Nagad</option>
                                                       <option value="others">Others</option>
                                                   </select>
                                                   <small class="invalid-feedback text-danger"></small>
                                               </div>
                                               <div class="col-sm-6 mb-3 form-group" v-if="addEditParam.payment_method == 'bank'">
                                                   <label class="form-label">Bank Name</label>
                                                   <select class="form-select" v-model="addEditParam.bank_id" name="bank_id">
                                                       <option v-for="b in banks" :value="b.id">{{ b.name }}</option>
                                                   </select>
                                                   <small class="invalid-feedback text-danger"></small>
                                               </div>
                                               <div class="col-md-6 mb-3 form-group" v-if="addEditParam.payment_method == 'bank'">
                                                   <label class="form-label">Bank Account Number</label>
                                                   <input type="text" class="form-control" name="account_number" v-model="addEditParam.account_number">
                                                   <small class="invalid-feedback text-danger"></small>
                                               </div>

                                               <div class="col-sm-6 mb-3 form-group">
                                                   <label class="form-label">Accounts Head</label>
                                                   <select class="form-select" v-model="addEditParam.account_head_id" name="account_head_id">
                                                       <option v-for="a in accountHeads" :value="a.id">{{ a.name }}</option>
                                                   </select>
                                                   <small class="invalid-feedback text-danger"></small>
                                               </div>

                                               <div class="col-md-6 form-group">
                                                   <label class="form-label">Amount<span class="text-danger">*</span></label>
                                                   <input type="text" class="form-control" name="amount" v-model="addEditParam.amount">
                                                   <small class="invalid-feedback text-danger"></small>
                                               </div>
                                               <div class="col-sm-6 mb-3 form-group">
                                                   <label class="form-label">Approved By</label>
                                                   <multiselect  name="approved_by" v-model="approve_by" track-by="id" label="name"  :options="members" :multiple="true"></multiselect>
                                                   <small class="invalid-feedback text-danger"></small>
                                               </div>
                                               <div class="col-md-6 mb-3 form-group">
                                                   <label class="form-label">Remarks</label>
                                                   <input type="text" class="form-control" name="remarks" v-model="addEditParam.remarks">
                                                   <small class="invalid-feedback text-danger"></small>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                               <div class="text-end">
                                   <router-link :to="{name: 'income'}" type="button" class="btn btn-secondary me-2 btn-width" >Close</router-link>
                                   <button type="submit" class="btn btn-primary btn-width" v-if="!loading">
                                       Save
                                   </button>
                                   <button type="button" class="btn btn-primary btn-width" v-if="loading">
                                       <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                   </button>
                               </div>
                           </form>
                       </div>
                   </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Breadcrumb from "../../Common/Breadcrumb";
import ApiService from "../../../Services/ApiService";
import ApiRoutes from "../../../Services/ApiRoutes";
import app from "../../../App.vue";
export default {
    computed: {
        app() {
            return app
        }
    },
    components: {Breadcrumb},
    data() {
        return {
            breadCrumb: ['Website'],
            loading: false,
            dataLoading: false,
            addEditParam: {
                date: '',
                category_id: '',
                member_id: '',
                account_head_id: '',
                payment_method: '',
                bank_id: '',
                account_number: '',
                amount: '',
                approved_by: [],
                remarks: '',
            },
        }
    },
    methods: {
        getSingle: function () {
            this.dataLoading = true
            ApiService.POST(ApiRoutes.ListBank, (res) => {
                if (parseInt(res.status) === 200) {
                    this.addEditParam = res.data
                }
            });
        },
        manage: function () {
            ApiService.ClearErrorHandler();
            this.loading = true;
            ApiService.POST(ApiRoutes.AddIncome, this.addEditParam, (res) => {
                this.loading = false;
                if (parseInt(res.status) === 200) {
                } else {
                    ApiService.ErrorHandler(res.errors);
                }
            });
        },
    },
    mounted () {
    },
    created() {
        this.getSingle()
    }
}
</script>

<style scoped>

</style>
