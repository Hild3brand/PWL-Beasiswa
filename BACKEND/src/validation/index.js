const auth = require('./auth');
const user = require('./user');
const fakultas = require('./fakultas');
const role = require('./role');
const program_studi = require('./program_studi');
const periode = require('./periode');
const beasiswa = require('./beasiswa');

module.exports = { 
    auth, 
    user, 
    fakultas, 
    role, 
    program_studi, 
    periode, 
    beasiswa 
};