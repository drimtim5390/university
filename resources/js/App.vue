<template>
  <el-container>
    <el-aside width="250px">
      <div class="brand-name">
        University
        Timetable
      </div>
      <SideMenu/>
    </el-aside>
    <el-container>
      <el-header>
        <BreadCrumb/>
      </el-header>
      <el-main>
        <router-view/>
      </el-main>
    </el-container>
  </el-container>
</template>

<script>
import SideMenu from './layout/SideMenu.vue'
import BreadCrumb from './layout/BreadCrumb.vue'
export default {
  name: 'App',
  components: {
    SideMenu,
    BreadCrumb
  }
}
</script>

<style>
body {
  margin: 0;
}

.mb-20 {
  margin-bottom: 20px;
}

.text-header {
  font-size: 1.5rem;
}

.text-align-right {
  text-align: right;
}
</style>
