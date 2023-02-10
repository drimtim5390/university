<template>
  <el-dialog title="Create Group" :visible="visible" :show-close="false">
    <el-form labelPosition="right" :model="form" :rules="rules" ref="groupCreateForm" @submit.native.prevent>
      <el-form-item label="Label" prop="label">
        <el-input v-model="form.label"/>
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
  name: "CreateGroupDialog",
  props: {
    visible: Boolean
  },
  watch: {
    visible(visible) {
      if (visible) {
        this.$refs['groupCreateForm']?.resetFields()
        this.form.clear()
      }
    }
  },
  data() {
    return {
      form: {
        label: '',
        clear() {
          this.label = ''
        }
      },
      rules: {
        label: [
          { required: true, message: 'Please input Group label', trigger: 'blur' },
          { min: 2, max: 20, message: 'Length should be 2 to 20', trigger: 'blur' },
          { validator: this.validateLabel, trigger: 'blur' }
        ]
      }
    }
  },
  methods: {
    submit() {
      this.$refs['groupCreateForm'].validate((valid) => {
        if (valid) {
          this.$emit('save', this.form)
          this.$refs['groupCreateForm'].resetFields()
        } else {
          return false
        }
      });
    },
    close() {
      this.$refs['groupCreateForm'].resetFields()
      this.$emit('close')
    },
    validateLabel(rule, value, callback) {
      this.axios.get('/groups/count?label=' + value)
        .then((response) => {
          if (response.data.length > 0) {
            callback(new Error('Group already exists'))
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
