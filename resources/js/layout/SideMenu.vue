<template>
  <el-menu
    router
    class="el-menu-vertical-demo"
    background-color="inherit"
    hover-background-color="black"
    text-color="inherit"
    active-text-color="#ffd04b">
      <el-menu-item index="/">
        <i class="el-icon-s-grid"></i>
        <span>Timetable</span>
      </el-menu-item>
      <el-menu-item index="groups">
        <i class="el-icon-s-operation"></i>
        <span>Groups</span>
      </el-menu-item>
      <el-menu-item index="teachers">
        <i class="el-icon-user-solid"></i>
        <span>Teachers</span>
      </el-menu-item>
      <el-menu-item index="subjects">
        <i class="el-icon-notebook-1"></i>
        <span>Subjects</span>
      </el-menu-item>
  </el-menu>
</template>

<script>
export default {
  name: "SideMenu"
}
</script>

<style>
.el-aside {
  background: #6d29a8;
  color: white;
  min-height: 100vh;
}

.brand-name {
  background: indigo;
  padding: 8px 20px;
  font-size: 1.2rem;
  text-transform: uppercase;
}

.el-menu {
  border-right: 0 !important;
}

.el-main {
  background: #e8e8e8;
}

.el-menu-item:hover {
  background-color: indigo !important;
}
</style>
