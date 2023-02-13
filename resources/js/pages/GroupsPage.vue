<template>
  <el-container direction="vertical">
    <el-row class="mb-20">
      <el-col :span="12" class="text-header">
        Groups
      </el-col>
      <el-col :span="12">
        <el-row type="flex" justify="end">
          <el-col :span="18">
            <el-input
              v-model="params.label"
              size="small"
              placeholder="Type to search"/>
          </el-col>
          <el-col :span="6" class="text-align-right">
            <el-button type="success" icon="el-icon-plus" size="small" @click="showCreateDialog()">Create</el-button>
          </el-col>
        </el-row>
      </el-col>
    </el-row>
    <CreateGroupDialog :visible="createDialogVisible"
                         @save="storeGroup"
                         @close="createDialogVisible = false"/>
    <EditGroupDialog :group="editDialogGroup"
                       :visible="editDialogVisible"
                       @save="updateGroup"
                       @close="editDialogVisible = false"/>
    <DeleteDialog :message="'Do you really want to delete a group with id #' + deleteDialogGroup.id"
                  :itemName="'Group'"
                  :item="deleteDialogGroup"
                  :visible="deleteDialogVisible"
                  @confirm="deleteGroup"
                  @close="deleteDialogVisible = false"/>
    <GroupsList :groups="groups"
                  @showEditDialog="showEditDialog"
                  @showDeleteDialog="showDeleteDialog"/>
    <el-row type="flex" justify="end">
      <el-pagination
        @size-change="getGroups"
        @current-change="getGroups"
        :current-page.sync="params.page"
        :page-sizes="[10, 20, 30, 40, 50, 100]"
        :page-size.sync="params.size"
        layout="total, sizes, prev, pager, next, jumper"
        :total="total">
      </el-pagination>
    </el-row>
  </el-container>
</template>

<script>
import CreateGroupDialog from "../components/groups/CreateGroupDialog.vue"
import EditGroupDialog from "../components/groups/EditGroupDialog.vue"
import GroupsList from "../components/groups/GroupsList.vue"
import DeleteDialog from "../components/DeleteDialog.vue"
import GroupService from "../services/GroupService"

const groupService = new GroupService()

export default {
  name: "GroupsPage",
  components: {CreateGroupDialog, DeleteDialog, EditGroupDialog, GroupsList},
  data() {
    return {
      total: 0,
      groups: [],
      createDialogVisible: false,
      editDialogVisible: false,
      editDialogGroup: {id: 0},
      deleteDialogVisible: false,
      deleteDialogGroup: {id: 0},
      params: {
        size: 10,
        page: 1,
        label: ''
      },
      timeout: null
    }
  },
  mounted() {
    this.getGroups()
  },
  watch: {
    params: {
      handler() {
        clearTimeout(this.timeout)
        this.timeout = setTimeout(() => {
          this.getGroups()
        }, 500)
      },
      deep: true
    }
  },
  methods: {
    getGroups() {
      groupService.get(this.params)
        .then(response => {
          this.groups = response.data
          this.total = response.total
        })
        .catch(() => {
          this.groups = []
        })
    },
    showCreateDialog() {
      this.createDialogVisible = true
    },
    showEditDialog(group) {
      this.editDialogGroup = group
      this.editDialogVisible = true
    },
    showDeleteDialog(group) {
      this.deleteDialogGroup = group
      this.deleteDialogVisible = true
    },
    storeGroup(group) {
      groupService.store(group)
        .then(() => {
          this.$message({
            message: 'Group has successfully been created',
            type: 'success'
          })
          this.createDialogVisible = false
          this.getGroups()
        })
    },
    updateGroup(group) {
      groupService.update(group)
        .then(() => {
          this.$message({
            message: 'Group has successfully been updated',
            type: 'success'
          })
          this.editDialogVisible = false
          this.getGroups()
        })
    },
    deleteGroup(id) {
      groupService.delete(id)
        .then(() => {
          this.$message({
            message: 'Group has successfully been deleted',
            type: 'success'
          })
          this.getGroups()
        })
      this.deleteDialogVisible = false
    }
  }
}
</script>

<style scoped>

</style>
