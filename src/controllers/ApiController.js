import { ref, reactive } from 'vue'
import router from '../router'

const ApiController = reactive({
    
    apiBase: 'http://127.0.0.1:8000',
    
    isAuthenticated: localStorage.getItem('auth') == 1,
    
    user: JSON.parse(localStorage.getItem('user')),
    
    async fetchPublicApi(endPoint = "", params = "", requestType = "GET") {
        let request = {
            method: requestType.toUpperCase(),
            headers: {
                "Access-Control-Allow-Origin": "*",
                Accept: "application/vnd.api+json",
                "Content-Type": "application/vnd.api+json",
            },
        }

        if (requestType.toUpperCase() == "POST" || "PUT" == requestType.toUpperCase()) {
            request.body = JSON.stringify(params);
        }

        const res = await fetch(ApiController.apiBase + endPoint, request);

        const response = await res.json();
        return response;
    },
    
    async fetchProtectedApi(endPoint = "", params = "", requestType = "GET") {
        const token = ApiController.getUserToken()
        let request = {
            method: requestType.toUpperCase(),
            headers: {
                "Access-Control-Allow-Origin": "*",
                Accept: "application/vnd.api+json",
                "Content-Type": "application/vnd.api+json",
                'Authorization': `Bearer ${token}`,
            },
        }

        if (requestType.toUpperCase() == "POST" || "PUT" == requestType.toUpperCase()) {
            request.body = JSON.stringify(params);
        }

        const res = await fetch(ApiController.apiBase + endPoint, request);

        const response = await res.json();
        return response;
    },
    
    authenticate(username, password) {
        ApiController.fetchPublicApi('/api/login', { email: username, password }, 'POST')
            .then(res => {
                if (res.status == 200) {
                    ApiController.isAuthenticated = true
                    ApiController.user = res
                    localStorage.setItem('auth', 1)
                    localStorage.setItem('user', JSON.stringify(res))
                    router.push('/')
                }
            });
    },

    register(username, email, password, confirmPassword) {
        ApiController.fetchPublicApi('/api/register', { name: username, email, password, confirmPassword }, 'POST')
            .then(res => {
                if (res.status == 201) {
                    ApiController.authenticate(email, password)
                }
            });
    },

    logout() {
        ApiController.isAuthenticated = false
        ApiController.user = {}
        localStorage.setItem('auth', 0)
        localStorage.setItem('user', '{}')
        cart.items = {}
        cart.saveCartInLocalStorage()
        wishlist.items = []
        router.push('/login')
    },

    getUserToken() {
        return ApiController.user.accessToken
    }
})

export { ApiController }