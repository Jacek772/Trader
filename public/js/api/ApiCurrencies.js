class ApiCurrencies extends Api
{
    static baseRoute = "currencies"

    static async GetAllCurrencies()
    {
        return await this.get(`${this.baseUrl}/${this.baseRoute}`)
    }
}