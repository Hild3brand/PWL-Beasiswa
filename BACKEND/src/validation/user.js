module.exports = {
    create: {
        nrp: 'string|unique',
        nama: 'string',
        email: 'email',
        password: 'string',
        status: 'string',
        role_id: 'number',
        program_studi_id: 'number',
    },
    update: {
        nama: 'string',
        email: 'email',
        password: 'string',
        status: 'string',
        role_id: 'number',
        program_studi_id: 'number',
    },
}