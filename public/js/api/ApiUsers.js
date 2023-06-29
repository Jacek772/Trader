class ApiUsers extends Api{
    static baseRoute = "users"

    static async getUsers(query = {})
    {
        return await this.get(`${this.baseUrl}/${this.baseRoute}`, { ...query })
    }

    static async getUserById(iduser)
    {
        return await this.get(`${this.baseUrl}/${this.baseRoute}/one`, { iduser })
    }

    static async createUser(data)
    {
        return await this.post(`${this.baseUrl}/${this.baseRoute}`, { ...data  })
    }

    static async deleteUsers(ids)
    {
        return await this.post(`${this.baseUrl}/${this.baseRoute}/delete`, { ids })
    }

    static async updateUser(data)
    {
        return await this.post(`${this.baseUrl}/${this.baseRoute}/update`, { ...data  })
    }
}