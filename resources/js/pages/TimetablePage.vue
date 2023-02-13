<template>
  <el-container direction="vertical">
    <el-row type="flex" justify="between" class="mb-20">
      <el-col :span="3" class="text-header">
        Timetable
      </el-col>
      <el-col>
        <el-date-picker
          v-model="filter.daterange"
          type="daterange"
          align="right"
          unlink-panels
          range-separator="To"
          start-placeholder="Start date"
          end-placeholder="End date"
          :picker-options="datePickerOptions"
          value-format="yyyy-MM-dd">
        </el-date-picker>
        <el-select
          v-model="filter.group_ids"
          multiple
          collapse-tags
          style="margin-left: 20px;"
          placeholder="Select group">
          <el-option
            v-for="group in this.relationships.groups"
            :key="group.id"
            :label="group.label"
            :value="group.id">
          </el-option>
        </el-select>
        <el-select
          v-model="filter.room_ids"
          multiple
          collapse-tags
          style="margin-left: 20px;"
          placeholder="Select room">
          <el-option
            v-for="room in this.relationships.rooms"
            :key="room.id"
            :label="room.label"
            :value="room.id">
          </el-option>
        </el-select>
        <el-select
          v-model="filter.teacher_ids"
          multiple
          collapse-tags
          style="margin-left: 20px;"
          placeholder="Select teacher">
          <el-option
            v-for="teacher in this.relationships.teachers"
            :key="teacher.id"
            :label="teacher.full_name"
            :value="teacher.id">
          </el-option>
        </el-select>
        <el-select
          v-model="filter.subject_ids"
          multiple
          collapse-tags
          style="margin-left: 20px;"
          placeholder="Select subject">
          <el-option
            v-for="subject in this.relationships.subjects"
            :key="subject.id"
            :label="subject.name"
            :value="subject.id">
          </el-option>
        </el-select>
      </el-col>
      <el-col :span="2" class="text-align-right">
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
import GroupService from "../services/GroupService"
import RoomService from "../services/RoomService"
import TeacherService from "../services/TeacherService"
import SubjectService from "../services/SubjectService"

const groupService = new GroupService()
const roomService = new RoomService()
const teacherService = new TeacherService()
const subjectService = new SubjectService()
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
      deleteDialogLesson: {id: 0},
      relationships: {
        groups: [],
        rooms: [],
        teachers: [],
        subjects: []
      },
      filter: {
        group_ids: [],
        room_ids: [],
        teacher_ids: [],
        subject_ids: [],
        dates: []
      },
      datePickerOptions: {
        shortcuts: [{
          text: 'This week',
          onClick(picker) {
            const end = new Date();
            const start = new Date();
            end.setTime(end.getTime() + 3600 * 1000 * 24 * 7);
            picker.$emit('pick', [start, end]);
          }
        }, {
          text: 'Last week',
          onClick(picker) {
            const end = new Date();
            const start = new Date();
            start.setTime(start.getTime() - 3600 * 1000 * 24 * 7);
            picker.$emit('pick', [start, end]);
          }
        }, {
          text: 'Last month',
          onClick(picker) {
            const end = new Date();
            const start = new Date();
            start.setTime(start.getTime() - 3600 * 1000 * 24 * 30);
            picker.$emit('pick', [start, end]);
          }
        }, {
          text: 'Last 3 months',
          onClick(picker) {
            const end = new Date();
            const start = new Date();
            start.setTime(start.getTime() - 3600 * 1000 * 24 * 90);
            picker.$emit('pick', [start, end]);
          }
        }]
      }
    }
  },
  mounted() {
    this.getTimetable(),
    groupService.get().then(response => this.relationships.groups = response.data)
    roomService.get().then(response => this.relationships.rooms = response.data)
    teacherService.get().then(response => this.relationships.teachers = response.data)
    subjectService.get().then(response => this.relationships.subjects = response.data)
  },
  watch: {
    filter: {
      handler() {
        clearTimeout(this.timeout)
        this.timeout = setTimeout(() => {
          this.getTimetable()
        }, 500)
      },
      deep: true
    }
  },
  methods: {
    async getTimetable() {
      await this.axios.get('/api/lessons/timetable', {
        params: this.filter
      })
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
