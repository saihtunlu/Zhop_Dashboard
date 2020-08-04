export default class gate {
    constructor(user) {
        this.user = user;
    }
    isAdmin() {
        return true;
    }




    isUser_Read() {
        return this.user.permission_user.read === 1;
    }
    isUser_Create() {
        return this.user.permission_user.create === 1;
    }
    isUser_Update() {
        return this.user.permission_user.update === 1;
    }
    isUser_Delete() {
        return this.user.permission_user.delete === 1;
    }


    isInvoice_Read() {
        return this.user.permission_invoice.read === 1;
    }
    isInvoice_Create() {
        return this.user.permission_invoice.create === 1;
    }
    isInvoice_Update() {
        return this.user.permission_invoice.update === 1;
    }
    isInvoice_Delete() {
        return this.user.permission_invoice.delete === 1;
    }
}
