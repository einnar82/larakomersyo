import axios from 'axios'

const httpClient = (options = {}) => axios.create({
    baseURL: import.meta.env.VITE_API_BASE_URL || 'http://localhost/api/',
    ...options
})

export default httpClient
