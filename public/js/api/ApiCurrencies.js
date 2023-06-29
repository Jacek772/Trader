class ApiCurrencies extends Api
{
    static baseRoute = "currencies"

    static async getAllCurrencies()
    {
        return await this.get(`${this.baseUrl}/${this.baseRoute}`)
    }
}