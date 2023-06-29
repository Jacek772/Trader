class ApiDocumentsdefinitions extends Api
{
    static baseRoute = "documentsdefinitions"

    static async getAllDocumentsdefinitions()
    {
        return await this.get(`${this.baseUrl}/${this.baseRoute}`)
    }

    static async createDocumentdefinition(data)
    {
        return await this.post(`${this.baseUrl}/${this.baseRoute}`, { ...data })
    }

    static async updateDocumentdefinition(data)
    {
        return await this.post(`${this.baseUrl}/${this.baseRoute}/update`, { ...data  })
    }

    static async deleteDocumentsdefinitions(ids) {
        return await this.post(`${this.baseUrl}/${this.baseRoute}/delete`, { ids })
    }
}