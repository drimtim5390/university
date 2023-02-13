const axios = require('axios')
const RESOURCE = '/api/lessons'
export default class LessonService {
  async getTimetable(params = {}) {
    const response = await axios.get(`${RESOURCE}/timetable`, {
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

  async store(lesson) {
    const response = await axios.post(RESOURCE, lesson)
    return response.data
  }

  async update(lesson) {
    const response = await axios.put(`${RESOURCE}/${lesson.id}`, lesson)
    return response.data
  }

  async delete(id) {
    const response = await axios.delete(`${RESOURCE}/${id}`)
    return response.data
  }
}
