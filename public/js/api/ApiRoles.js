class ApiRoles extends Api
{
    static baseRoute = "roles"

    static async getAllRoles()
    {
        return await this.get(`${this.baseUrl}/${this.baseRoute}`)
    }
}