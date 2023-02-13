const axios = require('axios')
const RESOURCE = '/api/groups'
export default class GroupService {
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

  async store(group) {
    const response = await axios.post(RESOURCE, group)
    return response.data
  }

  async update(group) {
    const response = await axios.put(`${RESOURCE}/${group.id}`, group)
    return response.data
  }

  async delete(id) {
    const response = await axios.delete(`${RESOURCE}/${id}`)
    return response.data
  }
}
