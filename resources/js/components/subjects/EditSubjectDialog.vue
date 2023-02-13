<template>
  <el-dialog :title="`Edit Subject #${subject.id}`" :visible="visible" :show-close="false">
    <el-form labelPosition="right" :model="form" :rules="rules" ref="subjectEditForm" @submit.native.prevent>
      <el-form-item label="Name" prop="name">
        <el-input v-model="form.name"></el-input>
      </el-form-item>
    </el-form>
    <span slot="footer" class="dialog-footer">
      <el-button @click="close()">Cancel</el-button>
      <el-button type="success" @click="submit()">Save</el-button>
    </span>
  </el-dialog>
</template>

<script>
import SubjectService from "../../services/SubjectService"

const subjectService = new SubjectService()

export default {
  name: "EditSubjectDialog",
  props: {
    subject: null,
    visible: Boolean
  },
  watch: {
    visible(visible) {
      if (visible) {
        this.$refs['subjectEditForm']?.resetFields()
        this.form.fill(this.subject)
      }
    }
  },
  data() {
    return {
      form: {
        name: '',
        fill(subject) {
          this.name = subject.name
        }
      },
      rules: {
        name: [
          { required: true, message: 'Please input Subject name', trigger: 'blur' },
          { min: 2, max: 255, message: 'Length should be 2 to 255', trigger: 'blur' },
          { validator: this.validateName, trigger: 'blur' }
        ]
      }
    }
  },
  methods: {
    submit() {
      this.$refs['subjectEditForm'].validate((valid) => {
        if (valid) {
          this.$emit('save', {...this.subject, ...this.form})
        } else {
          return false
        }
      })
    },
    close() {
      this.$emit('close')
    },
    validateName(rule, value, callback) {
      subjectService.count({name: value})
        .then((response) => {
          if ((response.length === 0) ||
              (response.length === 1 && response[0] === this.subject.id)) {
            callback()
          } else {
            callback(new Error('Subject already exists'))
          }
        })
    }
  }
}
</script>

<style scoped>

</style>
