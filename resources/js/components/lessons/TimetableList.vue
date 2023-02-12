<template>
  <el-table
    :data="timetable.data"
    :span-method="getSpanMethod"
    border>
    <el-table-column
      fixed="left"
      prop="group.label"
      label="Group">
      <template slot-scope="scope">
        <div>
          <b>
            <i class="el-icon-s-operation"></i>
            {{ scope.row.group.label }}
          </b>
        </div>
      </template>
    </el-table-column>
    <el-table-column
      prop="position"
      label="Time">
      <template slot-scope="scope">
        <div>
          <b>
            <i class="el-icon-timer"></i>
            <span v-if="scope.row.position === 1">09:00 — 10:20</span>
            <span v-if="scope.row.position === 2">10:30 — 11:50</span>
            <span v-if="scope.row.position === 3">12:30 — 13:50</span>
            <span v-if="scope.row.position === 4">14:00 — 15:20</span>
            <span v-if="scope.row.position === 5">15:30 — 16:50</span>
            <span v-if="scope.row.position === 6">17:00 — 18:20</span>
          </b>
        </div>
      </template>
    </el-table-column>
    <el-table-column
      v-for="(date, index) in timetable.dates"
      :key="index"
      :prop="date"
      :label="date">
      <template slot-scope="scope">
        <div v-if="scope.row[date]">
          <div>
            <i class="el-icon-user"></i>
            {{ scope.row[date].teacher.full_name }}
          </div>
          <div>
            <i class="el-icon-notebook-1"></i>
            <b>{{ scope.row[date].subject.name }}</b>
            <i class="el-icon-location-outline"></i>
            {{ scope.row[date].room.label }}
          </div>
          <div>
            <el-button @click="$emit('showEditDialog', scope.row[date])" type="primary" size="small" icon="el-icon-edit"></el-button>
            <el-button @click="$emit('showDeleteDialog', scope.row[date])" type="danger" size="small" icon="el-icon-delete"></el-button>
          </div>
        </div>
        <div v-else>
          <el-button @click="$emit('showCreateDialog', { date: scope.column.label, position: scope.row.position, group_id: scope.row.group.id })" type="light" size="small" icon="el-icon-plus"></el-button>
        </div>
      </template>
    </el-table-column>
  </el-table>
</template>

<script>
export default {
  name: "TimetableList",
  props: {
    timetable: []
  },
  methods: {
    getSpanMethod({columnIndex, rowIndex}) {
      if (columnIndex > 0) {
        return [1, 1]
      }
      if (rowIndex % 6 === 0) {
        return [6, 1]
      } else {
        return [0, 0]
      }
    }
  }
}
</script>

<style scoped>

</style>
