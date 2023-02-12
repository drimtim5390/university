<template>
  <el-dialog :title="`Edit Teacher #${teacher.id}`" :visible="visible" :show-close="false">
    <el-form labelPosition="right" :model="form" :rules="rules" ref="teacherEditForm" @submit.native.prevent>
      <el-form-item label="First Name" prop="first_name">
        <el-input v-model="form.first_name"/>
      </el-form-item>
      <el-form-item label="Last Name" prop="last_name">
        <el-input v-model="form.last_name"/>
      </el-form-item>
    </el-form>
    <span slot="footer" class="dialog-footer">
      <el-button @click="close()">Cancel</el-button>
      <el-button type="success" @click="submit()">Save</el-button>
    </span>
  </el-dialog>
</template>

<script>
export default {
  name: "EditTeacherDialog",
  props: {
    visible: Boolean,
    teacher: null
  },
  watch: {
    visible(visible) {
      if (visible) {
        this.$refs['teacherEditForm']?.resetFields()
        this.form.fill(this.teacher)
      }
    }
  },
  data() {
    return {
      form: {
        first_name: '',
        last_name: '',
        fill(teacher) {
          this.first_name = teacher.first_name
          this.last_name = teacher.last_name
        }
      },
      rules: {
        first_name: [
          { required: true, message: 'Please input Teacher\' first name', trigger: 'blur' },
          { min: 2, max: 50, message: 'Length should be 2 to 50', trigger: 'blur' }
        ],
        last_name: [
          { required: true, message: 'Please input Teacher\' last name', trigger: 'blur' },
          { min: 2, max: 50, message: 'Length should be 2 to 50', trigger: 'blur' }
        ]
      }
    }
  },
  methods: {
    submit() {
      this.$refs['teacherEditForm'].validate((valid) => {
        if (valid) {
          this.$emit('save', {...this.teacher, ...this.form})
        } else {
          return false
        }
      })
    },
    close() {
      this.$emit('close')
    }
  }
}
</script>

<style scoped>

</style>
