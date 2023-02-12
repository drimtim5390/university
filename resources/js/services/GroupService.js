const axios = require('axios')

export default class GroupService {
  async get(params = {}) {
    const response = await axios.get('/api/groups', {
      params: params
    })
    return response.data
  }
}
