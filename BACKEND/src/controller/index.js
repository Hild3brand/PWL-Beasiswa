const auth = require('./auth_controller');
const fakultas = require('./fakultas_controller');
const prodi = require('./prodi_controller');
const user = require('./user_controller');
const verifyToken = require('./verify_token_controller');
const role = require('./role_controller');
const periode = require('./periode_controller');
const beasiswa = require('./beasiswa_controller');

module.exports = {
    auth,
    fakultas,
    prodi,
    user,
    verifyToken,
    role,
    periode,
    beasiswa
};