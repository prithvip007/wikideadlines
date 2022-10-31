class Client {
    constructor() {
        this.basePath = '/api/';
    }

    _resolvePath(path) {
        return `${this.basePath}${path}`;
    }

    _callAPI(path, method, data) {
        const url = this._resolvePath(path);

        return axios[method](url, data);
    }

    disconnectSocialNetwork(networkName) {
        return this._callAPI(`social-auth/${networkName}/disconnect`, 'post');
    }

    updateProfile(data) {
        return this._callAPI('profile', 'put', data);
    }

    sendCodeToUpdatePhoneNumber(data) {
        return this._callAPI('profile/send-code', 'post', data);
    }

    confirmCodeToUpdatePhoneNumber(data) {
        return this._callAPI('profile/confirm-code', 'post', data);
    }

    sendCodeToUpdateEmail(data) {
        return this._callAPI('profile/send-email-code', 'post', data);
    }

    applyToBeInvestor(data) {
        return this._callAPI('investor/apply', 'post', data);
    }

    sendCodeToAuthenticateUserByEmail(data) {
        return this._callAPI('auth/email/send-code', 'post', data);
    }

    confirmCodeToAuthenticateUserByEmail(data) {
        return this._callAPI('auth/email/confirm-code', 'post', data);
    }

    confirmCodeToUpdateEmail(data) {
        return this._callAPI('profile/confirm-email-code', 'post', data);
    }

    createCheckoutSession(data) {
        return this._callAPI('checkout', 'post', data);
    }

    sendCodeToAuthenticateUser(data) {
        return this._callAPI('auth/send-code', 'post', data);
    }

    confirmCodeToAuthenticateUser(data) {
        return this._callAPI('auth/confirm-code', 'post', data);
    }

    sendRequest(data) {
        return this._callAPI('request/send', 'post', data);
    }

    createThumb(deadlineId, data) {
        return this._callAPI(`deadline/${deadlineId}/thumb`, 'post', data);
    }

    deleteThumb(deadlineId, calculationId) {
        const params = new URLSearchParams({ calculation_id: calculationId });
        return this._callAPI(`deadline/${deadlineId}/thumb?${params.toString()}`, 'delete');
    }

    editDeadline(id, data) {
        return this._callAPI(`dashboard/deadline-rule/${id}`, 'patch', data);
    }

    getEditDealineData(deadlineId, requestId = '') {
        const params = new URLSearchParams({ requestId });
        return this._callAPI(`dashboard/deadline-rule/${deadlineId}?${params.toString()}`, 'get');
    }

    createDeadline(data) {
        return this._callAPI(`dashboard/deadline-rule`, 'post', data);
    }

    updateRequest(id, data) {
        return this._callAPI(`dashboard/requests/${id}`, 'patch', data);
    }

    updateDocument(id, data) {
        return this._callAPI(`dashboard/document/${id}`, 'patch', data);
    }

    createDocument(data) {
        return this._callAPI('dashboard/document', 'post', data);
    }

    deleteDeadline(id) {
        return this._callAPI(`dashboard/deadline-rule/${id}`, 'delete');
    }

    deleteDocument(id) {
        return this._callAPI(`dashboard/document/${id}`, 'delete');
    }

    updateDeliveryMethod(id, data) {
        return this._callAPI(`dashboard/delivery-method/${id}`, 'patch', data);
    }

    createDeliveryMethod(data) {
        return this._callAPI('dashboard/delivery-method', 'post', data);
    }

    deleteDeliveryMethod(id) {
        return this._callAPI(`dashboard/delivery-method/${id}`, 'delete');
    }

    getCaseNames(search, page) {
        const params = new URLSearchParams({ search: search || '', page: page || '' });
        return this._callAPI(`calculations/names?${params.toString()}`, 'get');
    }

    getLastActualDataForCaseName(caseName) {
        const params = new URLSearchParams({ caseName });
        return this._callAPI(`calculations/actual-сase-data?${params.toString()}`, 'get');
    }

    updateCountyForCaseName(body) {
        return this._callAPI('calculations/county', 'post', body);
    }

    getCaluclationsByCaseName(caseName, page) {
        const params = new URLSearchParams({ caseName, page: page || '' });
        return this._callAPI(`calculations?${params.toString()}`, 'get');
    }
}

export default Client;

export const client = new Client();
