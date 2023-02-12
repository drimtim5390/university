const axios = require('axios')

export default class TeacherService {
  async get(params = {}) {
    const response = await axios.get('/api/teachers', {
      params: params
    })
    return response.data
  }
}
