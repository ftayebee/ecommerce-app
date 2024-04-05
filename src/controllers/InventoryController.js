import { ref, reactive } from 'vue'
import router from './../router'
import { ApiController } from './ApiController'

const inventoryController = reactive({
    inventories: [],
    
    async getAllInventories(endPoint, data) {
        const res = await ApiController.fetchProtectedApi(endPoint, data ,"GET")
        this.inventories = res.inventories
    },

    async saveInventory(data = {}, endPoint = "") {
        const res = await ApiController.fetchProtectedApi(endPoint, data ,"POST")
            .then((response) => {
                if (response.status == 200) {
                    alert(response.message);
                    router.push('/inventories')
                }
            })
            .catch((error) => {
                console.log(error);
            });
    },

    async deleteInventory(id) {
        try {
            const response = await ApiController.fetchProtectedApi(`/api/auth/inventories/destroy/${id}`, "", "DELETE");
            if (response.status === 200) {
                alert("Inventory deleted successfully.");
                route.push('/inventories')
            }
        } catch (error) {
            console.error("Error deleting inventory:", error);
        }
    }
})

export { inventoryController }