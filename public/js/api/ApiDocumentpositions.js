class ApiDocumentpositions extends Api{
    static baseRoute = "documentspositions"

    static async createDocumentposition(data)
    {
        return await this.post(`${this.baseUrl}/${this.baseRoute}`, { ...data  })
    }

    static async deleteDocumentpositions(ids)
    {
        return await this.post(`${this.baseUrl}/${this.baseRoute}/delete`, { ids })
    }
}