const bcrypt = require('bcrypt');
const { User } = require('../models');
const schema = require('../validation')
const Validator = require('fastest-validator')
const v = new Validator;

module.exports = {
    login: async (req, res, next) => {
        try {
            const user = await User.authenticate(req.body);
            const accessToken = user.generateToken();
            console.log(accessToken);


            return res.status(200).json({
                status: 'OK',
                message: 'Login Success',
                data: {
                    id: user.id,
                    nama: user.nama,
                    email: user.email,
                    token: accessToken
                }
            });
        } catch (err) {
            next(err);
        }
    },
}