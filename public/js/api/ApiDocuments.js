class ApiDocuments extends Api{
    static baseRoute = "documents"

    static async getDocuments(query)
    {
        return await this.get(`${this.baseUrl}/${this.baseRoute}`, query)
    }

    static async createDocument(data)
    {
        return await this.post(`${this.baseUrl}/${this.baseRoute}`, { ...data  })
    }

    static async updateDocument(data)
    {
        return await this.post(`${this.baseUrl}/${this.baseRoute}/update`, { ...data  })
    }

    static async deleteDocuments(ids)
    {
        return await this.post(`${this.baseUrl}/${this.baseRoute}/delete`, { ids })
    }
}


