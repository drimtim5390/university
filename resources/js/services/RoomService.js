const axios = require('axios')
const RESOURCE = '/api/rooms'
export default class RoomService {
  async get(params = {}) {
    const response = await axios.get(RESOURCE, {
      params: params
    })
    return response.data
  }

  async count(params = {}) {
    const response = await axios.get(`${RESOURCE}/count`, {
      params: params
    })
    return response.data
  }

  async store(room) {
    const response = await axios.post(RESOURCE, room)
    return response.data
  }

  async update(room) {
    const response = await axios.put(`${RESOURCE}/${room.id}`, room)
    return response.data
  }

  async delete(id) {
    const response = await axios.delete(`${RESOURCE}/${id}`)
    return response.data
  }
}
