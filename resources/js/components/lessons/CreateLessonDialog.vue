<template>
  <el-dialog title="Create Lesson" :visible="visible" :show-close="false">
    <el-form labelPosition="top" :model="form" :rules="rules" ref="lessonCreateForm" @submit.native.prevent>
      <el-row type="flex" justify="start">
        <el-col>
          <el-form-item prop="date" label="Lesson date">
            <el-date-picker type="date" placeholder="Pick a date" v-model="form.date" format="yyyy-MM-dd" value-format="yyyy-MM-dd"></el-date-picker>
          </el-form-item>
          <el-form-item prop="position" label="Time">
            <el-select v-model="form.position" placeholder="Choose time">
              <el-option label="09:00 — 10:20" :value="1"></el-option>
              <el-option label="10:30 — 11:50" :value="2"></el-option>
              <el-option label="12:30 — 13:50" :value="3"></el-option>
              <el-option label="14:00 — 15:20" :value="4"></el-option>
              <el-option label="15:30 — 16:50" :value="5"></el-option>
              <el-option label="17:00 — 18:20" :value="6"></el-option>
            </el-select>
          </el-form-item>
        </el-col>
        <el-col>
          <el-form-item prop="group_id" label="Group">
            <el-select v-model="form.group_id" filterable placeholder="Select group">
              <el-option
                v-for="group in groups"
                :key="group.id"
                :label="group.label"
                :value="group.id">
              </el-option>
            </el-select>
          </el-form-item>
          <el-form-item prop="teacher_id" label="Teacher">
            <el-select v-model="form.teacher_id" filterable placeholder="Select teacher">
              <el-option
                v-for="teacher in teachers"
                :key="teacher.id"
                :label="teacher.full_name"
                :value="teacher.id">
              </el-option>
            </el-select>
          </el-form-item>
        </el-col>
        <el-col>
          <el-form-item prop="room_id" label="Room">
            <el-select v-model="form.room_id" filterable placeholder="Select room">
              <el-option
                v-for="room in rooms"
                :key="room.id"
                :label="room.label"
                :value="room.id">
              </el-option>
            </el-select>
          </el-form-item>
          <el-form-item prop="subject_id" label="Subject">
            <el-select v-model="form.subject_id" filterable placeholder="Select subject">
              <el-option
                v-for="subject in subjects"
                :key="subject.id"
                :label="subject.name"
                :value="subject.id">
              </el-option>
            </el-select>
          </el-form-item>
        </el-col>
      </el-row>
    </el-form>
    <span slot="footer" class="dialog-footer">
      <el-button @click="close()">Cancel</el-button>
      <el-button type="success" @click="submit()">Save</el-button>
    </span>
  </el-dialog>
</template>
<script>
import GroupService from "../../services/GroupService"
import RoomService from "../../services/RoomService"
import TeacherService from "../../services/TeacherService"
import SubjectService from "../../services/SubjectService"

const groupService = new GroupService()
const roomService = new RoomService()
const teacherService = new TeacherService()
const subjectService = new SubjectService()

export default {
  name: "CreateLessonDialog",
  props: {
    lesson: null,
    visible: Boolean,
  },
  watch: {
    visible(visible) {
      if (visible) {
        this.$refs['lessonCreateForm']?.resetFields()
        this.form.clear()
        if (this.lesson) {
          this.form.fill(this.lesson)
        }
        groupService.get().then(response => this.groups = response.data)
        roomService.get().then(response => this.rooms = response.data)
        teacherService.get().then(response => this.teachers = response.data)
        subjectService.get().then(response => this.subjects = response.data)
      }
    }
  },
  data() {
    return {
      groups: [],
      rooms: [],
      teachers: [],
      subjects: [],
      form: {
        date: null,
        position: null,
        group_id: null,
        room_id: null,
        teacher_id: null,
        subject_id: null,
        clear() {
          this.date = null
          this.position = null
          this.group_id = null
          this.room_id = null
          this.teacher_id = null
          this.subject_id = null
        },
        fill(lesson) {
          this.date = lesson.date
          this.position = lesson.position
          this.group_id = lesson.group_id
          this.room_id = lesson.room_id
          this.teacher_id = lesson.teacher_id
          this.subject_id = lesson.subject_id
        }
      },
      rules: {
        date: [
          { required: true, message: 'Please pick a lesson date', trigger: 'change' }
        ],
        position: [
          { required: true, message: 'Please pick a lesson time', trigger: 'change' }
        ],
        group_id: [
          { required: true, message: 'Please pick a group', trigger: 'change' },
          { validator: this.validateGroup, trigger: 'change' },
        ],
        room_id: [
          { required: true, message: 'Please pick a room', trigger: 'change' },
          { validator: this.validateRoom, trigger: 'change' },
        ],
        teacher_id: [
          { required: true, message: 'Please pick a teacher', trigger: 'change' },
          { validator: this.validateTeacher, trigger: 'change' },
        ],
        subject_id: [
          { required: true, message: 'Please pick a subject', trigger: 'change' }
        ]
      }
    }
  },
  methods: {
    submit() {
      this.$refs['lessonCreateForm'].validate((valid) => {
        if (valid) {
          this.$emit('save', this.form)
        } else {
          return false
        }
      })
    },
    close() {
      this.$emit('close')
    },
    validateGroup(rule, value, callback) {
      if (this.form.date === null || this.form.position === null || this.form.group_id === null) {
        callback()
      }
      this.axios.get('/api/lessons/count', {
        params: {
          date: this.form.date,
          position: this.form.position,
          group_id: this.form.group_id
        }
      })
        .then((response) => {
          if (response.data.length > 0) {
            callback(new Error('Group is on another lesson at this date and time'))
          } else {
            callback()
          }
        })
    },
    validateRoom(rule, value, callback) {
      if (this.form.date === null || this.form.position === null || this.form.room_id === null) {
        callback()
      }
      this.axios.get('/api/lessons/count', {
        params: {
          date: this.form.date,
          position: this.form.position,
          room_id: this.form.room_id
        }
      })
        .then((response) => {
          if (response.data.length > 0) {
            callback(new Error('Room is busy at this date and time'))
          } else {
            callback()
          }
        })
    },
    validateTeacher(rule, value, callback) {
      if (this.form.date === null || this.form.position === null || this.form.teacher_id === null) {
        callback()
      }
      this.axios.get('/api/lessons/count', {
        params: {
          date: this.form.date,
          position: this.form.position,
          teacher_id: this.form.teacher_id
        }
      })
        .then((response) => {
          if (response.data.length > 0) {
            callback(new Error('Teacher is on another lesson at this date and time'))
          } else {
            callback()
          }
        })
    }
  }
}
</script>

<style scoped>

</style>
