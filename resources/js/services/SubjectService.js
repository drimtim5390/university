const axios = require('axios')

export default class SubjectService {
  async get(params = {}) {
    const response = await axios.get('/api/subjects', {
      params: params
    })
    return response.data
  }
}
