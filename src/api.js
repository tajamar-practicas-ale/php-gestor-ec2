// src/api.js
import axios from 'axios';

// Cambia esta URL según la IP pública o dominio de tu servidor
const URL_BASE = 'http://98.84.116.254:8080/api';

const api = axios.create({
    baseURL: URL_BASE,
    headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
    },
});

// Interceptor para incluir el token JWT en cada request
api.interceptors.request.use(
    config => {
        const token = localStorage.getItem('token');
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
            console.log(token)
        }
        return config;
    },
    error => Promise.reject(error)
);

export default api;
