class ApiContractors extends Api{
    static baseRoute = "contractors"

    static async getAllContractors()
    {
        return await this.get(`${this.baseUrl}/${this.baseRoute}`)
    }
}