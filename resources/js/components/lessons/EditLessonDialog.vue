<template>
  <el-dialog title="Edit Lesson" :visible="visible" :show-close="false">
    <el-form labelPosition="top" :model="form" :rules="rules" ref="lessonEditForm" @submit.native.prevent>
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
import LessonService from "../../services/LessonService"

const lessonService = new LessonService()
const groupService = new GroupService()
const roomService = new RoomService()
const teacherService = new TeacherService()
const subjectService = new SubjectService()

export default {
  name: "EditLessonDialog",
  props: {
    lesson: null,
    visible: Boolean,
  },
  watch: {
    visible(visible) {
      if (visible) {
        this.$refs['lessonEditForm']?.resetFields()
        this.form.fill(this.lesson)
        groupService.get({size: 1000}).then(response => this.groups = response.data)
        roomService.get({size: 1000}).then(response => this.rooms = response.data)
        teacherService.get({size: 1000}).then(response => this.teachers = response.data)
        subjectService.get({size: 1000}).then(response => this.subjects = response.data)
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
      this.$refs['lessonEditForm'].validate((valid) => {
        if (valid) {
          this.$emit('save', {...this.lesson, ...this.form})
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
      } else {
        lessonService.count({date: this.form.date, position: this.form.position, group_id: this.form.group_id})
          .then((response) => {
            if ((response.length === 0) ||
              (response.length === 1 && response[0] === this.lesson.id)) {
              callback()
            } else {
              callback(new Error('Group is on another lesson at this date and time'))
            }
          })
      }
    },
    validateRoom(rule, value, callback) {
      if (this.form.date === null || this.form.position === null || this.form.room_id === null) {
        callback()
      } else {
        lessonService.count({date: this.form.date, position: this.form.position, group_id: this.form.group_id})
          .then((response) => {
            if ((response.length === 0) ||
              (response.length === 1 && response[0] === this.lesson.id)) {
              callback()
            } else {
              callback(new Error('Room is busy at this date and time'))
            }
          })
      }
    },
    validateTeacher(rule, value, callback) {
      if (this.form.date === null || this.form.position === null || this.form.teacher_id === null) {
        callback()
      } else {
        lessonService.count({date: this.form.date, position: this.form.position, group_id: this.form.group_id})
          .then((response) => {
            if ((response.length === 0) ||
              (response.length === 1 && response[0] === this.lesson.id)) {
              callback()
            } else {
              callback(new Error('Teacher is on another lesson at this date and time'))
            }
          })
      }
    }
  }
}
</script>

<style scoped>

</style>
