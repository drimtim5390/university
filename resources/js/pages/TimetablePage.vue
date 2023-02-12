<template>
  <el-container direction="vertical">
    <el-row type="flex" justify="between" class="mb-20">
      <el-col :span="12" class="text-header">
        Timetable
      </el-col>
      <el-col class="text-align-right">
        <el-button type="success" icon="el-icon-plus" size="small" @click="showCreateDialog()">Create</el-button>
      </el-col>
    </el-row>
    <CreateLessonDialog :lesson="createDialogLesson"
                        :visible="createDialogVisible"
                        @save="storeLesson"
                        @close="createDialogVisible = false"/>
    <EditLessonDialog :lesson="editDialogLesson"
                      :visible="editDialogVisible"
                      @save="updateLesson"
                      @close="editDialogVisible = false"/>
    <TimetableList :timetable="timetable"
                   @showCreateDialog="showCreateDialog"
                   @showEditDialog="showEditDialog"
                   @showDeleteDialog="showDeleteDialog"/>
    <DeleteDialog :message="'Do you really want to delete a lesson with id #' + deleteDialogLesson.id"
                  :itemName="'Lesson'"
                  :item="deleteDialogLesson"
                  :visible="deleteDialogVisible"
                  @confirm="deleteLesson"
                  @close="deleteDialogVisible = false"/>
  </el-container>
</template>

<script>
import CreateLessonDialog from "../components/lessons/CreateLessonDialog.vue"
import TimetableList from "../components/lessons/TimetableList.vue"
import EditLessonDialog from "../components/lessons/EditLessonDialog.vue"
import DeleteDialog from "../components/DeleteDialog.vue"

export default {
  name: "TimetablePage",
  components: {DeleteDialog, CreateLessonDialog, EditLessonDialog, TimetableList},
  data() {
    return {
      timetable: [],
      createDialogVisible: false,
      createDialogLesson: {id: 0},
      editDialogVisible: false,
      editDialogLesson: {id: 0},
      deleteDialogVisible: false,
      deleteDialogLesson: {id: 0}
    }
  },
  mounted() {
    this.getTimetable()
  },
  methods: {
    async getTimetable() {
      await this.axios.get('/api/lessons/timetable')
        .then(response => {
          this.timetable = response.data
        })
        .catch(() => {
          this.timetable = []
        })
    },
    showCreateDialog(lesson = null) {
      this.createDialogLesson = lesson
      this.createDialogVisible = true
    },
    showEditDialog(lesson) {
      console.log(lesson)
      this.editDialogLesson = lesson
      this.editDialogVisible = true
    },
    showDeleteDialog(lesson) {
      this.deleteDialogLesson = lesson
      this.deleteDialogVisible = true
    },
    storeLesson(lesson) {
      this.axios.post('/api/lessons', lesson)
        .then(() => {
          this.$message({
            message: 'Lesson has successfully been created',
            type: 'success'
          })
          this.createDialogVisible = false
          this.getTimetable()
        })
    },
    updateLesson(lesson) {
      this.axios.put(`/api/lessons/${lesson.id}`, lesson)
        .then(() => {
          this.$message({
            message: 'Lesson has successfully been updated',
            type: 'success'
          })
          this.editDialogVisible = false
          this.getTimetable()
        })
    },
    deleteLesson(id) {
      this.axios.delete(`/api/lessons/${id}`)
        .then(() => {
          this.$message({
            message: 'Lesson has successfully been deleted',
            type: 'success'
          })
          this.getTimetable()
        })
      this.deleteDialogVisible = false
    }

  }
}
</script>

<style scoped>

</style>
