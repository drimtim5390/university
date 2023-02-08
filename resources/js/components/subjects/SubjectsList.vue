<template>
  <el-table
    :data="subjects"
    style="width: 100%">
    <el-table-column
      fixed
      prop="id"
      label="ID"
      width="120">
    </el-table-column>
    <el-table-column
      prop="name"
      label="Name">
    </el-table-column>
    <el-table-column
      fixed="right"
      label="Actions">
      <template slot-scope="scope">
        <el-row type="flex" justify="end">
          <el-button @click="$emit('showEditDialog', scope.row)" type="primary" size="small" icon="el-icon-edit">Edit</el-button>
          <el-button @click="$emit('showDeleteDialog', scope.row.id)" type="danger" size="small" icon="el-icon-delete">Delete</el-button>
        </el-row>
      </template>
    </el-table-column>
  </el-table>
</template>

<script>
export default {
  name: "SubjectsList",
  props: {
    subjects: []
  }
}
</script>

<style scoped>

</style>
