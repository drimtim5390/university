<template>
  <el-dialog
    :title="`${item} #${itemId}`"
    :visible="visible"
    :show-close="false"
    width="40%">
    <span>{{ message }}</span>
    <span slot="footer" class="dialog-footer">
        <el-button @click="$emit('close')">Cancel</el-button>
        <el-button type="primary" @click="$emit('confirm', itemId)">Confirm</el-button>
      </span>
  </el-dialog>
</template>

<script>
export default {
  name: "DeleteDialog",
  props: {
    message: String,
    visible: Boolean,
    item: String,
    itemId: Number
  }
}
</script>

<style scoped>

</style>
