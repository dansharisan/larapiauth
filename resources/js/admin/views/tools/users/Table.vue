processingItem<template>
    <b-card :header="caption" header-class="text-left" class="text-center">
        <b-loading v-if="loadStatus==1"></b-loading>
        <div v-else-if="loadStatus == 2">
            <b-modal id="edit-form-modal" centered :title="isEdit ? 'Edit user' : 'Create user'" @ok="processItem" @hide="resetModal" ref="edit-form-modal" :key="editFormModal">
                <b-loading v-if="submitStatus == 1"></b-loading>
                <div v-else-if="submitStatus == 2">
                    <b-form-group>
                        <b-input-group v-if="isEdit">
                            <b-input-group-prepend>
                                <b-input-group-text><i class="fa fa-id-card-o pr-1"/> ID</b-input-group-text>
                            </b-input-group-prepend>
                            <b-form-input type="number" placeholder="ID" :disabled="true" :value="processingItem.id"/>
                        </b-input-group>
                    </b-form-group>
                    <b-form-group>
                        <b-input-group>
                            <b-input-group-prepend>
                                <b-input-group-text><i class="fa fa-envelope-o pr-1" />Email</b-input-group-text>
                            </b-input-group-prepend>
                            <b-form-input type="email" placeholder="Email" :disabled="true" :value="processingItem.email" v-if="isEdit"/>
                            <b-form-input type="email" placeholder="Email" @change="$v.form.$touch()" :state="$v.form.email | state" v-model="form.email" v-else/>
                        </b-input-group>
                        <div class="row">
                            <div class="col-3 d-block">
                            </div>
                            <div class="col-9 invalid-feedback text-left d-block" v-if="$v.form.email.$invalid">
                                {{ "Please input valid email." }}
                            </div>
                        </div>
                    </b-form-group>
                    <b-form-group v-if="!isEdit">
                        <b-input-group>
                            <b-input-group-prepend>
                                <b-input-group-text><i class="fa fa-key pr-1" />Password</b-input-group-text>
                            </b-input-group-prepend>
                            <b-form-input type="password" placeholder="Password" @change="$v.form.$touch()" :state="$v.form.password | state" v-model="form.password"/>
                        </b-input-group>
                        <div class="row">
                            <div class="col-3 d-block">
                            </div>
                            <div class="col-9 invalid-feedback text-left d-block" v-if="$v.form.password.$invalid">
                                {{ "Please input password." }}
                            </div>
                        </div>
                    </b-form-group>
                    <b-form-group>
                        <b-input-group>
                            <b-input-group-prepend>
                                <b-input-group-text><i class="fa fa-check-square-o pr-1" />Verified at</b-input-group-text>
                            </b-input-group-prepend>
                            <b-datepicker v-model="form.email_verified_at" v-if="isEdit"/>
                            <b-datepicker v-model="form.email_verified_at" @change="$v.form.email_verified_at.$touch()" v-else/>
                        </b-input-group>
                        <div class="row">
                            <div class="col-3 d-block">
                            </div>
                            <div class="col-9 invalid-feedback text-left d-block" v-if="$v.form.email_verified_at.$invalid">
                                {{ "Please select email verified date." }}
                            </div>
                        </div>
                    </b-form-group>
                    <b-form-group
                    :label-cols="3"
                    label="Roles"
                    label-for="basicCustomCheckboxes"
                    >
                        <b-form-checkbox-group id="roles-checkboxes" stacked>
                            <div class="text-left custom-control custom-checkbox">
                                <input
                                  id="role-1-checkbox"
                                  type="checkbox"
                                  class="custom-control-input"
                                  value="1"
                                  :checked="processingItem.roleIdArr ? processingItem.roleIdArr.includes(1) : false"
                                  @change="setRole1Checkbox($event.target.value)"
                                >
                                <label class="custom-control-label" for="role-1-checkbox">
                                  Member
                                </label>
                              </div>
                              <div class="text-left custom-control custom-checkbox">
                                <input
                                    id="role-2-checkbox"
                                    type="checkbox"
                                    class="custom-control-input"
                                    value="2"
                                    :checked="processingItem.roleIdArr ? processingItem.roleIdArr.includes(2) : false"
                                    @change="setRole2Checkbox($event.target.value)"
                                >
                                <label class="custom-control-label" for="role-2-checkbox">
                                  Moderator
                                </label>
                              </div>
                              <div class="text-left custom-control custom-checkbox">
                                  <input
                                      id="role-3-checkbox"
                                      type="checkbox"
                                      class="custom-control-input"
                                      value="3"
                                      :checked="processingItem.roleIdArr ? processingItem.roleIdArr.includes(3) : false"
                                      @change="setRole3Checkbox($event.target.value)"
                                  >
                                <label class="custom-control-label" for="role-3-checkbox">
                                  Administrator
                                </label>
                              </div>
                          </b-form-checkbox-group>
                          <div class="invalid-feedback d-block text-left col-9" v-if="$v.form.role1.$invalid && $v.form.role2.$invalid && $v.form.role3.$invalid">
                              {{ "Please select at least one role." }}
                          </div>
                      </b-form-group>
                  </div>
                  <p v-else class="text-center mb-0">Data submit error.</p>
            </b-modal>
            <div class="row justify-content-between">
                <div class="col-4">
                    <b-input-group class="mb-3 input-group-sm">
                      <b-form-select
                        @input="onChangePerPage"
                        v-model="perPage"
                        id="per_page"
                        :plain="false"
                        :options="[{ text: '15', value: 15}, { text: '30', value: 30}, { text: '50', value: 50}]"
                        size="xs"
                        value="Please select"
                        class="col-2"
                      />
                      <b-input-group-append>
                          <b-input-group-text>items per page</b-input-group-text>
                      </b-input-group-append>
                    </b-input-group>
                </div>
                <div class="col-2 text-right">
                    <b-button size="sm" class="btn-action" variant="danger" @click="deleteItems()" v-if="hasChecked">
                        <i class="fa fa-remove text-white" aria-hidden="true"></i> <span class="text-white">Delete</span>
                    </b-button>
                    <b-button size="sm" class="btn-action" variant="primary" @click="prepareCreatingItem()" v-b-modal.edit-form-modal>
                        <i class="fa fa-file-o text-white" aria-hidden="true"></i> <span class="text-white">Create</span>
                    </b-button>
                </div>
            </div>

            <b-table
            :hover="hover"
            :striped="striped"
            :bordered="bordered"
            :small="small"
            :fixed="fixed"
            :items="tableData.data"
            :fields="fields"
            :current-page="currentPage"
            per-page=0
            responsive="sm"
            >
                <template slot="checkbox" slot-scope="row">
                    <b-form-checkbox
                      :id="'checkbox-item-' + row.item.id"
                      :name="'checkbox-item-' + row.item.id"
                      :data-id="row.item.id"
                      class="checkbox-item"
                      @input="selectItem(row.item)"
                      value="checked"
                      unchecked-value="unchecked"
                    >
                    </b-form-checkbox>
                </template>
                <template slot="status" slot-scope="row" v-if="tableData.data.length > 0 && tableData.data[0].status">
                    <b-badge :variant="getBadge(row.item.status)">
                        {{ row.item.status }}
                    </b-badge>
                </template>
                <template slot="actions" slot-scope="row">
                    <b-button size="sm" class="btn-action" variant="warning" @click="prepareEditingItem(row.item)" v-b-modal.edit-form-modal>
                        <i class="fa fa-pencil-square-o text-white" aria-hidden="true"></i> <span class="text-white">Edit</span>
                    </b-button>
                    <b-button size="sm" class="btn-action" variant="danger" @click="deleteItem(row.item)">
                        <i class="fa fa-trash-o text-white" aria-hidden="true"></i> <span class="text-white">Delete</span>
                    </b-button>
                    <b-button size="sm" class="btn-action" variant="success" @click="unbanItem(row.item)" v-if="row.item.status == 'Banned'">
                        <i class="fa fa-unlock text-white" aria-hidden="true"></i> <span class="text-white">Unban</span>
                    </b-button>
                    <b-button size="sm" class="btn-action" variant="danger" @click="banItem(row.item)" v-if="row.item.status != 'Banned'">
                        <i class="fa fa-lock text-white" aria-hidden="true"></i> <span class="text-white">Ban</span>
                    </b-button>
                </template>
            </b-table>
        </div>
        <p v-else class="text-center mb-0">Data load error.</p>
        <nav v-if="loadStatus == 2">
            <b-pagination
            v-model="currentPage"
            :total-rows="tableData.total"
            :per-page="tableData.per_page"
            prev-text="Prev"
            next-text="Next"
            hide-goto-end-buttons
            class="mb-0"
            size="sm"
            >
            </b-pagination>
        </nav>
    </b-card>
</template>

<script>
import { sameAs, required, email } from 'validators'

export default {
    name : 'cTable',
    props: {
        caption: {
            type   : String,
            default: 'Table',
        },
        hover: {
            type   : Boolean,
            default: false,
        },
        striped: {
            type   : Boolean,
            default: false,
        },
        bordered: {
            type   : Boolean,
            default: false,
        },
        small: {
            type   : Boolean,
            default: false,
        },
        fixed: {
            type   : Boolean,
            default: false,
        },
        tableData: {
            type : Object,
            default: {},
        },
        fields: {
            type : Array,
            default: [],
        },
        loadStatus: {
            type: Number,
            default: 0
        },
        submitStatus: {
            type: Number,
            default: 2
        }
    },
    validations () {
        return {
            form: {
                role1: { sameAs: sameAs( () => true ) },
                role2: { sameAs: sameAs( () => true ) },
                role3: { sameAs: sameAs( () => true ) },
                email: { required, email },
                email_verified_at: { required },
                password: { required },
            },
        }
    },
    data: () => {
        return {
            currentPage: 1,
            perPage: window.localStorage.getItem('per_page') || 15,
            hasChecked: false,
            isEdit: false,
            processingItem: {},
            form: {
                role1: '',
                role2: '',
                role3: '',
                email: '',
                email_verified_at: null,
                password: ''

            },
            editFormModal: 0
        }
    },
    methods: {
        resetModal() {
            this.form = {
                role1: '',
                role2: '',
                role3: '',
                email: '',
                email_verified_at: null,
                password: ''
            }

            this.processingItem = {}
        },
        setRole1Checkbox(value) {
            this.form.role1 = $('#role-1-checkbox').prop("checked")
            this.$v.form.role1.$touch()
        },
        setRole2Checkbox(value) {
            this.form.role2 = $('#role-2-checkbox').prop("checked")
            this.$v.form.role2.$touch()
        },
        setRole3Checkbox(value) {
            this.form.role3 = $('#role-3-checkbox').prop("checked")
            this.$v.form.role3.$touch()
        },
        selectItem (item) {
            if ($('table .checkbox-item input').filter(':checked').length > 0) {
                this.hasChecked = true
            } else {
                this.hasChecked = false
            }
        },
        prepareCreatingItem () {
            // Let modal know this is create action
            this.isEdit = false;
            this.submitStatus = 2
        },
        prepareEditingItem (item) {
            // Let modal know this is edit action
            this.isEdit = true;
            this.submitStatus = 2
            this.forceRerender()
            this.processingItem = item
            this.processingItem.roleIdArr = item.roles.map(role => role.id);
            this.form.role1 = this.processingItem.roleIdArr.includes(1)
            this.form.role2 = this.processingItem.roleIdArr.includes(2)
            this.form.role3 = this.processingItem.roleIdArr.includes(3)
            this.form.email_verified_at = this.processingItem.email_verified_at
        },
        processItem (bvModalEvt) {
            // Prevent modal from closing
            bvModalEvt.preventDefault()

            // Check for data validity
            this.$v.$touch()
            if (this.$v.form.role1.$invalid && this.$v.form.role2.$invalid && this.$v.form.role3.$invalid) {
                return;
            }

            // Decide which logic to do
            if (this.isEdit) {
                this.editItem();
            } else {
                this.createItem();
            }
        },
        createItem () {
            var vm = this
            // Check for data validity
            this.$v.$touch()
            if (this.$v.form.email_verified_at.$invalid || this.$v.form.email.$invalid || this.$v.form.password.$invalid || (this.$v.form.role1.$invalid && this.$v.form.role2.$invalid && this.$v.form.role3.$invalid)) {
                return;
            }
            // Prepare data
            let roleIdsSeq = ''
            if ($('#role-1-checkbox').prop("checked")){
                roleIdsSeq += '1,'
            }
            if ($('#role-2-checkbox').prop("checked")){
                roleIdsSeq += '2,'
            }
            if ($('#role-3-checkbox').prop("checked")){
                roleIdsSeq += '3,'
            }
            vm.processingItem.role_ids = roleIdsSeq
            // Broadcast edit_item event
            vm.$emit('create_item', vm.processingItem, this.currentPage, this.perPage)
        },
        editItem () {
            var vm = this
            // Prepare data
            let roleIdsSeq = ''
            if ($('#role-1-checkbox').prop("checked")){
                roleIdsSeq += '1,'
            }
            if ($('#role-2-checkbox').prop("checked")){
                roleIdsSeq += '2,'
            }
            if ($('#role-3-checkbox').prop("checked")){
                roleIdsSeq += '3,'
            }
            vm.processingItem.role_ids = roleIdsSeq
            vm.processingItem.email_verified_at = this.form.email_verified_at

            // Broadcast edit_item event
            vm.$emit('edit_item', vm.processingItem, this.currentPage, this.perPage)
        },
        deleteItem (item) {
            var vm = this
            this.$swal({
                title: 'You sure to delete this item?',
                text: "This is a soft delete mechanism. After deleting, data will no longer show here but still be remained in DB.",
                type: 'warning',
                showCancelButton: true,
                reverseButtons: true,
                confirmButtonColor: '#f86c6b',
                cancelButtonColor: '#a4b7c1',
                confirmButtonText: 'Delete'
            }).then((result) => {
                if (result.value) {
                    vm.$emit('delete_item', item.id, this.currentPage, this.perPage)
                }
            })
        },
        deleteItems () {
            var vm = this
            this.$swal({
                title: 'You sure to delete these items?',
                text: "This is a soft delete mechanism. After deleting, data will no longer show here but still be remained in DB.",
                type: 'warning',
                showCancelButton: true,
                reverseButtons: true,
                confirmButtonColor: '#f86c6b',
                cancelButtonColor: '#a4b7c1',
                confirmButtonText: 'Delete'
            }).then((result) => {
                if (result.value) {
                    // Gather items' ids
                    var itemIds = [];
                    $('table .checkbox-item input').filter(':checked').each(function (index) {
                        let id = $(this).parent('div').data('id');
                        itemIds.push(id)
                    })
                    let itemIdsSeq = itemIds.join(',')

                    vm.$emit('delete_items', itemIdsSeq, this.currentPage, this.perPage)
                }
            })

        },
        banItem (item) {
            var vm = this
            this.$swal({
                title: 'You sure to ban this user?',
                text: "Banned users will not be able to login until you unban them.",
                type: 'warning',
                showCancelButton: true,
                reverseButtons: true,
                confirmButtonColor: '#f86c6b',
                cancelButtonColor: '#a4b7c1',
                confirmButtonText: 'Yes, ban him/her!'
            }).then((result) => {
                if (result.value) {
                    vm.$emit('ban_item', item.id, this.currentPage, this.perPage)
                }
            })
        },
        unbanItem (item) {
            var vm = this
            this.$swal({
                title: 'You sure to unban this user?',
                text: "This user will be able to login again after being unbanned.",
                type: 'info',
                showCancelButton: true,
                reverseButtons: true,
                confirmButtonColor: '#4dbd74',
                cancelButtonColor: '#a4b7c1',
                confirmButtonText: 'Yes, unban him/her.'
            }).then((result) => {
                if (result.value) {
                    vm.$emit('unban_item', item.id, this.currentPage, this.perPage)
                }
            })
        },
        getBadge (status) {
            return status === 'Active' ? 'success'
            : status === 'Inactive' ? 'secondary'
            : status === 'Banned' ? 'danger' : 'primary'
        },
        onChangePerPage (newPerPage) {
            // Remember user's preference for per_page
            window.localStorage.setItem('per_page', newPerPage)
        },
        forceRerender() {
            this.editFormModal += 1;
        }
    },
    mounted() {
        // Hide the modal when finish submitting
        if (this.loadStatus == 2) {
            this.$refs["edit-form-modal"].hide()
        }
    },
    watch: {
        currentPage: function (newVal, oldVal) {
            // Request to change data, but not on the first load
            if (oldVal) {
                this.$emit('page_changed', newVal, this.perPage)
            }
        },
        perPage: function (newVal, oldVal) {
            // Request to change data, but not on the first load
            if (oldVal) {
                this.$emit('per_page_changed', newVal)
            }
        },
    },
}
</script>
