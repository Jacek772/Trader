class ApiExchanges extends Api{
    static baseRoute = "exchanges"

    static async getExchangesAll()
    {
        return await this.get(`${this.baseUrl}/${this.baseRoute}`)
    }

    static async getExchanges(query)
    {
        return await this.get(`${this.baseUrl}/${this.baseRoute}`, query)
    }

    static async importExchanges(days)
    {
        return this.post(`${this.baseUrl}/${this.baseRoute}/import`, { days });
    }
}