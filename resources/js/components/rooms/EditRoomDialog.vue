<template>
  <el-dialog :title="`Edit Room #${room.id}`" :visible="visible" :show-close="false">
    <el-form labelPosition="right" :model="form" :rules="rules" ref="roomEditForm" @submit.native.prevent>
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
  name: "EditRoomDialog",
  props: {
    room: null,
    visible: Boolean
  },
  watch: {
    visible(visible) {
      if (visible) {
        this.$refs['roomEditForm']?.resetFields()
        this.form.fill(this.room)
      }
    }
  },
  data() {
    return {
      form: {
        label: '',
        fill(room) {
          this.label = room.label
        }
      },
      rules: {
        label: [
          { required: true, message: 'Please input Room label', trigger: 'blur' },
          { min: 2, max: 20, message: 'Length should be 2 to 20', trigger: 'blur' },
          { validator: this.validateLabel, trigger: 'blur' }
        ]
      }
    }
  },
  methods: {
    submit() {
      this.$refs['roomEditForm'].validate((valid) => {
        if (valid) {
          this.$emit('save', {...this.room, ...this.form})
        } else {
          return false
        }
      })
    },
    close() {
      this.$emit('close')
    },
    validateLabel(rule, value, callback) {
      this.axios.get('/api/rooms/count?label=' + value)
        .then((response) => {
          if ((response.data.length === 0) ||
              (response.data.length === 1 && response.data[0] === this.room.id)) {
            callback()
          } else {
            callback(new Error('Room already exists'))
          }
        })
    }
  }
}
</script>

<style scoped>

</style>
