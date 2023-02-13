const axios = require('axios')
const RESOURCE = '/api/teachers'
export default class TeacherService {
  async get(params = {}) {
    const response = await axios.get(RESOURCE, {
      params: params
    })
    return response.data
  }

  async store(teacher) {
    const response = await axios.post(RESOURCE, teacher)
    return response.data
  }

  async update(teacher) {
    const response = await axios.put(`${RESOURCE}/${teacher.id}`, teacher)
    return response.data
  }

  async delete(id) {
    const response = await axios.delete(`${RESOURCE}/${id}`)
    return response.data
  }
}
