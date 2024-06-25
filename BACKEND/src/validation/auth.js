module.exports = {
    register: {
        nrp: 'string|unique',
        nama: 'string',
        email: 'email',
        password: 'string|min:8',
        status: 'string',
        role_id: 'integer',
        program_studi_id: 'integer',
    }
}