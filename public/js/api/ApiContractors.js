class ApiContractors extends Api{
    static baseRoute = "contractors"

    static async getAllContractors()
    {
        return await this.get(`${this.baseUrl}/${this.baseRoute}`)
    }

    static async createContractor(data)
    {
        return await this.post(`${this.baseUrl}/${this.baseRoute}`, { ...data  })
    }

    static async updateContractor(data)
    {
        return await this.post(`${this.baseUrl}/${this.baseRoute}/update`, { ...data  })
    }

    static async deleteContractors(ids)
    {
        return await this.post(`${this.baseUrl}/${this.baseRoute}/delete`, { ids })
    }
}