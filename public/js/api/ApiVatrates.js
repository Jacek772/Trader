class ApiVatrates extends Api
{
    static baseRoute = "vatrates"

    static async getAllVatrates()
    {
        return await this.get(`${this.baseUrl}/${this.baseRoute}`)
    }
}