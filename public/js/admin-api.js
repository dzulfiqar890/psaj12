/**
 * Admin API Helper
 * Mengelola request ke API dengan autentikasi (Session/Token)
 */

const Api = {
    baseUrl: '/api/v1',

    /**
     * Generic fetch wrapper
     */
    async request(endpoint, options = {}) {
        const url = `${this.baseUrl}${endpoint}`;
        
        const defaultHeaders = {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest' // Penting untuk cek Ajax di Laravel
        };

        // Jika menggunakan token auth (bukan cookie/session), uncomment di bawah ini:
        // const token = localStorage.getItem('token');
        // if (token) {
        //    defaultHeaders['Authorization'] = `Bearer ${token}`;
        // }

        const config = {
            ...options,
            headers: {
                ...defaultHeaders,
                ...options.headers
            },
            // credentials: 'include' // Kirim cookie (session) secara otomatis
        };

        try {
            const response = await fetch(url, config);
            
            // Handle 401 Unauthorized (Session expired)
            if (response.status === 401) {
                window.location.href = '/login'; // Redirect ke login page
                throw new Error('Unauthorized');
            }

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || 'Terjadi kesalahan pada server');
            }

            return data;
        } catch (error) {
            console.error('API Error:', error);
            throw error;
        }
    },

    get(endpoint) {
        return this.request(endpoint, { method: 'GET' });
    },

    post(endpoint, body) {
        return this.request(endpoint, {
            method: 'POST',
            body: JSON.stringify(body)
        });
    },

    put(endpoint, body) {
        return this.request(endpoint, {
            method: 'PUT',
            body: JSON.stringify(body)
        });
    },

    delete(endpoint) {
        return this.request(endpoint, { method: 'DELETE' });
    },
    
    // Format currency IDR
    formatRupiah(number) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(number);
    }
};

// Global Exposure
window.Api = Api;
