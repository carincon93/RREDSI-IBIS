import moment from 'moment'

export const route = window.route

export function checkPermission(authUser, permissionsId) {
    let findPermissions = []
    findPermissions = permissionsId.map((permissionId) => {
        return authUser.can.find((element) => element == permissionId) == permissionId
    })

    return findPermissions.find((element) => element == true) == true
}

export function checkPermissionByUser(authUser, permissionsId) {
    let findPermissions = []
    findPermissions = permissionsId.map((permissionId) => {
        return authUser.can_by_user.find((element) => element == permissionId) == permissionId
    })

    return findPermissions.find((element) => element == true) == true
}

export function checkRole(authUser, rolesId) {
    let findRoles = []

    findRoles = rolesId.map((roleId) => {
        return (
            authUser.roles.filter(function (role) {
                return role.id == roleId
            }).length > 0
        )
    })

    return findRoles.find((element) => element == true) == true
}

export function monthDiff(d1, d2) {
    let monthDifference = 0
    monthDifference = moment(new Date(d2)).diff(new Date(d1), 'months', true)

    return monthDifference.toFixed(1)
}
