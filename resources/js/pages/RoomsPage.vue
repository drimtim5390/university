<template>
  <el-container direction="vertical">
    <el-row class="mb-20">
      <el-col :span="12" class="text-header">
        Rooms
      </el-col>
      <el-col :span="12">
        <el-row type="flex" justify="end">
          <el-col :span="18">
            <el-input
              v-model="params.label"
              size="small"
              placeholder="Type to search"/>
          </el-col>
          <el-col :span="6" class="text-align-right">
            <el-button type="success" icon="el-icon-plus" size="small" @click="showCreateDialog()">Create</el-button>
          </el-col>
        </el-row>
      </el-col>
    </el-row>
    <CreateRoomDialog :visible="createDialogVisible"
                         @save="storeRoom"
                         @close="createDialogVisible = false"/>
    <EditRoomDialog :room="editDialogRoom"
                       :visible="editDialogVisible"
                       @save="updateRoom"
                       @close="editDialogVisible = false"/>
    <DeleteDialog :message="'Do you really want to delete a room with id #' + deleteDialogRoom.id"
                  :itemName="'Room'"
                  :item="deleteDialogRoom"
                  :visible="deleteDialogVisible"
                  @confirm="deleteRoom"
                  @close="deleteDialogVisible = false"/>
    <RoomsList :rooms="rooms"
                  @search="getRooms"
                  @showEditDialog="showEditDialog"
                  @showDeleteDialog="showDeleteDialog"/>
    <el-row type="flex" justify="end">
      <el-pagination
        @size-change="getRooms"
        @current-change="getRooms"
        :current-page.sync="params.page"
        :page-sizes="[10, 20, 30, 40, 50, 100]"
        :page-size.sync="params.size"
        layout="total, sizes, prev, pager, next, jumper"
        :total="total">
      </el-pagination>
    </el-row>
  </el-container>
</template>

<script>
import CreateRoomDialog from "../components/rooms/CreateRoomDialog.vue";
import EditRoomDialog from "../components/rooms/EditRoomDialog.vue";
import RoomsList from "../components/rooms/RoomsList.vue";
import DeleteDialog from "../components/DeleteDialog.vue";

export default {
  name: "RoomsPage",
  components: {CreateRoomDialog, DeleteDialog, EditRoomDialog, RoomsList},
  data() {
    return {
      total: 0,
      rooms: [],
      createDialogVisible: false,
      editDialogVisible: false,
      editDialogRoom: {id: 0},
      deleteDialogVisible: false,
      deleteDialogRoom: {id: 0},
      params: {
        size: 10,
        page: 1,
        label: ''
      },
      timeout: null
    }
  },
  mounted() {
    this.getRooms();
  },
  watch: {
    params: {
      handler() {
        clearTimeout(this.timeout);
        this.timeout = setTimeout(() => {
          this.getRooms()
        }, 500)
      },
      deep: true
    }
  },
  methods: {
    async getRooms() {
      await this.axios.get('/rooms', {
        params: this.params
      })
        .then(response => {
          this.rooms = response.data.data
          this.total = response.data.total
        })
        .catch(() => {
          this.rooms = []
        })
    },
    showCreateDialog() {
      this.createDialogVisible = true
    },
    showEditDialog(room) {
      this.editDialogRoom = room
      this.editDialogVisible = true
    },
    showDeleteDialog(room) {
      this.deleteDialogRoom = room
      this.deleteDialogVisible = true
    },
    storeRoom(room) {
      this.axios.post('/rooms', room)
        .then(() => {
          this.$message({
            message: 'Room has successfully been created',
            type: 'success'
          })
          this.createDialogVisible = false;
          this.getRooms()
        })
    },
    updateRoom(room) {
      this.axios.put(`/rooms/${room.id}`, room)
        .then(() => {
          this.$message({
            message: 'Room has successfully been updated',
            type: 'success'
          })
          this.editDialogVisible = false;
          this.getRooms()
        })
    },
    deleteRoom(id) {
      this.axios.delete(`/rooms/${id}`)
        .then(() => {
          this.$message({
            message: 'Room has successfully been deleted',
            type: 'success'
          })
          this.getRooms()
        })
      this.deleteDialogVisible = false
    }
  }
}
</script>

<style scoped>

</style>
