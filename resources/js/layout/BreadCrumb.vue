<template>
  <el-container>
    <el-breadcrumb separator-class="el-icon-arrow-right">
      <el-breadcrumb-item :to="{name: 'timetable'}">Timetable</el-breadcrumb-item>
    </el-breadcrumb>
  </el-container>
</template>

<script>
export default {
  name: "BreadCrumb"
}
</script>

<style scoped>
.el-container {
  padding: 23px 5px;
}
</style>
