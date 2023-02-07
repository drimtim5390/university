<template>
  <div id="app">
    <el-container>
      <el-aside width="250px">
        <div class="brand-name">
          University
          Timetable
        </div>
      </el-aside>
      <el-container>
        <el-header>
        </el-header>
        <el-main>
        </el-main>
      </el-container>
    </el-container>
  </div>
</template>

<script>
export default {
  name: 'App',
  components: {}
}
</script>

<style>
body {
  margin: 0;
}

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
</style>
