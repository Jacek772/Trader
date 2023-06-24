class ApiCommodities extends Api
{
    static baseRoute = "commodities"

    static async getCommodities(query)
    {
        return await this.get(`${this.baseUrl}/${this.baseRoute}`, query)
    }

    static async createCommodity(data)
    {
        return await this.post(`${this.baseUrl}/${this.baseRoute}`, { ...data  })
    }

    static async updateCommodity(data)
    {
        return await this.post(`${this.baseUrl}/${this.baseRoute}/update`, { ...data  })
    }

    static async deleteCommodities(ids)
    {
        return await this.post(`${this.baseUrl}/${this.baseRoute}/delete`, { ids })
    }
}