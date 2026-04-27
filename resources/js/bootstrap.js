// Importar Axios para hacer solicitudes HTTP
import axios from 'axios';

// Hacer Axios disponible globalmente
window.axios = axios;

// Configurar headers por defecto para incluir CSRF token en solicitudes AJAX
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
