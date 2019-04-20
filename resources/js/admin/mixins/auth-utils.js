export const AuthUtils = {
  methods: {
    hasRole(userObject, roleName) {
      var roles = this.getRoles(userObject)
      
      return roles.includes(roleName);
    },
    getRoles(userObject) {
      var roles = []
      for (let roleObject of userObject.roles) {
        roles.push(roleObject.name)
      }

      return roles
    }
  }
}
