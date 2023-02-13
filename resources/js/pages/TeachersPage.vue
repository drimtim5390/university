<template>
  <el-container direction="vertical">
    <el-row class="mb-20">
      <el-col :span="12" class="text-header">
        Teachers
      </el-col>
      <el-col :span="12">
        <el-row type="flex" justify="end">
          <el-col :span="18">
            <el-input
              v-model="params.full_name"
              size="small"
              placeholder="Type to search"/>
          </el-col>
          <el-col :span="6" class="text-align-right">
            <el-button type="success" icon="el-icon-plus" size="small" @click="showCreateDialog()">Create</el-button>
          </el-col>
        </el-row>
      </el-col>
    </el-row>
    <CreateTeacherDialog :visible="createDialogVisible"
                         @save="storeTeacher"
                         @close="createDialogVisible = false"/>
    <EditTeacherDialog :teacher="editDialogTeacher"
                       :visible="editDialogVisible"
                       @save="updateTeacher"
                       @close="editDialogVisible = false"/>
    <DeleteDialog :message="'Do you really want to delete a teacher with id #' + deleteDialogTeacher.id"
                  :itemName="'Teacher'"
                  :item="deleteDialogTeacher"
                  :visible="deleteDialogVisible"
                  @confirm="deleteTeacher"
                  @close="deleteDialogVisible = false"/>
    <TeachersList :teachers="teachers"
                  @showEditDialog="showEditDialog"
                  @showDeleteDialog="showDeleteDialog"/>
    <el-row type="flex" justify="end">
      <el-pagination
        @size-change="getTeachers"
        @current-change="getTeachers"
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
import CreateTeacherDialog from "../components/teachers/CreateTeacherDialog.vue"
import EditTeacherDialog from "../components/teachers/EditTeacherDialog.vue"
import TeachersList from "../components/teachers/TeachersList.vue"
import DeleteDialog from "../components/DeleteDialog.vue"
import TeacherService from "../services/TeacherService"

const teacherService = new TeacherService()

export default {
  name: "TeachersPage",
  components: {CreateTeacherDialog, DeleteDialog, EditTeacherDialog, TeachersList},
  data() {
    return {
      total: 0,
      teachers: [],
      createDialogVisible: false,
      editDialogVisible: false,
      editDialogTeacher: {id: 0},
      deleteDialogVisible: false,
      deleteDialogTeacher: {id: 0},
      params: {
        size: 10,
        page: 1,
        full_name: ''
      },
      timeout: null
    }
  },
  mounted() {
    this.getTeachers()
  },
  watch: {
    params: {
      handler() {
        clearTimeout(this.timeout)
        this.timeout = setTimeout(() => {
          this.getTeachers()
        }, 500)
      },
      deep: true
    }
  },
  methods: {
    getTeachers() {
      teacherService.get(this.params)
        .then(response => {
          this.teachers = response.data
          this.total = response.total
        })
        .catch(() => {
          this.teachers = []
        })
    },
    showCreateDialog() {
      this.createDialogVisible = true
    },
    showEditDialog(teacher) {
      this.editDialogTeacher = teacher
      this.editDialogVisible = true
    },
    showDeleteDialog(teacher) {
      this.deleteDialogTeacher = teacher
      this.deleteDialogVisible = true
    },
    storeTeacher(teacher) {
      teacherService.store(teacher)
        .then(() => {
          this.$message({
            message: 'Teacher has successfully been created',
            type: 'success'
          })
          this.createDialogVisible = false
          this.getTeachers()
        })
    },
    updateTeacher(teacher) {
      teacherService.update(teacher)
        .then(() => {
          this.$message({
            message: 'Teacher has successfully been updated',
            type: 'success'
          })
          this.editDialogVisible = false
          this.getTeachers()
        })
    },
    deleteTeacher(id) {
      teacherService.delete(id)
        .then(() => {
          this.$message({
            message: 'Teacher has successfully been deleted',
            type: 'success'
          })
          this.getTeachers()
        })
      this.deleteDialogVisible = false
    }
  }
}
</script>

<style scoped>

</style>
