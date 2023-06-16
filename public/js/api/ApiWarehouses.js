 class ApiWarehouses extends Api{
     static baseRoute = "warehouses"

     static async getAllWarehouses()
     {
        return await this.get(`${this.baseUrl}/${this.baseRoute}`)
     }
 }