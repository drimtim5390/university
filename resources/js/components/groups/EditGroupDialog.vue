<template>
  <el-dialog :title="`Edit Group #${group.id}`" :visible="visible" :show-close="false">
    <el-form labelPosition="right" :model="form" :rules="rules" ref="groupEditForm" @submit.native.prevent>
      <el-form-item label="Label" prop="label">
        <el-input v-model="form.label"></el-input>
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
  name: "EditGroupDialog",
  props: {
    group: null,
    visible: Boolean
  },
  watch: {
    visible(visible) {
      if (visible) {
        this.$refs['groupEditForm']?.resetFields()
        this.form.fill(this.group)
      }
    }
  },
  data() {
    return {
      form: {
        label: '',
        fill(group) {
          this.label = group.label
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
      this.$refs['groupEditForm'].validate((valid) => {
        if (valid) {
          this.$emit('save', {...this.group, ...this.form})
        } else {
          return false
        }
      });
    },
    close() {
      this.$emit('close')
    },
    validateLabel(rule, value, callback) {
      this.axios.get('/groups/count?label=' + value)
        .then((response) => {
          if ((response.data.length === 0) ||
              (response.data.length === 1 && response.data[0] === this.group.id)) {
            callback()
          } else {
            callback(new Error('Group already exists'))
          }
        })
    }
  }
}
</script>

<style scoped>

</style>
