<template>
  <el-dialog title="Create Subject" :visible="visible" :show-close="false">
    <el-form labelPosition="right" :model="form" :rules="rules" ref="subjectCreateForm" @submit.native.prevent>
      <el-form-item label="Name" prop="name">
        <el-input v-model="form.name"/>
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
  name: "CreateSubjectDialog",
  props: {
    visible: Boolean
  },
  watch: {
    visible(visible) {
      if (visible) {
        this.$refs['subjectCreateForm']?.resetFields()
        this.form.clear()
      }
    }
  },
  data() {
    return {
      form: {
        name: '',
        clear() {
          this.name = ''
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
      this.$refs['subjectCreateForm'].validate((valid) => {
        if (valid) {
          this.$emit('save', this.form)
          this.$refs['subjectCreateForm'].resetFields()
        } else {
          return false
        }
      })
    },
    close() {
      this.$refs['subjectCreateForm'].resetFields()
      this.$emit('close')
    },
    validateName(rule, value, callback) {
      subjectService.count({name: value})
        .then((response) => {
          if (response.length > 0) {
            callback(new Error('Subject already exists'))
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
