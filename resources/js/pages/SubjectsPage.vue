<template>
  <el-container direction="vertical">
    <el-row class="mb-20">
      <el-col :span="12" class="text-header">
        Subjects
      </el-col>
      <el-col :span="12">
        <el-row type="flex" justify="end">
          <el-col :span="18">
            <el-input
              v-model="params.name"
              size="small"
              placeholder="Type to search"/>
          </el-col>
          <el-col :span="6" class="text-align-right">
            <el-button type="success" icon="el-icon-plus" size="small" @click="showCreateDialog()">Create</el-button>
          </el-col>
        </el-row>
      </el-col>
    </el-row>
    <CreateSubjectDialog :visible="createDialogVisible"
                         @save="storeSubject"
                         @close="createDialogVisible = false"/>
    <EditSubjectDialog :subject="editDialogSubject"
                       :visible="editDialogVisible"
                       @save="updateSubject"
                       @close="editDialogVisible = false"/>
    <DeleteDialog :message="'Do you really want to delete a subject with id #' + deleteDialogSubject.id"
                  :itemName="'Subject'"
                  :item="deleteDialogSubject"
                  :visible="deleteDialogVisible"
                  @confirm="deleteSubject"
                  @close="deleteDialogVisible = false"/>
    <SubjectsList :subjects="subjects"
                  @showEditDialog="showEditDialog"
                  @showDeleteDialog="showDeleteDialog"/>
    <el-row type="flex" justify="end">
      <el-pagination
        @size-change="getSubjects"
        @current-change="getSubjects"
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
import CreateSubjectDialog from "../components/subjects/CreateSubjectDialog.vue"
import EditSubjectDialog from "../components/subjects/EditSubjectDialog.vue"
import SubjectsList from "../components/subjects/SubjectsList.vue"
import DeleteDialog from "../components/DeleteDialog.vue"
import SubjectService from "../services/SubjectService"

const subjectService = new SubjectService()

export default {
  name: "SubjectsPage",
  components: {CreateSubjectDialog, DeleteDialog, EditSubjectDialog, SubjectsList},
  data() {
    return {
      total: 0,
      subjects: [],
      createDialogVisible: false,
      editDialogVisible: false,
      editDialogSubject: {id: 0},
      deleteDialogVisible: false,
      deleteDialogSubject: {id: 0},
      params: {
        size: 10,
        page: 1,
        name: ''
      },
      timeout: null
    }
  },
  mounted() {
    this.getSubjects()
  },
  watch: {
    params: {
      handler() {
        clearTimeout(this.timeout)
        this.timeout = setTimeout(() => {
          this.getSubjects(this.name)
        }, 500)
      },
      deep: true
    }
  },
  methods: {
    getSubjects() {
      subjectService.get(this.params)
        .then(response => {
          this.subjects = response.data
          this.total = response.total
        })
        .catch(() => {
          this.subjects = []
        })
    },
    showCreateDialog() {
      this.createDialogVisible = true
    },
    showEditDialog(subject) {
      this.editDialogSubject = subject
      this.editDialogVisible = true
    },
    showDeleteDialog(subject) {
      this.deleteDialogSubject = subject
      this.deleteDialogVisible = true
    },
    storeSubject(subject) {
      subjectService.store(subject)
        .then(() => {
          this.$message({
            message: 'Subject has successfully been created',
            type: 'success'
          })
          this.createDialogVisible = false
          this.getSubjects()
        })
    },
    updateSubject(subject) {
      subjectService.update(subject)
        .then(() => {
          this.$message({
            message: 'Subject has successfully been updated',
            type: 'success'
          })
          this.editDialogVisible = false
          this.getSubjects()
        })
    },
    deleteSubject(id) {
      subjectService.delete(id)
        .then(() => {
          this.$message({
            message: 'Subject has successfully been deleted',
            type: 'success'
          })
          this.getSubjects()
        })
      this.deleteDialogVisible = false
    }
  }
}
</script>

<style scoped>

</style>
