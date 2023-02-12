const axios = require('axios')

export default class RoomService {
  async get(params = {}) {
    const response = await axios.get('/api/rooms', {
      params: params
    })
    return response.data
  }
}
