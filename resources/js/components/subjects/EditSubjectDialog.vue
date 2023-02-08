<template>
  <el-dialog :title="`Edit Subject #${subject.id}`" :visible="visible" :show-close="false">
    <el-form labelPosition="right" :model="form" :rules="rules" ref="subjectEditForm">
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
export default {
  name: "EditSubjectDailog",
  props: {
    visible: Boolean,
    subject: null
  },
  watch: {
    subject(subject) {
      this.form.name = subject.name
    }
  },
  data() {
    return {
      form: {
        name: ''
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
          this.$refs['subjectEditForm'].resetFields()
        } else {
          return false
        }
      });
    },
    close() {
      this.$refs['subjectEditForm'].resetFields()
      this.$emit('close')
    },
    validateName(rule, value, callback) {
      this.axios.get('/subjects/count?name=' + value)
        .then((response) => {
          if ((response.data.length === 0) ||
              (response.data.length === 1 && response.data[0] === this.subject.id)) {
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
