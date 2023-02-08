<template>
  <el-dialog
    :title="`${itemName} #${item.id}`"
    :visible="visible"
    :show-close="false"
    width="40%">
    <span>{{ message }}</span>
    <span slot="footer" class="dialog-footer">
        <el-button @click="$emit('close')">Cancel</el-button>
        <el-button type="primary" @click="$emit('confirm', item.id)">Confirm</el-button>
      </span>
  </el-dialog>
</template>

<script>
export default {
  name: "DeleteDialog",
  props: {
    message: String,
    visible: Boolean,
    itemName: String,
    item: null
  }
}
</script>

<style scoped>

</style>
