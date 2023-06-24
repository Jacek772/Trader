class ApiUnits extends Api
{
    static baseRoute = "units"

    static async getAllUnits()
    {
        return await this.get(`${this.baseUrl}/${this.baseRoute}`)
    }
}