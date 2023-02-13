const axios = require('axios')
const RESOURCE = '/api/subjects'
export default class SubjectService {
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

  async store(subject) {
    const response = await axios.post(RESOURCE, subject)
    return response.data
  }

  async update(subject) {
    const response = await axios.put(`${RESOURCE}/${subject.id}`, subject)
    return response.data
  }

  async delete(id) {
    const response = await axios.delete(`${RESOURCE}/${id}`)
    return response.data
  }
}
